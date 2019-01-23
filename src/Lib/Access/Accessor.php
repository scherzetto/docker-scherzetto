<?php

declare(strict_types=1);

namespace Lib\Access;

class Accessor
{
    private const MODE_READ = 0;
    private const MODE_WRITE = 1;

    private const PREF_GET = 'get';
    private const PREF_HAS = 'has';
    private const PREF_IS = 'is';
    private const PREF_SET = 'set';
    private const NO_PREF = '';

    private const PREFIXES = [
        self::MODE_READ => [
            self::PREF_GET,
            self::PREF_HAS,
            self::PREF_IS,
            self::NO_PREF,
        ],
        self::MODE_WRITE => [
            self::PREF_SET,
            self::NO_PREF,
        ],
    ];

    public function readValue($arrayOrObject, $property)
    {
        if (\is_array($arrayOrObject)) {
            return $arrayOrObject[$property];
        } elseif (\is_object($arrayOrObject)) {
            $method = $this->getMethod($arrayOrObject, $property);

            return $method ? $arrayOrObject->$method() : false;
        }

        return false;
    }

    public function writeValue(&$arrayOrObject, $property, $value)
    {
        if (\is_array($arrayOrObject)) {
            $arrayOrObject[$property] = $value;
        } elseif (\is_object($arrayOrObject)) {
            $method = $this->getMethod($arrayOrObject, $property, self::MODE_WRITE);
            false === $method ?: $arrayOrObject->$method($value);
        }
    }

    public function camelize(string $string): string
    {
        return str_replace('_', '', ucwords($string, '_'));
    }

    private function getMethod($target, $property, $mode = self::MODE_READ)
    {
        $camelized = $this->camelize($property);

        foreach (self::PREFIXES[$mode] as $prefix) {
            $method = $prefix === self::NO_PREF ? lcfirst($camelized) : $prefix.$camelized;
            if (method_exists($target, $method)) {
                return $method;
            }
        }

        return false;
    }
}
