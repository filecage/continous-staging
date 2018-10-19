<?php

    namespace Tholabs\ContinousStaging\GitHub\Events;

    use Tholabs\ContinousStaging\GitHub\Webhook\Payload;

    class PushEvent extends Event {
        const EVENT_KEY = 'push';

        /**
         * @param Payload $payload
         */
        function __construct (Payload $payload) {
            parent::__construct(self::EVENT_KEY, $payload);
        }


    }