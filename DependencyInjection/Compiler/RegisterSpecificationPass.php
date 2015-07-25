<?php

namespace Strontium\SpecificationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterSpecificationPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $registry = $container->getDefinition('strontium.specification.builder');

        foreach ($container->findTaggedServiceIds('specification') as $id => $attributes) {
            if (!isset($attributes[0]['name'])) {
                throw new \InvalidArgumentException('Tagged specificaton needs to have `name`  attribute.');
            }
            $registry->addMethodCall('registerSpecification', array($attributes[0]['name'], new Reference($id)));
        }

        if ($container->hasDefinition('sylius.expression_language')) {
            $container->getDefinition('sylius.expression_language')
                /* ->addMethodCall(
                     'registerProvider',
                     [new Reference('strontium.expression_language.provider.specification')]
                 )*/
                    ->setClass('Strontium\SpecificationBundle\ExpressionLanguage\SpecificationLanguage')
                      ->addMethodCall('setSpecificationBuilder', [new Reference('strontium.specification.builder')]);
        }
    }
}
