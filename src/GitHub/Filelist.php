<?php

    namespace Tholabs\ContinousStaging\GitHub;

    class Filelist {

        /**
         * @var string[]
         */
        private $files;

        /**
         * @param string ...$files
         */
        function __construct (string ...$files) {
            $this->files = $files;
        }

        /**
         * @return bool
         */
        function hasFiles () : bool {
            return !empty($this->files);
        }

        /**
         * @return array
         */
        function getFiles () : array {
            return $this->files;
        }

    }