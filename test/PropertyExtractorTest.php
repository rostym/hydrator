<?php

/**
 * This file is part of Hydrator lib.
 * (c) 2017. Rostyslav Tymoshenko <krifollk@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Krifollk\Hydrator\Hydrator\Test;

use Krifollk\Hydrator\PropertyExtractor;
use Krifollk\Hydrator\PropertyResolverInterface;
use Krifollk\Hydrator\Test\PropertyExtractorTest\TestClass;
use PHPUnit\Framework\TestCase;

/**
 * Class PropertyExtractorTest
 *
 * @package Krifollk\Hydrator\PropertyExtractor\Test
 */
class PropertyExtractorTest extends TestCase
{
    /**
     * @test
     */
    public function extractProperty()
    {
        $object = new TestClass();

        $extractor = new PropertyExtractor();

        self::assertEquals('John', $extractor->extractProperty($object, 'userName'));
        self::assertEquals('Doe', $extractor->extractProperty($object, 'userSurname'));
    }

    /**
     * @test
     */
    public function extractProperties()
    {
        $object = new TestClass();

        $extractor = new PropertyExtractor();

        $expected = [
            'userName'    => 'John',
            'userSurname' => 'Doe'
        ];

        self::assertEquals($expected, $extractor->extractProperties($object, ['userName', 'userSurname']));
    }

    /**
     * @test
     */
    public function extractPropertyUsingResolver()
    {
        $object = new TestClass();

        $extractor = new PropertyExtractor($this->createPropertyResolverMock());

        self::assertEquals('John', $extractor->extractProperty($object, 'user_name'));
        self::assertEquals('Doe', $extractor->extractProperty($object, 'user_surname'));
    }

    /**
     * @test
     */
    public function extractPropertiesUsingResolver()
    {
        $object = $object = new TestClass();

        $extractor = new PropertyExtractor($this->createPropertyResolverMock());

        $expected = [
            'user_name'    => 'John',
            'user_surname' => 'Doe'
        ];

        self::assertEquals($expected, $extractor->extractProperties($object, ['user_name', 'user_surname']));
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|PropertyResolverInterface
     */
    protected function createPropertyResolverMock(): \PHPUnit_Framework_MockObject_MockObject
    {
        $resolver = $this->getMockBuilder(PropertyResolverInterface::class);
        $resolverMock = $resolver->setMethods(['resolve'])->getMock();
        $resolverMock
            ->expects(self::any())
            ->method('resolve')
            ->willReturnMap([
                ['user_name', 'userName'],
                ['user_surname', 'userSurname'],
            ]);

        return $resolverMock;
    }
}
