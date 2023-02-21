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

use NunoMaduro\CollisionAdapterSymfony\EventListener\ErrorListener;
use Symfony\Component\Console\ConsoleEvents;
use Tests\TestCase;

class CollisionAdapterSymfonyExtensionTest extends TestCase
{
    public function testContainerHasService(): void
    {
        $id = 'collision.error_listener';

        $this->assertTrue(
            self::getContainer()->has($id),
            "The container should have a `$id` alias for autowiring support.",
        );
    }

    public function testDispacherHasListener(): void
    {
        $this->expectNotToPerformAssertions();

        foreach (self::getContainer()->get('event_dispatcher')->getListeners()[ConsoleEvents::ERROR] as $listener) {
            if ($listener[0] instanceof ErrorListener) {
                return;
            }
        }

        $this->fail('ErrorListener has not been attached to event dispatcher');
    }
}
