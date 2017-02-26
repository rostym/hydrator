<?php

/**
 * This file is part of Hydrator lib.
 * (c) 2017. Rostyslav Tymoshenko <krifollk@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Krifollk\Hydrator;

/**
 * Interface PropertyResolverInterface
 *
 * @package Krifollk
 */
interface PropertyResolverInterface
{
    /**
     * Resolve property name
     *
     * @param string $propertyName
     *
     * @return string
     */
    public function resolve(string $propertyName): string;
}
