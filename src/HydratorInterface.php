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
 * Interface HydratorInterface
 *
 * @package Krifollk\Hydrator
 */
interface HydratorInterface
{
    /**
     * Hydrate an object with provided properties data
     *
     * @param object $object
     * @param array  $properties
     *
     * @return void
     */
    public function hydrate($object, array $properties);
}
