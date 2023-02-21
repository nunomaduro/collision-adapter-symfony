<?php

declare(strict_types=1);

use NunoMaduro\CollisionAdapterSymfony\EventListener\ErrorListener;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set('collision.error_listener', ErrorListener::class)
        ->autowire()
        ->public()
        ->tag('kernel.event_listener', ['event' => ConsoleEvents::ERROR]);
};
