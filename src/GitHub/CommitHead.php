<?php

    namespace Tholabs\ContinousStaging\GitHub;

    use DateTime;
    use Tholabs\ContinousStaging\GitHub\Webhook\Payload;

    class CommitHead {

        /**
         * @var string
         */
        private $id;
        /**
         * @var string
         */
        private $message;
        /**
         * @var DateTime
         */
        private $timestamp;
        /**
         * @var string
         */
        private $url;

        /**
         * @param Payload $payload
         *
         * @return CommitHead
         */
        static function createFromPayload (Payload $payload) : CommitHead {
            $payload = $payload->getPayloadAsArray();

            return new CommitHead($payload['id'], $payload['message'], new DateTime($payload['timestamp']), $payload['url']);
        }

        /**
         * @param string $id
         * @param string $message
         * @param DateTime $timestamp
         * @param string $url
         */
        function __construct (string $id, string $message, DateTime $timestamp, string $url) {
            $this->id = $id;
            $this->message = $message;
            $this->timestamp = $timestamp;
            $this->url = $url;
        }

        /**
         * @return string
         */
        function getId () : string {
            return $this->id;
        }

        /**
         * @return string
         */
        function getMessage () : string {
            return $this->message;
        }

        /**
         * @return DateTime
         */
        function getTimestamp () : DateTime {
            return $this->timestamp;
        }

        /**
         * @return string
         */
        function getUrl () : string {
            return $this->url;
        }

    }