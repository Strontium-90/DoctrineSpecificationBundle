<?php
namespace Strontium\SpecificationBundle;

use Happyr\DoctrineSpecification\Specification\Specification;
use Sylius\Component\Registry\ServiceRegistryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Aleksey Bannov <a.s.bannov@gmail.com>
 */
class SpecificationFactory
{
    /**
     * @var SpecificationRegistryInterface
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
}
