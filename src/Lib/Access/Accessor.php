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

        $getter    = self::PREF_GET.$camelized;
        $setter    = self::PREF_SET.$camelized;
        $hasser    = self::PREF_HAS.$camelized;
        $isser     = self::PREF_IS.$camelized;
        $getsetter = lcfirst($camelized);
        $magicGet  = '__'.self::PREF_GET;
        $magicSet  = '__'.self::PREF_SET;
        $magicCall = '__call';

        $methods = [
            self::MODE_READ  => [
                $getter      => $getter,
                $hasser      => $hasser,
                $isser       => $isser,
                $getsetter   => $getsetter,
                $magicGet    => $getter,
                $magicCall   => $getter
            ],
            self::MODE_WRITE => [
                $setter      => $setter,
                $magicSet    => $setter,
                $magicCall   => $setter
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
