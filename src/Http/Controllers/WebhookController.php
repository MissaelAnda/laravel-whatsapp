<?php

namespace MissaelAnda\Whatsapp\Http\Controllers;

use MissaelAnda\Whatsapp\Http\Middleware\VerifyWebhookSignature;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use MissaelAnda\Whatsapp\Events\SubscriptionIntentReceived;
use MissaelAnda\Whatsapp\Events\SuccessfullySubscribed;
use MissaelAnda\Whatsapp\Events\UnprocessableWebhookPayload;
use MissaelAnda\Whatsapp\Events\WebhookEntry;
use MissaelAnda\Whatsapp\Events\WebhookReceived;
use MissaelAnda\Whatsapp\Exceptions\InvalidWebhookEntryException;
use MissaelAnda\Whatsapp\Utils;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class WebhookController extends Controller
{
    public function __construct()
    {
        if (Config::get('whatsapp.webhook.verify_signature')) {
            $this->middleware(VerifyWebhookSignature::class)->only('handle');
        }
    }

    /**
     * Verification request
     * 
     * @link https://developers.facebook.com/docs/graph-api/webhooks/getting-started#verification-requests
     */
    public function subscribe(Request $request)
    {
        $verificationCode = Config::get('whatsapp.webhook.verify_token');

        SubscriptionIntentReceived::dispatch($request->ip(), $data = $request->query());

        if (
            empty($verificationCode) ||
            empty($challenge = $request->input('hub_challenge')) ||
            $request->input('hub_mode') !== 'subscribe' ||
            $verificationCode !== $request->input('hub_verify_token')
        ) {
            throw new AccessDeniedHttpException;
        }

        SuccessfullySubscribed::dispatch($request->ip(), $data);

        return new Response($challenge);
    }

    /**
     * Notifications
     */
    public function handle(Request $request)
    {
        if (!$request->isJson()) {
            throw new BadRequestHttpException('Request must be a valid json.');
        }

        $payload = json_decode($request->getContent(), true);

        WebhookReceived::dispatch($payload);

        try {
            $object = Utils::extract($payload, 'object');
            if ($object !== 'whatsapp_business_account') {
                throw new InvalidWebhookEntryException($object);
            }

            $this->dispatchEntries($payload);
        } catch (\Exception $e) {
            UnprocessableWebhookPayload::dispatch($e);
        }

        return new Response;
    }

    protected function dispatchEntries(array $payload)
    {
        foreach (Utils::extract($payload, 'entry') as $entry) {
            $accountId = Utils::extract($entry, 'id');

            foreach (Utils::extract($entry, 'changes') as $change) {
                [$type, $data] = Utils::extract($change, ['field', 'value']);

                event(WebhookEntry::build($accountId, $type, $data));
            }
        }
    }
}
