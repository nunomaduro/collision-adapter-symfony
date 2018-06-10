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

namespace Tests;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TestCase extends KernelTestCase
{
    /**
     * {@inheritdoc}
     */
    protected static function getKernelClass(): string
    {
        return Kernel::class;
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $filesystem = new Filesystem();
        $filesystem->remove(__DIR__.DIRECTORY_SEPARATOR.'cache');
        $filesystem->remove(__DIR__.DIRECTORY_SEPARATOR.'logs');
    }
}
