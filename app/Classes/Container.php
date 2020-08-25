<?php



class Container implements ArrayAccess {
    protected $items = [];
    protected $cache = [];

    public function __construct(array $items = [])
    {
        foreach ($items as $key => $item) {
            $this->offsetSet($key, $item);
        }
    }

    public function offsetSet($offset, $value)
    {
        $this->items[$offset] = $value;
    }

    public function offsetGet($offset)
    {
        if (!isset($this->items[$offset])) {
            return null;
        }

        if (isset($this->cache[$offset])) {
            return $this->cache[$offset];
        }

        $item = $this->items[$offset]($this);
        $this->cache[$offset] = $item;
        return $item;
    }

    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            unset($this->items[$offset]);
        }
    }

    public function __get($property) {
        return $this->offsetGet($property);
    }
}