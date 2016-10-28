<?php
namespace MarcoKretz\PHPUtils;

/**
 * A simple Set implementation.
 *
 * A Set is a simple List, which does not contain duplicates.
 */
class Set implements \Countable, \Iterator
{
    private $setList;

    /**
     * Initialize Set with an empty array.
     */
    public function __construct()
    {
        $this->setList = [];
    }

    /**
     * Add an item to the Set.
     *
     * @param mixed $item Item to add.
     * @return bool Wether the item was added successfully or not.
     */
    public function add($item): bool
    {
        foreach ($this->setList as $setItem) {
            if ($setItem === $item) {
                return false;
            }
        }

        $this->setList[] = $item;

        return true;
    }

    /**
     * Add an array of items to the Set.
     * Will not change the Set on failure.
     *
     * @param array $items The list of items to add.
     * @return bool Wether all items were added successfully or not.
     */
    public function addAll(array $items): bool
    {
        $cache = $this->toArray();

        foreach ($items as $item) {
            if (!$this->add($item)) {
                unset($this->setList);
                $this->setList = [];
                $this->addAll($cache);

                return false;
            }
        }

        return true;
    }

    /**
     * Check if a specific item does exist within the Set.
     *
     * @param mixed $item Item to look for in the Set.
     * @return bool Wether the items exists within the Set or not.
     */
    public function contains($item): bool
    {
        foreach ($this->setList as $setItem) {
            if ($setItem === $item) {
                return true;
            }
        }

        return false;
    }

    /**
     * Remove a specific item from the Set.
     *
     * @param mixed $item Item to remove from the Set.
     * @return bool Wether the item was successfully removed or not.
     */
    public function remove($item): bool
    {
        foreach ($this->setList as $key => $setItem) {
            if ($setItem === $item) {
                unset($this->setList[$key]);
                $this->setList = array_values($this->setList);

                return true;
            }
        }

        return false;
    }

    /**
     * Remove multiple items from the Set at once.
     * Will not change the Set on failure.
     *
     * @param array $items List of Items to remove from the Set.
     * @return bool Wether all items have been removed successfully or not.
     */
    public function removeAll(array $items): bool
    {
        $cache = $this->toArray();
        foreach ($items as $item) {
            if (!$this->remove($item)) {
                unset($this->setList);
                $this->setList = [];
                $this->setList->addAll($cache);

                return false;
            }
        }

        return true;
    }

    /**
     * Check if the Set is empty.
     *
     * @return bool Wether the Set is empty or not.
     */
    public function isEmpty(): bool
    {
        return empty($this->setList);
    }

    /**
     * Get the Set as an array.
     *
     * @return array Set as array.
     */
    public function toArray(): array
    {
        return $this->setList;
    }

    /**
     * Count the number of items in the Set.
     *
     * @return int Number of items in the Set.
     */
    public function count(): int
    {
        return count($this->setList);
    }

    /**
     * Check to Sets for equality.
     *
     * @param Set $set Set to compare the current one to.
     * @return bool Wether the two Sets contain the same items or not.
     */
    public function equals(Set $set): bool
    {
        return $this->hashCode() === $set->hashCode();
    }

    /**
     * Removes all items from the Set.
     */
    public function clear()
    {
        unset($this->setList);
        $this->setList = [];
    }

    /**
     * Get the hashcode identifying the items in the Set.
     *
     * TODO: Possible overflow?
     *
     * @return float HashCode for the items in the Set.
     */
    public function hashCode(): int
    {
        $hash = 0;

        foreach ($this->setList as $setItem) {
            if ($setItem instanceof Set) {
                $hash += $setItem->hashCode();
            } elseif ($setItem !== null) {
                $hash += crc32($setItem);
            }
        }

        return $hash;
    }

    public function rewind()
    {
        reset($this->setList);
    }

    public function current()
    {
        return current($this->setList);
    }

    public function key()
    {
        return key($this->setList);
    }

    public function next()
    {
        return next($this->setList);
    }

    public function valid()
    {
        return $this->current() !== false;
    }
}
