<?php

use MarcoKretz\PHPUtils\Set;

class SetTest extends PHPUnit_Framework_TestCase
{
    private $set;

    public function __construct()
    {
        $this->set = new Set();
    }

    public function testSetAdd1()
    {
        $this->set->add(5);
        $this->set->add(5);
        $this->assertTrue(count($this->set) === 1);
    }

    public function testSetAdd2()
    {
        $this->set->add(1);
        $this->set->add(2);
        $this->set->add(3);

        $this->assertTrue(count($this->set) === 3);
    }

    public function testSetAdd3()
    {
        $this->set->add(1);
        $this->set->add(2);
        $this->set->add(3);
        $this->set->add(1);
        $this->set->add(2);
        $this->set->add(3);

        $this->assertTrue(count($this->set) === 3);
    }

    public function testSetAdd4()
    {
        $this->set->add("Hello");
        $this->set->add("World");
        $this->set->add("hello");
        $this->set->add("world");
        $this->set->add(new Set());
        $this->set->add(new Set());
        $this->set->add(47.11);

        $this->assertTrue(count($this->set) === 7);
    }

    public function testSetAddAll1()
    {
        $addItems = [2, 4, 6];
        $this->set->add(1);
        $this->set->add(3);
        $this->set->add(5);
        $this->set->addAll($addItems);

        $this->assertTrue(count($this->set) === 6);
    }

    public function testSetAddAll2()
    {
        $addItems = [2, 4, 6];
        $this->set->add(2);
        $this->set->add(4);
        $this->set->add(5);
        $this->set->addAll($addItems);

        $this->assertTrue(count($this->set) === 4);
    }
}