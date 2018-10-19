<?php

    namespace Tholabs\ContinousStaging\GitHub\Events;

    class Event {

        /**
         * @var string
         */
        private $type;

        /**
         * @param string $type
         */
        function __construct (string $type) {
            $this->type = $type;
        }

        /**
         * @return string
         */
        function getType () : string {
            return $this->type;
        }

    }