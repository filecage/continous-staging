<?php

    namespace Tholabs\ContinousStaging\GitHub\Webhook;

    class Payload {

        /**
         * @var string
         */
        private $jsonPayload;

        /**
         * @var array
         */
        private $payload;

        /**
         * @param string $jsonPayload
         */
        function __construct (string $jsonPayload) {
            $this->jsonPayload = $jsonPayload;
        }

        /**
         * @return string
         */
        function getPayloadString () : string {
            return $this->jsonPayload;
        }

        /**
         * @return array
         */
        function getPayloadAsArray () : array {
            if (!isset($this->payload)) {
                $this->payload = json_decode($this->getPayloadString(), true);
            }

            return $this->payload;
        }

    }