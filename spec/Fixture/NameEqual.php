<?php
namespace Strontium\SpecificationBundle\spec\Fixture;

use Happyr\DoctrineSpecification\BaseSpecification;
use Happyr\DoctrineSpecification\Spec;

/**
 * @author Aleksey Bannov <a.s.bannov@gmail.com>
 */
class NameEqual extends BaseSpecification
{
    /**
     * @var null|string
     */
    private $value;

    /**
     * @param string $dqlAlias
     */
    public function __construct($value, $dqlAlias = null)
    {
        parent::__construct($dqlAlias);
        $this->value = $value;
    }

    /**
     * Return all the specifications.
     *
     * @return Specification
     */
    protected function getSpec()
    {
        return Spec::like('name', $this->value);
    }
}
