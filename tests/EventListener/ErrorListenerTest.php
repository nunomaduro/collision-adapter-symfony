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

namespace Tests\EventListener;

use Exception;
use Tests\TestCase;
use Whoops\Exception\Inspector;
use NunoMaduro\Collision\Contracts\Writer;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use NunoMaduro\CollisionAdapterSymfony\EventListener\ErrorListener;

class ErrorListenerTest extends TestCase
{
    public function testUsageOfEventOutput(): void
    {
        $exception = new Exception('Something went wrong');
        $event = new ConsoleErrorEvent(new ArrayInput([]), $output = new NullOutput(), $exception);

        $writerMock = $this->createMock(Writer::class);
        $writerMock->expects($this->once())
            ->method('setOutput')
            ->with($output);

        $errorListener = new ErrorListener($writerMock);
        $errorListener->onConsoleError($event);
    }

    public function testUsageOfEventException(): void
    {
        $exception = new Exception('Something went wrong');
        $event = new ConsoleErrorEvent(new ArrayInput([]), $output = new NullOutput(), $exception);

        $writerMock = $this->createMock(Writer::class);
        $writerMock->expects($this->once())
            ->method('write')
            ->with(new Inspector($exception));

        $errorListener = new ErrorListener($writerMock);
        $errorListener->onConsoleError($event);
    }

    public function testUpdateOfExitCode(): void
    {
        $exception = new Exception('Something went wrong');
        $event = new ConsoleErrorEvent(new ArrayInput([]), $output = new NullOutput(), $exception);

        $writerMock = $this->createMock(Writer::class);

        $errorListener = new ErrorListener($writerMock);
        $errorListener->onConsoleError($event);

        $this->assertEquals(0, $event->getExitCode());
    }

    public function testThatIgnoresBaseConsoleExceptions(): void
    {
        $exception = new CommandNotFoundException('Command not found');
        $event = new ConsoleErrorEvent(new ArrayInput([]), $output = new NullOutput(), $exception);

        $writerMock = $this->createMock(Writer::class);
        $writerMock->expects($this->never())
            ->method('write');

        $errorListener = new ErrorListener($writerMock);
        $errorListener->onConsoleError($event);
    }
}
