<?php
namespace Strontium\SpecificationBundle;

use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Logic\LogicX;
use Happyr\DoctrineSpecification\Specification\Specification;
use Strontium\SpecificationBundle\Exception\NotExistingSpecificationException;
use Sylius\Component\Registry\ServiceRegistryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Aleksey Bannov <a.s.bannov@gmail.com>
 *
 * @method Filter eq(array $options)
 * @method Filter neq(array $options)
 * @method Filter lt(array $options)
 * @method Filter lte(array $options)
 * @method Filter gt(array $options)
 * @method Filter gte(array $options)
 * @method Filter like(array $options)
 *
 */
class SpecificationFactory
{
    /**
     * @var ServiceRegistryInterface
     */
    protected $registry;

    /**
     * @param ServiceRegistryInterface $registry
     */
    public function __construct(ServiceRegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return Specification
     */
    public function __call($name, array $arguments)
    {
        return $this->createSpec($name, $arguments);
    }

    /**
     * @return LogicX
     */
    public function andX()
    {
        return new LogicX(LogicX::AND_X, func_get_args());
    }

    /**
     * @return LogicX
     */
    public function orX()
    {
        return new LogicX(LogicX::OR_X, func_get_args());
    }

    /**
     * @param array $childs
     *
     * @return mixed
     */
    public function andXArray(array $childs)
    {
        return call_user_func_array([$this, 'andX'], $childs);
    }

    /**
     * @param array $childs
     *
     * @return mixed
     */
    public function orXArray(array $childs)
    {
        return call_user_func_array([$this, 'orX'], $childs);
    }

    /**
     * @param       $name
     * @param array $arguments
     *
     * @return mixed
     */
    public function createSpec($name, array $arguments)
    {
        if ($this->registry->has($name)) {
            $builder = $this->registry->get($name);

            $optionResolver = new OptionsResolver();
            $optionResolver
                ->setDefined(['dql_alias'])
                ->setDefaults(['dql_alias' => null]);
            $builder->configureOptions($optionResolver);
            $options = $optionResolver->resolve(isset($arguments[0]) ? $arguments[0] : []);

            return $builder->buildSpecification($this, $options);
        }

        throw new NotExistingSpecificationException($name);
    }
}
