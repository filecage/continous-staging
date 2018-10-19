<?php

    namespace Tholabs\ContinousStaging\GitHub;

    use Tholabs\ContinousStaging\GitHub\Webhook\Payload;

    class Repository {

        /**
         * @var int
         */
        private $id;

        /**
         * @var string
         */
        private $nodeId;

        /**
         * @var string
         */
        private $name;

        /**
         * @var string
         */
        private $fullName;

        /**
         * @var bool
         */
        private $private;

        /**
         * @var Contributor
         */
        private $owner;

        /**
         * @var string
         */
        private $url;

        /**
         * @var string
         */
        private $gitUrl;

        /**
         * @var string
         */
        private $sshUrl;

        /**
         * @var string
         */
        private $httpCloneUrl;

        /**
         * @param Payload $payload
         *
         * @return Repository
         */
        static function createFromPayload (Payload $payload) : Repository {
            $owner = Contributor::createFromPayload($payload->getSubPayload('owner'));
            $payload = $payload->getPayloadAsArray();

            return new Repository($payload['id'], $payload['node_id'], $payload['name'], $payload['full_name'], $payload['private'], $owner, $payload['url'], $payload['git_url'], $payload['ssh_url'], $payload['clone_url']);
        }

        /**
         * @param int $id
         * @param string $nodeId
         * @param string $name
         * @param string $fullName
         * @param bool $private
         * @param Contributor $owner
         * @param string $url
         * @param string $gitUrl
         * @param string $sshUrl
         * @param string $httpCloneUrl
         */
        function __construct (int $id, string $nodeId, string $name, string $fullName, bool $private, Contributor $owner, string $url, string $gitUrl, string $sshUrl, string $httpCloneUrl) {
            $this->id = $id;
            $this->nodeId = $nodeId;
            $this->name = $name;
            $this->fullName = $fullName;
            $this->private = $private;
            $this->owner = $owner;
            $this->url = $url;
            $this->gitUrl = $gitUrl;
            $this->sshUrl = $sshUrl;
            $this->httpCloneUrl = $httpCloneUrl;
        }

        /**
         * @return int
         */
        function getId () : int {
            return $this->id;
        }

        /**
         * @return string
         */
        function getNodeId () : string {
            return $this->nodeId;
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
        function getFullName () : string {
            return $this->fullName;
        }

        /**
         * @return bool
         */
        function isPrivate () : bool {
            return $this->private;
        }

        /**
         * @return Contributor
         */
        function getOwner () : Contributor {
            return $this->owner;
        }

        /**
         * @return string
         */
        function getUrl () : string {
            return $this->url;
        }

        /**
         * @return string
         */
        function getGitUrl () : string {
            return $this->gitUrl;
        }

        /**
         * @return string
         */
        function getSshUrl () : string {
            return $this->sshUrl;
        }

        /**
         * @return string
         */
        function getHttpCloneUrl () : string {
            return $this->httpCloneUrl;
        }

    }