<?php
namespace Strontium\SpecificationBundle;

use Strontium\SpecificationBundle\Builder\SpecificationBuilderInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;

/**
 * @author Aleksey Bannov <a.s.bannov@gmail.com>
 */
interface SpecificationRegistryInterface extends ServiceRegistryInterface
{
    /**
     * @param string $type
     *
     * @return SpecificationBuilderInterface
     */
    public function get($type);
}
