<?php

namespace BrandonLeeDetty\PhpCacheObjects;

define('BrandonLeeDetty\PhpCacheObjects\UNDEFINED_PROP', 42);

/* Derived classes MUST contain these two lines to enumerate their properties
       protected static $cacheobject_properties;
       protected static $cacheobject_property_count;
 */
abstract class CacheObject implements \ArrayAccess, \Iterator
{
    private int $cacheobject_iterator_position = 0;

    final public function __construct(?array $init_array = null)
    {
        if (!$init_array) {
            return;
        }
        foreach ($init_array as $k => $v) {
            $this->offsetSet($k, $v);
        }
    }

    final protected function initializeClassProperties()
    {
        $reflection = new \ReflectionClass(static::class);

        // derived classes MUST have these static props for the iterator interface
        $static_props = $reflection->getProperties(\ReflectionProperty::IS_STATIC);
        $has_props_prop = $has_count_prop = false;
        foreach ($static_props as $static_prop) {
            if ($static_prop->name === 'cacheobject_properties') {
                $has_props_prop = true;
            }
            if ($static_prop->name === 'cacheobject_property_count') {
                $has_count_prop = true;
            }
        }
        if (!$has_props_prop or !$has_count_prop) {
            throw new \Exception(
                'Derived classes must include these static properties: '
                . '$cacheobject_properties, $cacheobject_property_count'
            );
        }

        $public_props = $reflection->getProperties(\ReflectionProperty::IS_PUBLIC);
        $props = array();
        foreach ($public_props as $prop) {
            $props[] = $prop->name;
        }
        static::$cacheobject_properties = $props;
        static::$cacheobject_property_count = count($props);
    }

    //
    // for ArrayAccess interface
    //

    final public function offsetSet(mixed $prop, mixed $value): void
    {
        if (!property_exists($this, $prop)) {
            throw new \Error('', UNDEFINED_PROP);
        }
        $this->$prop = $value;
    }

    public function offsetExists(mixed $prop): bool
    {
        return property_exists($this, $prop);
    }

    public function offsetUnset(mixed $prop): void
    {
        if (property_exists($this, $prop)) {
            unset($this->$prop);
        }
    }

    public function offsetGet(mixed $prop): mixed
    {
        if (!property_exists($this, $prop)) {
            throw new \Error('', UNDEFINED_PROP);
        }
        return $this->$prop;
    }

    //
    // for Iterator interface
    //

    public function rewind(): void
    {
        $this->cacheobject_iterator_position = 0;
        if (static::$cacheobject_properties === null) {
            $this->initializeClassProperties();
        }
    }

    public function current(): mixed
    {
        return $this->{
            static::$cacheobject_properties[
                $this->cacheobject_iterator_position
            ]
        };
    }

    public function key(): mixed
    {
        return static::$cacheobject_properties[
            $this->cacheobject_iterator_position
        ];
    }

    public function next(): void
    {
        ++$this->cacheobject_iterator_position;
    }

    public function valid(): bool
    {
        return $this->cacheobject_iterator_position < static::$cacheobject_property_count;
    }
}
