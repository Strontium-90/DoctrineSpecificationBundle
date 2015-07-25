<?php
namespace Strontium\SpecificationBundle\Builder;

use Happyr\DoctrineSpecification\Specification\Specification;


/**
 * @author Aleksey Bannov <a.s.bannov@gmail.com>
 */
interface SpecificationBuilderInterface
{

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return Specification
     *
     * @throws \InvalidArgumentException
     */
    public function spec($name, array $arguments = null);

    /**
     * @param string $name
     * @param mixed  $definition
     *
     * @return $this
     */
    public function registerSpecification($name, $definition);

    /**
     * @param string $name
     *
     * @return $this
     */
    public function unregisterSpecification($name);

    /**
     * @param $name
     *
     * @return bool
     */
    public function hasSpecification($name);
}
