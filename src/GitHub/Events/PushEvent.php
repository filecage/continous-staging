<?php

    namespace Tholabs\ContinousStaging\GitHub\Events;

    use Tholabs\ContinousStaging\GitHub\Commit;
    use Tholabs\ContinousStaging\GitHub\Repository;
    use Tholabs\ContinousStaging\GitHub\Webhook\Payload;

    class PushEvent extends Event {
        const EVENT_KEY = 'push';

        /**
         * @var PushEventHeader
         */
        private $header;

        /**
         * @var Commit
         */
        private $headCommit;

        /**
         * @var Repository
         */
        private $repository;

        /**
         * @var Commit[]
         */
        private $commits;

        /**
         * @param Payload $payload
         *
         * @return PushEvent
         */
        static function createFromPayload (Payload $payload) : PushEvent {
            $header = PushEventHeader::createFromPayload($payload);
            $headCommit = Commit::createFromPayload($payload->getSubPayload('head_commit'));
            $repository = Repository::createFromPayload($payload->getSubPayload('repository'));
            $commits = array_map(function (Payload $commitPayload){
                return Commit::createFromPayload($commitPayload);
            }, iterator_to_array($payload->getSubPayloadsIterator('commits')));

            return new PushEvent($header, $headCommit, $repository, ...$commits);
        }

        /**
         * @param PushEventHeader $header
         * @param Commit $headCommit
         * @param Repository $repository
         * @param Commit ...$commits
         */
        function __construct (PushEventHeader $header, Commit $headCommit, Repository $repository, Commit ...$commits) {
            parent::__construct(self::EVENT_KEY);
            $this->header = $header;
            $this->headCommit = $headCommit;
            $this->repository = $repository;
            $this->commits = $commits;
        }

        /**
         * @return PushEventHeader
         */
        function getHeader () : PushEventHeader {
            return $this->header;
        }

        /**
         * @return Commit
         */
        function getHeadCommit () : Commit {
            return $this->headCommit;
        }

        /**
         * @return Repository
         */
        function getRepository () : Repository {
            return $this->repository;
        }

        /**
         * @return Commit[]
         */
        function getCommits () : iterable {
            return $this->commits;
        }

    }