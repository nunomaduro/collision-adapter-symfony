<?php

declare(strict_types=1);

/*
 * This file is part of Collision Adapter Symfony.
 *
 * (c) Nuno Maduro <enunomaduro@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\DependencyInjection;

use Tests\TestCase;
use Symfony\Component\Console\ConsoleEvents;
use NunoMaduro\CollisionAdapterSymfony\EventListener\ErrorListener;

class CollisionExtensionTest extends Testcase
{
    public function testContainerHasService(): void
    {
        ($kernel = static::createKernel())->boot();
        $container = $kernel->getContainer();
        $id = 'collision.error_listener';

        $this->assertTrue(
            $container->has($id),
            sprintf('The container should have a `%s` alias for autowiring support.', $id)
        );
    }

    public function testDispacherHasListener(): void
    {
        ($kernel = static::createKernel())->boot();
        $dispacher = $kernel->getContainer()
            ->get('event_dispatcher');

        $listeners = $dispacher->getListeners()[ConsoleEvents::ERROR];

        $listenerFound = false;
        foreach ($listeners as $listener) {
            if ($listener[0] instanceof ErrorListener) {
                $listenerFound = true;
            }
        }

        $this->assertTrue($listenerFound, 'The event dispacher an ErrorListener attached');
    }
}
