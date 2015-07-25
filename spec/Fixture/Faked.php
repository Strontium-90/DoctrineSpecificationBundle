<?php
namespace Strontium\SpecificationBundle\spec\Fixture;

use Happyr\DoctrineSpecification\BaseSpecification;
use Happyr\DoctrineSpecification\Spec;

/**
 * @author Aleksey Bannov <a.s.bannov@gmail.com>
 */
class Faked extends BaseSpecification
{
    /**
     * Return all the specifications.
     *
     * @return Specification
     */
    protected function getSpec()
    {
        return Spec::eq('is_fake', true);
    }
}
