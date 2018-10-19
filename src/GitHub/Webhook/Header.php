<?php

    namespace Tholabs\ContinousStaging\GitHub\Webhook;

    class Header {

        /**
         * @var string
         */
        private $event;

        /**
         * @var string
         */
        private $delivery;

        /**
         * @var Signature
         */
        private $signature;

        /**
         * @param string $event
         * @param string $delivery
         * @param Signature $signature
         */
        function __construct (string $event, string $delivery, Signature $signature) {
            $this->event = $event;
            $this->delivery = $delivery;
            $this->signature = $signature;
        }

        /**
         * @return string
         */
        function getEvent () : string {
            return $this->event;
        }

        /**
         * @return string
         */
        function getDelivery () : string {
            return $this->delivery;
        }

        /**
         * @return Signature
         */
        function getSignature () : Signature {
            return $this->signature;
        }

    }