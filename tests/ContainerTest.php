<?php

namespace DownShift\Container;

class ContainerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Container
     */
    protected $container;


    public function setUp()
    {
        $this->container = new Container();
    }


    public function testCanResolveDependencies()
    {
        $qux = $this->container->make('DownShift\Container\Test\Qux');

        $baz = $qux->getBaz();

        $this->assertInstanceOf('DownShift\Container\Test\Baz', $baz);
    }


    public function testCanBindInterfaceToImplementationUsingBind()
    {
        $this->container->bind('DownShift\Container\Test\BarInterface', 'DownShift\Container\Test\Bar1');
        $foo = $this->container->make('DownShift\Container\Test\Foo');

        $bar = $foo->getBar();

        $this->assertInstanceOf('DownShift\Container\Test\Bar1', $bar);
    }


    public function testCanBindInterfaceUsingWhenNeedsGive()
    {
        $this->container
            ->when('DownShift\Container\Test\Foo')
            ->needs('DownShift\Container\Test\BarInterface')
            ->give('DownShift\Container\Test\Bar2');

        $foo = $this->container->make('DownShift\Container\Test\Foo');
        $bar = $foo->getBar();

        $this->assertInstanceOf('DownShift\Container\Test\Bar2', $bar);
    }
}
