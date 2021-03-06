<?php

namespace Digbang\Utils;

abstract class Filter
{
    protected $values = [];

    public function __construct(array $data)
    {
        $oClass = new \ReflectionClass(get_called_class());
        $keys = array_values($oClass->getConstants());

        $this->values = array_only($data, $keys);
    }

    /**
     * Returns NULL if value is empty() === true.
     */
    public function get(string $key, $default = null)
    {
        $value = array_get($this->values, $key, $default);

        return $this->isEmpty($value) ? null : $value;
    }

    public function getRaw(string $key, $default = null)
    {
        return array_get($this->values, $key, $default);
    }

    /**
     * Returns an empty array as default.
     */
    public function getArray(string $key)
    {
        $value = $this->getRaw($key);

        return $this->isEmpty($value) ? [] : $value;
    }

    /**
     * Returns (bool) false on false, 'false', 0 and '0' values. Null on empties (null, '' and []). True otherwise.
     */
    public function getBoolean(string $key, $default = null)
    {
        $value = $this->getRaw($key);

        if ($this->isEmpty($value) && $value !== false) {
            return null;
        }

        if ($value === false || $value === 'false' || $value === '0' || $value === 0) {
            return false;
        }

        return true;
    }

    public function has(string $key)
    {
        return array_has($this->values, $key);
    }

    public function isNotEmpty(string $key)
    {
        return ! $this->isEmpty($this->getRaw($key));
    }

    public function values()
    {
        return $this->values;
    }

    private function isEmpty($value): bool
    {
        return $value === null || $value === false || $value === '' || $value === [];
    }
}
