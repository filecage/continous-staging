<?php

    require_once 'vendor/autoload.php';

    $webhook = \Tholabs\ContinousStaging\GitHub\Webhook\WebhookRequest::createFromRequest();
    $event = $webhook->getEvent();

    if ($event instanceof \Tholabs\ContinousStaging\GitHub\Events\PushEvent) {
        $refs = explode('/', $event->getHeader()->getRef());
        $branch = array_pop($refs);
        $project = $event->getRepository()->getName();
        $user = $event->getRepository()->getOwner();

        $targetPath = implode(DIRECTORY_SEPARATOR, [__DIR__, 'projects', $project, $user->getName(), $branch]);
        try {
            $repository = new \Cz\Git\GitRepository($targetPath);
            $repository->pull();
        } catch (\Cz\Git\GitException $exception) {
            try {
                $repository = \Cz\Git\GitRepository::cloneRepository($event->getRepository()->getCloneUrls()->getHttpWithUsernameAndPassword('somebody', 'somewhere'), $targetPath);
            } catch (\Cz\Git\GitException $exception) {
                echo "error: {$exception->getMessage()}";
            }
        }
    }

    echo "\nfinish";