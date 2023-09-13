<?php

namespace MissaelAnda\Whatsapp\Events\Metadata;

use MissaelAnda\Whatsapp\Utils;

class MessageContext
{
    public function __construct(
        /**
         * The WhatsApp ID for the customer who replied to an inbound message.
         */
        public string $from,

        /**
         * The message ID for the sent message for an inbound reply.
         */
        public string $id,

        /**
         * et to true if the message received by the business has been forwarded.
         */
        public bool $forwarded,

        /**
         * Set to true if the message received by the business has been forwarded more than 5 times.
         */
        public bool $frequently_forwarded,

        /**
         * Referred product object describing the product the user is requesting information about.
         * You must parse this value if you support Product Enquiry Messages. See Receive Response From Customers. 
         * Referred product objects have the following properties:
         *   - catalog_id String Unique identifier of the Meta catalog linked to the WhatsApp Business Account.
         *   - product_retailer_id String Unique identifier of the product in a catalog.
         * 
         * @var array{catalog_id:string,product_retailer_id:string}|null
         */
        public ?array $referredProduct,
    ) {
        // 
    }

    public static function fromPayload(array $payload): ?static
    {
        if (!isset($payload['context'])) {
            return null;
        }

        $context = $payload['context'];
        return new static(
            Utils::extract($context, 'from'),
            Utils::extract($context, 'id'),
            $context['forwarded'] ?? false,
            $context['frequently_forwarded'] ?? false,
            $context['referred_product'] ?? null,
        );
    }
}
