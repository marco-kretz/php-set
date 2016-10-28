<?php

namespace MarcoKretz\PHPUtilsTest;

use MarcoKretz\PHPUtils\Set;

/**
 * PHPUnit class for testing the Set class.
 */
class SetTest extends \PHPUnit_Framework_TestCase
{
    private $set;

    /**
     * Init test-cases with empty Set.
     */
    public function __construct()
    {
        $this->set = new Set();
    }

    /**
     * Add the same value twice.
     * The Set should only contain the value once.
     */
    public function testSetAdd1()
    {
        $this->set->add(5);
        $this->set->add(5);

        $this->assertEquals(1, count($this->set));
        $this->assertTrue($this->set->contains(5));
    }

    /**
     * Add the three different values.
     * The Set should contain all of them.
     */
    public function testSetAdd2()
    {
        $this->set->add(1);
        $this->set->add(2);
        $this->set->add(3);

        $this->assertEquals(3, count($this->set));
    }

    /**
     * Add the three different values twice.
     * The Set should contain only the first three items.
     */
    public function testSetAdd3()
    {
        $this->set->add(1);
        $this->set->add(2);
        $this->set->add(3);
        $this->set->add(1);
        $this->set->add(2);
        $this->set->add(3);

        $this->assertEquals(3, count($this->set));
    }

    /**
     * Add the seven different values with different datatypes.
     * The Set should contain all of them.
     */
    public function testSetAdd4()
    {
        $this->set->add("Hello");
        $this->set->add("World");
        $this->set->add("hello");
        $this->set->add("world");
        $this->set->add(new Set());
        $this->set->add(new Set());
        $this->set->add(47.11);

        $this->assertEquals(7, count($this->set));
    }

    /**
     * Add the three items at once, which are not yet present in the current Set..
     * The Set should contain all of them.
     */
    public function testSetAddAll1()
    {
        $addItems = [2, 4, 6];
        $this->set->add(1);
        $this->set->add(3);
        $this->set->add(5);
        $this->set->addAll($addItems);

        $this->assertEquals(6, count($this->set));
    }

    /**
     * Add the three different values at once which partly exist in the Set.
     * The Set should not contain all of them, only unique values.
     */
    public function testSetAddAll2()
    {
        $addItems = [2, 4, 6];
        $this->set->add(2);
        $this->set->add(4);
        $this->set->add(5);
        $this->set->addAll($addItems);

        $this->assertEquals(3, count($this->set));
    }

    /**
     * Remove a specific value, which exists in the Set.
     * The Set should not contain the removed value.
     */
    public function testSetRemove1()
    {
        $initialItems = [1, 2, 3, 4, 5, 6];
        $valueToRemove = 3;
        $this->set->addAll($initialItems);
        $this->set->remove($valueToRemove);

        $this->assertEquals(2, array_search(4, $this->set->toArray()));
        $this->assertFalse($this->set->contains($valueToRemove));
    }

    /**
     * Remove an item from the Set which is no present.
     * remove() should return false.
     */
    public function testSetRemove2()
    {
        $initialItem = [1, 2, 3, 4, 5, 6];
        $valueToRemove = 7;
        $this->set->addAll($initialItem);

        $this->assertFalse($this->set->remove($valueToRemove));
    }

    /**
     * Test if a freshly initialzed Set is empty.
     * Should return true.
     */
    public function testSetIsEmpty1()
    {
        $this->assertTrue($this->set->isEmpty());
    }

    /**
     * Test if a non empty Set with one value is empty.
     * Should return false.
     */
    public function testSetIsEmpty2()
    {
        $this->set->add(1);
        $this->assertFalse($this->set->isEmpty());
    }

    /**
     * Test if a non empty Set with multiple values is empty.
     * Should return false.
     */
    public function testSetIsEmpty3()
    {
        $this->set->add("Hello");
        $this->set->add("World");
        $this->set->add(1337);
        $this->assertFalse($this->set->isEmpty());
    }

    /**
     * Compare two Sets with the same items for equality.
     * Should be true.
     */
    public function testSetEquals1()
    {
        $values = [5, 8, 'test'];
        $compareSet = new Set();
        $compareSet->addAll($values);
        $this->set->addAll($values);

        $this->assertTrue($this->set->equals($compareSet));
    }

    /**
     * Compare two Sets with different items for equality.
     * Should be false.
     */
    public function testSetEquals2()
    {
        $values = [5, 8, 'test'];
        $compareSet = new Set();
        $compareSet->add('fail');
        $compareSet->addAll($values);
        $this->set->addAll($values);

        $this->assertFalse($this->set->equals($compareSet));
    }
}