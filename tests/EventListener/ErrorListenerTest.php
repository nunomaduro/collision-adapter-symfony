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
use NunoMaduro\Collision\Writer;
use NunoMaduro\CollisionAdapterSymfony\EventListener\ErrorListener;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Tests\TestCase;

class ErrorListenerTest extends TestCase
{
    public function testUsageOfEventOutput(): void
    {
        $exception = new Exception('Something went wrong');
        $output = $this->createMock(OutputInterface::class);
        $output->expects($this->atLeastOnce())->method('writeln');

        $event = new ConsoleErrorEvent(new ArrayInput([]), $output, $exception);

        $errorListener = new ErrorListener(new Writer(null, $output));
        $errorListener->onConsoleError($event);
    }

    public function testUsageOfEventException(): void
    {
        $output = $this->createMock(OutputInterface::class);
        $output->expects($this->atLeastOnce())->method('writeln');

        $exception = new Exception('Something went wrong');
        $event = new ConsoleErrorEvent(new ArrayInput([]), $output, $exception);

        $errorListener = new ErrorListener(new Writer(null, $output));
        $errorListener->onConsoleError($event);
    }

    public function testNoUpdateOfExitCode(): void
    {
        $event = new ConsoleErrorEvent(new ArrayInput([]), new NullOutput(), new Exception('Something went wrong'));
        (new ErrorListener(new Writer(null, new NullOutput())))->onConsoleError($event);

        $this->assertEquals(1, $event->getExitCode());
    }

    public function testThatIgnoresBaseConsoleExceptions(): void
    {
        $output = $this->createMock(OutputInterface::class);
        $output->expects($this->never())->method('writeln');

        (new ErrorListener(new Writer(null, $output)))
            ->onConsoleError(
                new ConsoleErrorEvent(
                    new ArrayInput([]),
                    new NullOutput(),
                    new CommandNotFoundException('Command not found'),
            ),
        );
    }
}
