<?php

declare(strict_types=1);

use NunoMaduro\CollisionAdapterSymfony\EventListener\ErrorListener;
use Symfony\Component\Console\ConsoleEvents;

$container->autowire('collision.error_listener', ErrorListener::class)
    ->setPublic(true)
    ->addTag('kernel.event_listener', ['event' => ConsoleEvents::ERROR]);
