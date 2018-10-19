<?php

    namespace Tholabs\ContinousStaging\GitHub;

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