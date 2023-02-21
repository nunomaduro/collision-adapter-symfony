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

namespace NunoMaduro\CollisionAdapterSymfony\EventListener;

use NunoMaduro\Collision\Writer;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\Console\Exception\ExceptionInterface;
use Whoops\Exception\Inspector;

/**
 * @author Nuno Maduro <enunomaduro@gmail.com>
 */
final class ErrorListener
{
    private Writer $writer;

    public function __construct(?Writer $writer = null)
    {
        $this->writer = $writer ? clone $writer : new Writer();
    }

    /**
     * This event should be attached to an {@Event("Symfony\Component\Console\Event\ConsoleErrorEvent")}.
     *
     * Retrieves error from the provided event, and writes a collision exception to the
     * current event output. It also sets the event ExitCode to `O` avoiding the
     * exception to be rendered by the default Symfony console application.
     */
    public function onConsoleError(ConsoleErrorEvent $event): void
    {
        $error = $event->getError();

        if ($error instanceof ExceptionInterface) {
            return;
        }

        $this->writer->setOutput($event->getOutput());
        $this->writer->write(new Inspector($error));
    }
}
