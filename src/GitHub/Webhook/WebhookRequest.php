<?php

    namespace Tholabs\ContinousStaging\GitHub\Webhook;

    use Tholabs\ContinousStaging\GitHub\Events\Event;
    use Tholabs\ContinousStaging\GitHub\Events\PushEvent;

    class WebhookRequest {

        /**
         * @return WebhookRequest
         */
        static function createFromRequest () {
            $signature = Signature::createFromHeaderString($_SERVER['HTTP_X_HUB_SIGNATURE'] ?? '');
            $header = new Header($_SERVER['HTTP_X_GITHUB_EVENT'] ?? '', $_SERVER['HTTP_X_GITHUB_DELIVERY'] ?? '', $signature);
            $payload = new Payload(file_get_contents('php://input'));

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
                    return PushEvent::createFromPayload($this->payload->getSubPayload('payload'));
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