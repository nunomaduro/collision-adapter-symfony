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

use NunoMaduro\Collision\Contracts\Writer as WriterContract;
use NunoMaduro\Collision\Writer;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\Console\Exception\ExceptionInterface;
use Whoops\Exception\Inspector;

/**
 * This is an Collision Adapter Symfony Error Listener implementation.
 *
 * @author Nuno Maduro <enunomaduro@gmail.com>
 */
final class ErrorListener
{
    /**
     * Holds an instance of the Collision Writer.
     *
     * @var \NunoMaduro\Collision\Contracts\Writer
     */
    private $writer;

    /**
     * Creates an new instance of the Error Listener.
     *
     * @param \NunoMaduro\Collision\Contracts\Writer|null $writer
     */
    public function __construct(WriterContract $writer = null)
    {
        $this->writer = $writer ? clone $writer : new Writer();
    }

    /**
     * This event should be attached to an {@Event("Symfony\Component\Console\Event\ConsoleErrorEvent")}.
     *
     * Retrieves error from the provided event, and writes a collision exception to the
     * current event output. It also sets the event ExitCode to `O` avoiding the
     * exception to be rendered by the default Symfony console application.
     *
     * @param \Symfony\Component\Console\Event\ConsoleErrorEvent $event
     */
    public function onConsoleError(ConsoleErrorEvent $event): void
    {
        $error = $event->getError();

        if (! ($error instanceof ExceptionInterface)) {
            $this->writer->setOutput($event->getOutput());

            $this->writer->write(new Inspector($error));

            $event->setExitCode(0);
        }
    }
}
