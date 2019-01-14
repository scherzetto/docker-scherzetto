<?php

declare(strict_types=1);

namespace Lib\Access;

class Accessor
{
    const MODE_READ = 0;
    const MODE_WRITE = 1;

    const PREF_GET = 'get';
    const PREF_HAS = 'has';
    const PREF_IS = 'is';
    const PREF_SET = 'set';

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

    public function camelize($string)
    {
        return str_replace('_', '', ucwords($string, '_'));
    }

    private function getMethod($target, $property, $mode = self::MODE_READ)
    {
        $camelized = $this->camelize($property);

        $methods = [
            self::MODE_READ => [
                self::PREF_GET.$camelized,
                self::PREF_HAS.$camelized,
                self::PREF_IS.$camelized,
            ],
            self::MODE_WRITE => [
                self::PREF_SET.$camelized,
            ],
        ];

        foreach ($methods[$mode] as $method) {
            if (method_exists($target, $method)) {
                return $method;
            }
        }

        return false;
    }
}
