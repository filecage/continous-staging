<?php

    namespace Tholabs\ContinousStaging\GitHub;

    use Tholabs\ContinousStaging\GitHub\Webhook\Payload;

    class CloneUrls {

        /**
         * @var string
         */
        private $git;

        /**
         * @var string
         */
        private $ssh;

        /**
         * @var string
         */
        private $http;

        /**
         * @var string
         */
        private $svn;

        /**
         * @param Payload $payload
         *
         * @return CloneUrls
         */
        static function createFromPayload (Payload $payload) : CloneUrls {
            $payload = $payload->getPayloadAsArray();

            return new CloneUrls($payload['git_url'], $payload['ssh_url'], $payload['clone_url'], $payload['svn_url']);
        }

        /**
         * @param string $git
         * @param string $ssh
         * @param string $http
         * @param string $svn
         */
        function __construct (string $git, string $ssh, string $http, string $svn) {
            $this->git = $git;
            $this->ssh = $ssh;
            $this->http = $http;
            $this->svn = $svn;
        }

        /**
         * @return string
         */
        function getGit () : string {
            return $this->git;
        }

        /**
         * @return string
         */
        function getSsh () : string {
            return $this->ssh;
        }

        /**
         * @return string
         */
        function getHttp () : string {
            return $this->http;
        }

        /**
         * @param string $username
         *
         * @return string
         */
        function getHttpWithUsername (string $username) : string {
            return str_replace('github.com', $username . '@github.com', $this->getHttp());
        }

        /**
         * @param string $username
         * @param string $password
         *
         * @return string
         */
        function getHttpWithUsernameAndPassword (string $username, string $password) : string {
            return str_replace('github.com', $username . ':' . $password . '@github.com', $this->getHttp());
        }

        /**
         * @return string
         */
        function getSvn () : string {
            return $this->svn;
        }

    }