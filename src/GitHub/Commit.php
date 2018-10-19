<?php

    namespace Tholabs\ContinousStaging\GitHub;

    use Tholabs\ContinousStaging\GitHub\Webhook\Payload;

    class Commit {

        /**
         * @var CommitHead
         */
        private $head;

        /**
         * @var Contributor
         */
        private $author;

        /**
         * @var Contributor
         */
        private $committer;

        /**
         * @var Filelist
         */
        private $addedFiles;

        /**
         * @var Filelist
         */
        private $removedFiles;

        /**
         * @var Filelist
         */
        private $modifiedFiles;

        /**
         * @param Payload $payload
         *
         * @return Commit
         */
        static function createFromPayload (Payload $payload) : Commit {
            $commitHead = CommitHead::createFromPayload($payload);
            $author = Contributor::createFromPayload($payload->getSubPayload('author'));
            $committer = Contributor::createFromPayload($payload->getSubPayload('committer'));

            $addedFiles = new Filelist(...$payload->getPayloadAsArray()['added']);
            $removedFiles = new Filelist(...$payload->getPayloadAsArray()['removed']);
            $modifiedFiles = new Filelist(...$payload->getPayloadAsArray()['modified']);

            return new Commit($commitHead, $author, $committer, $addedFiles, $removedFiles, $modifiedFiles);
        }

        /**
         * @param CommitHead $head
         * @param Contributor $author
         * @param Contributor $committer
         * @param Filelist $addedFiles
         * @param Filelist $removedFiles
         * @param Filelist $modifiedFiles
         */
        function __construct (CommitHead $head, Contributor $author, Contributor $committer, Filelist $addedFiles, Filelist $removedFiles, Filelist $modifiedFiles) {
            $this->head = $head;
            $this->author = $author;
            $this->committer = $committer;
            $this->addedFiles = $addedFiles;
            $this->removedFiles = $removedFiles;
            $this->modifiedFiles = $modifiedFiles;
        }

        /**
         * @return CommitHead
         */
        function getHead () : CommitHead {
            return $this->head;
        }

        /**
         * @return Contributor
         */
        function getAuthor () : Contributor {
            return $this->author;
        }

        /**
         * @return Contributor
         */
        function getCommitter () : Contributor {
            return $this->committer;
        }

        /**
         * @return Filelist
         */
        function getAddedFiles () : Filelist {
            return $this->addedFiles;
        }

        /**
         * @return Filelist
         */
        function getRemovedFiles () : Filelist {
            return $this->removedFiles;
        }

        /**
         * @return Filelist
         */
        function getModifiedFiles () : Filelist {
            return $this->modifiedFiles;
        }

    }