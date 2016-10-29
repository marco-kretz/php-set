<?php
namespace MarcoKretz\PHPUtils;

/**
 * A simple Set implementation.
 *
 * A Set is a simple List, which does not contain duplicates.
 */
class HashSet implements \Countable, \Iterator
{
    private $elements;

    /**
     * Initialize Set with an empty array.
     */
    public function __construct()
    {
        $this->elements = [];
    }

    /**
     * Add an element to the Set.
     *
     * @param mixed $element element to add.
     * @return bool Wether the element was added successfully or not.
     */
    public function add($element): bool
    {
        foreach ($this->elements as $setElement) {
            if ($setElement === $element) {
                return false;
            }
        }

        $this->elements[] = $element;

        return true;
    }

    /**
     * Add an array of elements to the Set.
     * Will not change the Set on failure.
     *
     * @param array $elements The list of elements to add.
     * @return bool Wether all elements were added successfully or not.
     */
    public function addAll(array $elements): bool
    {
        $cachedElements = $this->toArray();

        foreach ($elements as $element) {
            if (!$this->add($element)) {
                unset($this->elements);
                $this->elements = [];
                $this->addAll($cachedElements);

                return false;
            }
        }

        return true;
    }

    /**
     * Check if a specific element does exist within the Set.
     *
     * @param mixed $element element to look for in the Set.
     * @return bool Wether the elements exists within the Set or not.
     */
    public function contains($element): bool
    {
        foreach ($this->elements as $setElement) {
            if ($setElement ===  $element) {
                return true;
            }
        }

        return false;
    }

    /**
     * Remove a specific element from the Set.
     *
     * @param mixed $element element to remove from the Set.
     * @return bool Wether the element was successfully removed or not.
     */
    public function remove($element): bool
    {
        foreach ($this->elements as $key => $setElement) {
            if ($setElement === $element) {
                unset($this->elements[$key]);
                $this->elements = array_values($this->elements);

                return true;
            }
        }

        return false;
    }

    /**
     * Remove multiple elements from the Set at once.
     * Will not change the Set on failure.
     *
     * @param array $elements List of elements to remove from the Set.
     * @return bool Wether all elements have been removed successfully or not.
     */
    public function removeAll(array $elements): bool
    {
        $cachedElements = $this->toArray();
        foreach ($elements as $element) {
            if (!$this->remove($element)) {
                unset($this->elements);
                $this->elements = [];
                $this->elements->addAll($cachedElements);

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
        return empty($this->elements);
    }

    /**
     * Get the Set as an array.
     *
     * @return array Set as array.
     */
    public function toArray(): array
    {
        return $this->elements;
    }

    /**
     * Count the number of elements in the Set.
     *
     * @return int Number of elements in the Set.
     */
    public function count(): int
    {
        return count($this->elements);
    }

    /**
     * Check to Sets for equality.
     *
     * @param Set $set Set to compare the current one to.
     * @return bool Wether the two Sets contain the same elements or not.
     */
    public function equals(HashSet $set): bool
    {
        return $this->hashCode() === $set->hashCode();
    }

    /**
     * Removes all elements from the Set.
     */
    public function clear()
    {
        unset($this->elements);
        $this->elements = [];
    }

    /**
     * Get the hashcode identifying the elements in the Set.
     *
     * TODO: Possible overflow?
     *
     * @return float HashCode for the elements in the Set.
     */
    public function hashCode(): int
    {
        $hash = 0;

        foreach ($this->elements as $setElement) {
            if ($setElement instanceof HashSet) {
                $hash += $setElement->hashCode();
            } elseif ($setElement !== null) {
                $hash += crc32($setElement);
            }
        }

        return $hash;
    }

    public function rewind()
    {
        reset($this->elements);
    }

    public function current()
    {
        return current($this->elements);
    }

    public function key()
    {
        return key($this->elements);
    }

    public function next()
    {
        return next($this->elements);
    }

    public function valid()
    {
        return $this->current() !== false;
    }
}
