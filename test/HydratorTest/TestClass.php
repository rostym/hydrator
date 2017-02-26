<?php

declare(strict_types = 1);

namespace Krifollk\Hydrator\Test\HydratorTest;

class TestClass
{
    private $privateProperty;
    protected $protectedProperty;
    public $publicProperty;


    public function getPrivateProperty()
    {
        return $this->privateProperty;
    }

    public function getProtectedProperty()
    {
        return $this->protectedProperty;
    }

    public function getPublicProperty()
    {
        return $this->publicProperty;
    }
}
