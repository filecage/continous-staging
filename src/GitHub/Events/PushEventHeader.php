<?php

    namespace Tholabs\ContinousStaging\GitHub\Events;

    use Tholabs\ContinousStaging\GitHub\Webhook\Payload;

    class PushEventHeader {

        /**
         * @var string
         */
        private $ref;

        /**
         * @var string
         */
        private $beforeCommitId;

        /**
         * @var string
         */
        private $afterCommitId;

        /**
         * @var bool
         */
        private $created;

        /**
         * @var bool
         */
        private $deleted;

        /**
         * @var bool
         */
        private $forced;

        /**
         * @var null|string
         */
        private $baseRef;

        /**
         * @var string
         */
        private $compareUrl;

        /**
         * @param Payload $payload
         *
         * @return PushEventHeader
         */
        static function createFromPayload (Payload $payload) : PushEventHeader {
            $payload = $payload->getPayloadAsArray();
            
            return new PushEventHeader(
                $payload['ref'],
                $payload['before'],
                $payload['after'],
                $payload['created'],
                $payload['deleted'],
                $payload['forced'],
                $payload['base_ref'],
                $payload['compare']
            );
        }

        /**
         * @param string $ref
         * @param string $beforeCommitId
         * @param string $afterCommitId
         * @param bool $created
         * @param bool $deleted
         * @param bool $forced
         * @param null|string $baseRef
         * @param string $compareUrl
         */
        function __construct (string $ref, string $beforeCommitId, string $afterCommitId, bool $created, bool $deleted, bool $forced, ?string $baseRef, string $compareUrl) {
            $this->ref = $ref;
            $this->beforeCommitId = $beforeCommitId;
            $this->afterCommitId = $afterCommitId;
            $this->created = $created;
            $this->deleted = $deleted;
            $this->forced = $forced;
            $this->baseRef = $baseRef;
            $this->compareUrl = $compareUrl;
        }

        /**
         * @return string
         */
        function getRef () : string {
            return $this->ref;
        }

        /**
         * @return string
         */
        function getBeforeCommitId () : string {
            return $this->beforeCommitId;
        }

        /**
         * @return string
         */
        function getAfterCommitId () : string {
            return $this->afterCommitId;
        }

        /**
         * @return bool
         */
        function isCreated () : bool {
            return $this->created;
        }

        /**
         * @return bool
         */
        function isDeleted () : bool {
            return $this->deleted;
        }

        /**
         * @return bool
         */
        function isForced () : bool {
            return $this->forced;
        }

        /**
         * @return null|string
         */
        function getBaseRef () : ?string {
            return $this->baseRef;
        }

        /**
         * @return string
         */
        function getCompareUrl () : string {
            return $this->compareUrl;
        }

    }