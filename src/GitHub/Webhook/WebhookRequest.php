<?php

    namespace Tholabs\ContinousStaging\GitHub\Webhook;

    use Tholabs\ContinousStaging\Exceptions\BadWebhookRequest;
    use Tholabs\ContinousStaging\GitHub\Events\Event;
    use Tholabs\ContinousStaging\GitHub\Events\PushEvent;

    class WebhookRequest {

        /**
         * @return WebhookRequest
         * @throws BadWebhookRequest
         */
        static function createFromRequest () {
            $signature = Signature::createFromHeaderString($_SERVER['HTTP_X_HUB_SIGNATURE'] ?? '');
            if (!isset($_SERVER['HTTP_X_GITHUB_EVENT'])) {
                throw new BadWebhookRequest('Missing X-GitHub-Event header');
            }

            if (!isset($_SERVER['HTTP_X_GITHUB_DELIVERY'])) {
                throw new BadWebhookRequest('Missing X-GitHub-Delivery header');
            }

            $header = new Header($_SERVER['HTTP_X_GITHUB_EVENT'], $_SERVER['HTTP_X_GITHUB_DELIVERY'], $signature);
            $contentType = $_SERVER['CONTENT_TYPE'] ?? null;
            if (strtolower($contentType) === 'application/json') {
                $payload = new Payload(file_get_contents('php://input'));
            } else {
                throw new BadWebhookRequest('Unsupported content-type, please use application/json');
            }

            return new WebhookRequest($header, $payload);
        }

        /**
         * @var Header
         */
        private $header;

        /**
         * @var Payload
         */
        private $payload;

        /**
         * @param Header $header
         * @param Payload $payload
         */
        function __construct (Header $header, Payload $payload) {
            $this->header = $header;
            $this->payload = $payload;
        }

        /**
         * @return Event
         */
        function getEvent () : Event {
            switch ($this->header->getEvent()) {
                case PushEvent::EVENT_KEY:
                    return PushEvent::createFromPayload($this->payload);
            }

            return new Event($this->header->getEvent());
        }

        /**
         * @param string $secret
         *
         * @return bool
         */
        function isSignedWithSecret (string $secret) : bool {
            $signature = $this->header->getSignature();
            if ($signature->getAlgorithm() !== 'sha1') {
                return false; // https://developer.github.com/webhooks/securing
            }

            $payloadHash = hash_hmac($signature->getAlgorithm(), $this->payload->getPayloadString(), $secret);

            return ($payloadHash === $signature->getSignature());
        }

    }