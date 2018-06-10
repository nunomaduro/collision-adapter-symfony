<?php

declare(strict_types=1);

use Symfony\Component\Console\ConsoleEvents;
use NunoMaduro\CollisionAdapterSymfony\EventListener\ErrorListener;

$container->autowire('collision.error_listener', ErrorListener::class)
    ->setPublic(true)
    ->addTag('kernel.event_listener', ['event' => ConsoleEvents::ERROR]);
