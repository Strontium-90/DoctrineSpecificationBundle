<?php
namespace Strontium\SpecificationBundle\Builder;

use Happyr\DoctrineSpecification\Specification\Specification;
use Strontium\SpecificationBundle\SpecificationFactory;

/**
 * @author Aleksey Bannov <a.s.bannov@gmail.com>
 */
interface SpecificationBuilderInterface
{

    /**
     * @param SpecificationFactory $spec
     * @param array                $options
     *
     * @return Specification
     */
    public function buildSpecification(SpecificationFactory $spec, array $options);
}
