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
         * @var CloneUrls
         */
        private $cloneUrls;

        /**
         * @param Payload $payload
         *
         * @return Repository
         */
        static function createFromPayload (Payload $payload) : Repository {
            $cloneUrls = CloneUrls::createFromPayload($payload);
            $owner = Contributor::createFromPayload($payload->getSubPayload('owner'));
            $payload = $payload->getPayloadAsArray();

            return new Repository($payload['id'], $payload['node_id'], $payload['name'], $payload['full_name'], $payload['private'], $owner, $payload['url'], $cloneUrls);
        }

        /**
         * @param int $id
         * @param string $nodeId
         * @param string $name
         * @param string $fullName
         * @param bool $private
         * @param Contributor $owner
         * @param string $url
         * @param CloneUrls $cloneUrls
         */
        function __construct (int $id, string $nodeId, string $name, string $fullName, bool $private, Contributor $owner, string $url, CloneUrls $cloneUrls) {
            $this->id = $id;
            $this->nodeId = $nodeId;
            $this->name = $name;
            $this->fullName = $fullName;
            $this->private = $private;
            $this->owner = $owner;
            $this->url = $url;
            $this->cloneUrls = $cloneUrls;
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
         * @return CloneUrls
         */
        function getCloneUrls () : CloneUrls {
            return $this->cloneUrls;
        }

    }