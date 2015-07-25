<?php
namespace Strontium\SpecificationBundle;

use Strontium\SpecificationBundle\DependencyInjection\Compiler\RegisterSpecificationPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Aleksey Bannov <a.s.bannov@gmail.com>
 */
class SpecificationBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new RegisterSpecificationPass());
    }
}
