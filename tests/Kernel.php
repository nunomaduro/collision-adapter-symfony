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

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use NunoMaduro\CollisionAdapterSymfony\CollisionBundle;
use Symfony\Component\HttpKernel\Tests\Fixtures\KernelForTest;

class Kernel extends KernelForTest
{
    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        return array_merge(
            parent::registerBundles(),
            [new FrameworkBundle(), new CollisionBundle()]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . DIRECTORY_SEPARATOR . 'config.yml');
    }
}
