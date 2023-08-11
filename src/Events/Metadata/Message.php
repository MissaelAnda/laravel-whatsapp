<?php

namespace MissaelAnda\Whatsapp\Events\Metadata;

use Illuminate\Support\Carbon;

/**
 * The message object. For more information check the docs.
 * @link https://developers.facebook.com/docs/whatsapp/cloud-api/webhooks/components#messages-object
 *
 * @property ?string $caption [video] The caption for the video, if provided.
 * @property ?string $filename [video] The name for the file on the sender's device.
 * @property ?string $sha256 [video] The hash for the video.
 * @property ?string $id [video] The ID for the video.
 * @property ?string $mime_type [video] The mime type for the video file.
 *
 * @property ?string $body [text] The text of the message.
 *
 * @property ?string $body [system] Describes the change to the customer's identity or phone number.
 * @property ?string $identity [system] Hash for the identity fetched from server.
 * @property ?string $new_wa_id [system] New WhatsApp ID for the customer when their phone number is updated. Available on webhook versions v11.0 and earlier.
 * @property ?string $wa_id [system] New WhatsApp ID for the customer when their phone number is updated. Available on webhook versions v12.0 and later.
 * @property ?string $type [system] Type of system update. Will be one of the following:
 * - customer_changed_number – A customer changed their phone number.
 * - customer_identity_changed – A customer changed their profile information.
 * @property ?string $customer [system] The WhatsApp ID for the customer prior to the update.
 *
 * @property ?string $mime_type [sticker|image|document|audio] The attachment mimetype.
 * @property ?string $sha256 [sticker|image|document] Hash for the sticker.
 * @property ?string $id [sticker|image|document|audio] ID for the sticker.
 * @property ?bool $animated [sticker] Set to true if the sticker is animated; false otherwise.
 * @property ?string $caption [image|document] Caption for the image, if provided.
 * @property ?string $filename [document] Name for the file on the sender's device.
 *
 * @property ?string $source_url [referral] The Meta URL that leads to the ad or post clicked by the customer. Opening this url takes you to the ad viewed by your customer.
 * @property ?string $source_type [referral] The type of the ad’s source; ad or post.
 * @property ?string $source_id [referral] Meta ID for an ad or a post.
 * @property ?string $headline [referral] Headline used in the ad or post.
 * @property ?string $body [referral] Body for the ad or post.
 * @property ?string $media_type [referral] Media present in the ad or post; image or video.
 * @property ?string $image_url [referral] URL of the image, when media_type is an image.
 * @property ?string $video_url [referral] URL of the video, when media_type is a video.
 * @property ?string $thumbnail_url [referral] URL for the thumbnail, when media_type is a video.
 *
 * @property ?string catalog_id [order] ID for the catalog the ordered item belongs to.
 * @property ?string text [order] Text message from the user sent along with the order.
 * @property ?array product_items [order] product item objects containing the following fields:
 * - product_retailer_id — String. Unique identifier of the product in a catalog.
 * - quantity — String. Number of items.
 * - item_price — String. Price of each item.
 * - currency — String. Price currency.
 *
 * @property ?array $type [interactive] Object with the following properties:
 * - button_reply – Sent when a customer clicks a button. Object with the following properties:
 *    - - id — String. Unique ID of a button.
 *    - - title — String. Title of a button.
 * - list_reply — Sent when a customer selects an item from a list. Object with the following properties:
 *    - - id — String. Unique ID of the selected list item.
 *    - - title — String. Title of the selected list item.
 *    - - description — String. Description of the selected row.
 *
 * @property ?string $acknowledged [string] State of acknowledgment for the messages system customer_identity_changed.
 * @property ?string $created_timestamp [string] The time when the WhatsApp Business Management API detected the customer may have changed their profile information.
 * @property ?string $hash [string] The ID for the messages system customer_identity_changed
 * 
 * 
 * @property ?bool $forwarded [context] Set to true if the message received by the business has been forwarded.
 * @property ?bool $frequently_forwarded [context] Set to true if the message received by the business has been forwarded more than 5 times.
 * @property ?string $from [context] The WhatsApp ID for the customer who replied to an inbound message.
 * @property ?string $id [context] The message ID for the sent message for an inbound reply.
 * @property ?array $referred_product [context] Referred product object describing the product the user is requesting information about. You must parse this value if you support Product Enquiry Messages. See Receive Response From Customers. Referred product objects have the following properties:
 *                       - catalog_id — String. Unique identifier of the Meta catalog linked to the WhatsApp Business Account.
 *                       - product_retailer_id — String. Unique identifier of the product in a catalog.
 *
 * @property ?string $payload [button] The payload for a button set up by the business that a customer clicked as part of an interactive message.
 * @property ?string $text [button] Button text.
 */
class Message
{
    public function __construct(
        public string $wamId,
        public string $from,
        public Carbon $timestamp,
        public string $type,
        public array $data,
    ) {
        // 
    }

    public function __get($name)
    {
        return $this->data[$name] ?? null;
    }
}
