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
 * Class Hydrator
 *
 * @package Krifollk\Hydrator
 */
class Hydrator implements HydratorInterface
{
    /** @var PropertyResolverInterface|null */
    private $propertyResolver;

    /**
     * ClosureHydrator constructor.
     *
     * @param PropertyResolverInterface $propertyResolver
     */
    public function __construct(PropertyResolverInterface $propertyResolver = null)
    {
        $this->propertyResolver = $propertyResolver;
    }

    /**
     * @inheritdoc
     */
    public function hydrate($object, array $properties)
    {
        if ($this->propertyResolver === null) {
            $this->plainHydrate($object, $properties);

            return;
        }

        $this->hydrateWithPropertyResolver($object, $properties);
    }

    /**
     * Plain hydration
     *
     * @param object $object
     * @param array  $properties
     * @return void
     */
    private function plainHydrate($object, array $properties)
    {
        $closure = function (array $properties) {
            foreach ($properties as $name => $value) {
                $this->{$name} = $value;
            }
        };

        $closure->call($object, $properties);
    }

    /**
     * Hydrate an object using property resolver
     *
     * @param object $object
     * @param array  $properties
     * @return void
     */
    private function hydrateWithPropertyResolver($object, array $properties)
    {
        $closure = function (array $properties, PropertyResolverInterface $propertyResolver) {
            foreach ($properties as $name => $value) {
                $this->{$propertyResolver->resolve($name)} = $value;
            }
        };

        $closure->call($object, $properties, $this->propertyResolver);
    }
}
