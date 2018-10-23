<?php

    namespace Tholabs\ContinousStaging\GitHub\Webhook;

    use Tholabs\ContinousStaging\Exceptions\BadWebhookRequest;

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
         * @throws BadWebhookRequest
         */
        static function createFromHeaderString (string $signatureHeader) : Signature {
            $explodedHeader = explode('=', $signatureHeader);
            if ($explodedHeader[0] === null || $explodedHeader[1] === null) {
                throw new BadWebhookRequest('Signature header is invalid');
            }

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