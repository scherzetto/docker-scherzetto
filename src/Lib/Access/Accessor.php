<?php

namespace Lib\Access;

class Accessor
{
    const MODE_READ = 0;
    const MODE_WRITE = 1;

    const PREF_GET = "get";
    const PREF_HAS = "has";
    const PREF_IS = "is";
    const PREF_SET = "set";

    public function readValue($arrayOrObject, $property)
    {
        if (\is_array($arrayOrObject)) {
            return $arrayOrObject[$property];
        } elseif (\is_object($arrayOrObject)) {
            $method = $this->getMethod($arrayOrObject, $property);
            return $method ? $arrayOrObject->$method() : false;
        } else {
            return false;
        }
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

    private function getMethod($target, $property, $mode = self::MODE_READ)
    {
        $refObject = new \ReflectionClass(get_class($target));
        $camelized = $this->camelize($property);

        $magicGet  = '__'.self::PREF_GET;
        $magicSet  = '__'.self::PREF_SET;
        $magicCall = '__call';

        $methods = [
            self::MODE_READ  => [
                self::PREF_GET.$camelized => self::PREF_GET.$camelized,
                self::PREF_HAS.$camelized => self::PREF_HAS.$camelized,
                self::PREF_IS.$camelized  => self::PREF_IS.$camelized,
                lcfirst($camelized)       => lcfirst($camelized),
                $magicGet                 => self::PREF_GET.$camelized,
                $magicCall                => self::PREF_GET.$camelized
            ],
            self::MODE_WRITE => [
                self::PREF_SET.$camelized => self::PREF_SET.$camelized,
                $magicSet                 => self::PREF_SET.$camelized,
                $magicCall                => self::PREF_SET.$camelized
            ]
        ];

        foreach ($methods[$mode] as $name => $method) {
            if ($refObject->hasMethod($name)) {
                return $method;
            }
        }
        return false;
    }

    public function camelize($string)
    {
        return str_replace('_', '', ucwords($string, '_'));
    }
}
