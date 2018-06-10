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

namespace NunoMaduro\CollisionAdapterSymfony\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

/**
 * This is an Collision Adapter Symfony Extension implementation.
 *
 * @author Nuno Maduro <enunomaduro@gmail.com>
 */
final class CollisionExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new PhpFileLoader($container, new FileLocator(__DIR__));

        $loader->load('../Resources/config/services.php');
    }
}
