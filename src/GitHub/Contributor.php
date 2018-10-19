<?php

    namespace Tholabs\ContinousStaging\GitHub;

    use Tholabs\ContinousStaging\GitHub\Webhook\Payload;

    class Contributor {

        /**
         * @var string
         */
        private $name;

        /**
         * @var string
         */
        private $email;

        /**
         * @var string
         */
        private $username;

        /**
         * @param Payload $payload
         *
         * @return Contributor
         */
        static function createFromPayload (Payload $payload) : Contributor {
            $payload = $payload->getPayloadAsArray();

            return new Contributor($payload['name'], $payload['email'], $payload['username'] ?? null);
        }

        /**
         * @param string $name
         * @param string $email
         * @param string $username
         */
        function __construct (string $name, string $email, ?string $username) {
            $this->name = $name;
            $this->email = $email;
            $this->username = $username;
        }

        /**
         * @return string
         */
        function getName () : string {
            return $this->name;
        }

        /**
         * @return string
         */
        function getEmail () : string {
            return $this->email;
        }

        /**
         * @return bool
         */
        function hasUsername () : bool {
            return $this->getUsername() !== null;
        }

        /**
         * @return string
         */
        function getUsername () : ?string {
            return $this->username;
        }

    }