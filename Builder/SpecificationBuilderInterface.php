<?php
namespace Strontium\SpecificationBundle\Builder;

use Happyr\DoctrineSpecification\Specification\Specification;
use Strontium\SpecificationBundle\SpecificationFactory;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Aleksey Bannov <a.s.bannov@gmail.com>
 */
interface SpecificationBuilderInterface
{

    /**
     * @param SpecificationFactory $factory
     * @param array                $options
     *
     * @return Specification
     */
    public function buildSpecification(SpecificationFactory $factory, array $options);

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver);
}
