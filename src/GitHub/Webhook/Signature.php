<?php

    namespace Tholabs\ContinousStaging\GitHub\Webhook;

    class Signature {

        /**
         * @var string
         */
        private $algorithm;
        /**
         * @var string
         */
        private $signature;

        /**
         * @param string $signatureHeader
         *
         * @return Signature
         */
        static function createFromHeaderString (string $signatureHeader) : Signature {
            $explodedHeader = explode('=', $signatureHeader);

            return new Signature($explodedHeader[0], $explodedHeader[1]);
        }

        /**
         * @param string $algorithm
         * @param string $signature
         */
        function __construct (string $algorithm, string $signature) {
            $this->algorithm = $algorithm;
            $this->signature = $signature;
        }

        /**
         * @return string
         */
        function getAlgorithm () : string {
            return $this->algorithm;
        }

        /**
         * @return string
         */
        function getSignature () : string {
            return $this->signature;
        }

    }