<?php
namespace MarcoKretz\PHPUtils;

class Set implements \Countable
{
    private $setList;

    public function __construct()
    {
        $this->setList = [];
    }

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

    public function addAll(array $items)
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    public function contains($item): bool
    {
        foreach ($this->setList as $setItem)
        {
            if ($setItem === $item) {
                return true;
            }

            return false;
        }
    }

    public function isEmpty(): bool
    {
        return empty($this->setList);
    }

    public function toArray(): array
    {
        return $this->setList;
    }

    public function count(): int
    {
        return count($this->setList);
    }
}