<?php
namespace Strontium\SpecificationBundle\Builder;

use Happyr\DoctrineSpecification\Specification\Specification;

class SpecificationBuilder implements SpecificationBuilderInterface
{
    protected $specs = [];

    public function __construct()
    {
        $factoryClass = 'Happyr\DoctrineSpecification\Spec';
        $refl = new \ReflectionClass($factoryClass);
        foreach ($refl->getMethods(\ReflectionMethod::IS_STATIC) as $method) {
            $this->registerSpecification($method->getName(), [$factoryClass, $method->getName()]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function registerSpecification($name, $definition)
    {
        $this->specs[$name] = $definition;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function unregisterSpecification($name)
    {
        unset($this->specs[$name]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasSpecification($name)
    {
        return array_key_exists($name, $this->specs);
    }

    /**
     * {@inheritdoc}
     */
    public function spec($name, array $arguments = null)
    {
        if (array_key_exists($name, $this->specs)) {
            $specDef = $this->specs[$name];
            if (is_object($specDef)) {
                $spec = $specDef;
            } elseif (is_callable($specDef)) {
                $spec = call_user_func_array($specDef, $arguments);
            } elseif (is_string($specDef)) {
                $spec = (new \ReflectionClass($specDef))->newInstanceArgs($arguments);
            } else {
                throw new \InvalidArgumentException('Unable to create specification');
            }

            return $spec;
        }

        throw new \InvalidArgumentException(sprintf('Specification "%s" does not exists', $name));
    }

    /**
     * @param string $name
     * @param        $arguments
     *
     * @return Specification
     */
    public function __call($name, array $arguments)
    {
        return $this->spec($name, $arguments);
    }
}
