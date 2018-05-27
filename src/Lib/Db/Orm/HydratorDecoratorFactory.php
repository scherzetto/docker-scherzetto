<?php

namespace Lib\Db\Orm;

use GuzzleHttp\Psr7\UriResolver;

class HydratorDecoratorFactory
{
    protected $decorators = [];

    public function getShortClassName($fqcn)
    {
        $classArray = explode('\\', $fqcn);
        return array_pop($classArray);
    }

    public function getHydratorForClass($classOrObject, array $args = [])
    {
        if (!is_string($classOrObject) && is_object($classOrObject)) {
            $classOrObject = get_class($classOrObject);
        }

        if (!isset($this->decorators[$classOrObject])) {
            $this->createHydratorForClass($classOrObject, $args);
        }

        return $this->decorators[$this->getShortClassName($classOrObject)];
    }

    public function createHydratorForClass($class, array $args = [])
    {
        $shortClass    = $this->getShortClassName($class);
        $hydratorClass = $shortClass.'HydratorDecorator'.uniqid();
        $dir           = UriResolver::removeDotSegments(__DIR__.'/../../../../var/cache/orm/hydrators/');
        $hydratorFile  = $dir.$hydratorClass.'.php';

        if (!file_exists($hydratorFile) || !is_readable($hydratorFile)) {
            $this->createHydratorFile($class, $hydratorClass, $hydratorFile);
        }

        include($hydratorFile);
        $this->decorators[$shortClass] = new $hydratorClass(...$args);
    }

    public function createHydratorFile($entityClass, $hydratorClass, $hydratorFile)
    {
        $dir = UriResolver::removeDotSegments(dirname($hydratorFile));
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $classHeading = <<<EOD
<?php

use Lib\\Access\\Accessor;

class $hydratorClass extends $entityClass
EOD;
        $classBody = <<<'EOD'
{
    protected $accessor;

    public function hydrate(array $data = [])
    {
        $props = get_object_vars($this);
        $camelized = $this->camelizeData($data);

        foreach (array_keys($props) as $property) {
            if ('accessor' === $property) {
                continue;
            }
            if (array_key_exists($property, $camelized)) {
                $this->$property = $camelized[$property];
            }
        }
    }

    public function camelizeData(array $data)
    {
        $camelized = [];
        foreach ($data as $key => $value) {
            $camelized[$this->camelize($key)] = $value;
        }
        return $camelized;
    }

    public function camelize(string $string)
    {
        if (!$this->accessor || !($this->accessor instanceof Accessor)) {
            $this->accessor = new Accessor();
        }
        return $this->accessor->camelize($string);
    }
}

EOD;
        $class = <<<EOD
$classHeading
$classBody
EOD;
        return file_put_contents($hydratorFile, $class);
    }
}
