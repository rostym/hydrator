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
 * Interface ExtractorInterface
 *
 * @package Krifollk\Hydrator
 */
interface ExtractorInterface
{
    /**
     * Extract property from provided object
     *
     * @param object $object
     * @param string $property
     *
     * @return mixed
     */
    public function extractProperty($object, string $property);

    /**
     * Extract properties from provided object
     *
     * @param object $object
     * @param array  $properties
     *
     * @return array
     */
    public function extractProperties($object, array $properties): array;
}
