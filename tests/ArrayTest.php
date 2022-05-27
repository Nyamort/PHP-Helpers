<?php

use IERomain\ArrayHelpers;
use PHPUnit\Framework\TestCase;

class ArrayTest extends TestCase
{
    public function testGroupBy(){
        $array = [
            ['id' => 1, 'name' => 'foo'],
            ['id' => 2, 'name' => 'bar'],
            ['id' => 3, 'name' => 'bar'],
        ];

        $expected = [
            'bar' => [
                ['id' => 2, 'name' => 'bar'],
                ['id' => 3, 'name' => 'bar'],
            ],
            'foo' => [
                ['id' => 1, 'name' => 'foo'],
            ],
        ];

        $this->assertEquals($expected, ArrayHelpers::groupBy($array, 'name'));
    }

    public function testFirst()
    {
        $array = [1, 2, 3];
        $expected = 1;
        $this->assertEquals($expected, ArrayHelpers::first($array));
    }

    public function testFlatten(){
        $array = [1,2,[3,[4,5],6],7];

        $expected = [1,2,3,4,5,6,7];
        $this->assertEquals($expected, ArrayHelpers::flatten($array));
    }

    public function testGet(){
        $array = [
            'foo' => 'bar',
            'bar' => 'foo',
            'bal' => 'foo',
            'par' => [
                'foo' => 'bar',
                'bar' => 'foo',
                'baz' => 'foo',
            ],
            [
                'foo' => 'test',
            ],
            'tar' => [
                'foo' => [
                    'baz' => 'foo',
                ],
                'bar' => [
                    'qux' => 'foo1',
                ],
                'baz' => [
                    'foo' => 'bar',
                    'qux' => 'foo3',
                    'baz' => 'foo4',
                ],
            ],
        ];

        $expected1 = ['bar','test', ['baz' => 'foo']];
        $expected2 = ['foo1','foo3'];

        $this->assertEquals('bar', ArrayHelpers::get($array, 'foo'));
        $this->assertEquals('foo', ArrayHelpers::get($array, 'bar'));
        $this->assertEquals('default', ArrayHelpers::get($array, 'baz', 'default'));
        $this->assertEquals('foo', ArrayHelpers::get($array, 'par.bar'));
        $this->assertEquals('foo', ArrayHelpers::get($array, 'tar.foo.baz'));
        $this->assertEquals($expected1, ArrayHelpers::get($array, '*.foo'));
        $this->assertEquals($expected2, ArrayHelpers::get($array, 'tar.*.qux'));
        $this->assertEquals('bar', ArrayHelpers::get($array, 'tar.*.foo'));
        $this->assertEquals($expected2, ArrayHelpers::get($array, 'tar.regex:/ba.*/.qux'));
    }

    public function testAccessible(){
        $foo = [];
        $bar = 'bar';
        $baz = $this->getMockBuilder(ArrayAccess::class)->getMock();

        $this->assertTrue(ArrayHelpers::accessible($foo));
        $this->assertFalse(ArrayHelpers::accessible($bar));
        $this->assertTrue(ArrayHelpers::accessible($baz));
    }

    public function testExists(){
        $foo = [
            'foo' => 'bar',
            'bar' => 'foo',
        ];

        $this->assertTrue(ArrayHelpers::exists($foo, 'foo'));
        $this->assertTrue(ArrayHelpers::exists($foo, 'bar'));
        $this->assertFalse(ArrayHelpers::exists($foo, 'baz'));
    }

    public function testCollapse(){
        $array = [
            ['foo' => 'bar'],
            ['bar' => 'foo'],
        ];

        $expected = [
            'foo' => 'bar',
            'bar' => 'foo',
        ];

        $this->assertEquals($expected, ArrayHelpers::collapse($array));
    }
}
