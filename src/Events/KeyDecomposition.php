<?php

namespace Scortes\Calendar\Events;

class KeyDecomposition implements \IteratorAggregate
{
    /** @var string */
    private $delimiter;
    /** @var array */
    private $keys;

    public function __construct($delimiter)
    {
        $this->delimiter = $delimiter;
    }

    public function decompose($key)
    {
        $this->decomposeKey($key);
        $this->filterEmptyKeys();
    }

    private function decomposeKey($key)
    {
        $this->keys = explode($this->delimiter, $key);
    }

    private function filterEmptyKeys()
    {
        $this->keys = array_filter($this->keys, 'strlen');
    }

    public function noKeys()
    {
        return count($this->keys) == 0;
    }

    public function getLastKey()
    {
        $index = count($this->keys) - 1;
        return $this->keys[$index];
    }

    public function getKeysWithoutLastKey()
    {
        return array_slice($this->keys, 0, -1);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->keys);
    }

    public function getDelimiter()
    {
        return $this->delimiter;
    }
}
