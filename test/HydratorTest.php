<?php

/**
 * This file is part of Hydrator lib.
 * (c) 2017. Rostyslav Tymoshenko <krifollk@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Krifollk\Hydrator\Test;

use Krifollk\Hydrator;
use PHPUnit\Framework\TestCase;

/**
 * Class HydratorTest
 *
 * @package Krifollk\Test
 */
class HydratorTest extends TestCase
{
    /**
     * @test
     * @dataProvider hydrateTestDataProvider
     *
     * @param array $properties
     */
    public function hydrate(array $properties)
    {
        $hydrator = new Hydrator();
        $testClass = new Hydrator\Test\HydratorTest\TestClass();

        self::assertEquals(null, $testClass->getPrivateProperty());
        self::assertEquals(null, $testClass->getPublicProperty());
        self::assertEquals(null, $testClass->getProtectedProperty());

        $hydrator->hydrate($testClass, $properties);

        self::assertEquals('private property value', $testClass->getPrivateProperty());
        self::assertEquals('public property value', $testClass->getPublicProperty());
        self::assertEquals('protected property value', $testClass->getProtectedProperty());
    }

    /**
     * @test
     * @dataProvider hydrateWithPropertyResolverTestDataProvider
     *
     * @param array $properties
     * @param array $returnMap
     */
    public function hydrateWithPropertyResolver(array $properties, array $returnMap)
    {
        $resolverMock = $this->createPropertyResolverMock($returnMap);
        $hydrator = new Hydrator($resolverMock);
        $testClass = new Hydrator\Test\HydratorTest\TestClass();

        self::assertEquals(null, $testClass->getPrivateProperty());
        self::assertEquals(null, $testClass->getPublicProperty());
        self::assertEquals(null, $testClass->getProtectedProperty());

        $hydrator->hydrate($testClass, $properties);

        self::assertEquals('private property value', $testClass->getPrivateProperty());
        self::assertEquals('public property value', $testClass->getPublicProperty());
        self::assertEquals('protected property value', $testClass->getProtectedProperty());

    }

    public function hydrateWithPropertyResolverTestDataProvider()
    {
        return [
            [
                [
                    'private_property'   => 'private property value',
                    'protected_property' => 'protected property value',
                    'public_property'    => 'public property value',
                ],
                [
                    ['private_property', 'privateProperty'],
                    ['protected_property', 'protectedProperty'],
                    ['public_property', 'publicProperty'],
                ]
            ]
        ];
    }

    public function hydrateTestDataProvider()
    {
        return [
            [
                [
                    'privateProperty'   => 'private property value',
                    'protectedProperty' => 'protected property value',
                    'publicProperty'    => 'public property value',
                ]
            ]
        ];
    }

    /**
     * @param array $returnMap
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createPropertyResolverMock(array $returnMap) : \PHPUnit_Framework_MockObject_MockObject
    {
        $resolver = $this->getMockBuilder(Hydrator\PropertyResolverInterface::class);
        $resolverMock = $resolver->setMethods(['resolve'])->getMock();
        $resolverMock
            ->expects(self::exactly(3))
            ->method('resolve')
            ->willReturnMap($returnMap);

        return $resolverMock;
    }
}
