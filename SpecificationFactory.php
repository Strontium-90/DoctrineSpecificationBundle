<?php
namespace Strontium\SpecificationBundle;

use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Specification\Specification;
use Sylius\Component\Registry\ServiceRegistryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Aleksey Bannov <a.s.bannov@gmail.com>
 *
 * @method Filter eq(int $int1, int $int2)
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
     * @param array  $options
     *
     * @return Specification
     */
    public function create($name, array $options = [])
    {
        $builder = $this->registry->get($name);

        $optionResolver = new OptionsResolver();
        $optionResolver
            ->setDefined(['dql_alias'])
            ->setDefaults(['dql_alias' => null]);
        $builder->configureOptions($optionResolver);
        $options = $optionResolver->resolve($options);

        return $builder->buildSpecification($this, $options);
    }


    /**
     * @param string $name
     * @param array  $options
     *
     * @return Specification
     */
    public function __call($name, array $options)
    {
        if ($this->registry->has($name)) {
            $builder = $this->registry->get($name);

            return $builder->buildSpecification($this, $options);
        }

        trigger_error(sprintf('Call to undefined method %s::%s()', __CLASS__, $name), E_USER_ERROR);
    }
}
