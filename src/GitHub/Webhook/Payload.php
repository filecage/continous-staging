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

        /**
         * @param string $key
         *
         * @return bool
         */
        function hasSubPayload (string $key) : bool {
            return isset($this->getPayloadAsArray()[$key]);
        }

        /**
         * @param string $key
         *
         * @return null|Payload
         */
        function getSubPayload (string $key) : ?Payload {
            if (!$this->hasSubPayload($key)) {
                return null;
            }

            return $this->createSubPayloadFromData($this->getPayloadAsArray()[$key]);
        }

        /**
         * @param string $key
         *
         * @return \Iterator
         */
        function getSubPayloadsIterator (string $key) : \Iterator {
            if (!$this->hasSubPayload($key)) {
                return new \Generator();
            }

            $subPayloadData = $this->getPayloadAsArray()[$key];
            if (!is_array($subPayloadData)) {
                $subPayloadData = [$subPayloadData];
            }

            foreach ($subPayloadData as $subPayload) {
                yield $this->createSubPayloadFromData($subPayload);
            }
        }

        /**
         * @param array $subPayloadData
         *
         * @return Payload
         */
        private function createSubPayloadFromData (array $subPayloadData) : Payload {
            $subPayload = clone $this;
            $subPayload->payload = $subPayloadData;
            $subPayload->jsonPayload = json_encode($subPayload->payload, JSON_PRETTY_PRINT);

            return $subPayload;
        }

    }