<?php

    namespace Tholabs\ContinousStaging\GitHub\Events;

    use Tholabs\ContinousStaging\GitHub\Webhook\Payload;

    class Event {

        /**
         * @var string
         */
        private $type;

        /**
         * @var Payload
         */
        private $payload;

        /**
         * @param string $type
         */
        function __construct (string $type, Payload $payload) {
            $this->type = $type;
            $this->payload = $payload;
        }

        /**
         * @return string
         */
        function getType () : string {
            return $this->type;
        }

        /**
         * @return Payload
         */
        function getPayload () : Payload {
            return $this->payload;
        }

    }