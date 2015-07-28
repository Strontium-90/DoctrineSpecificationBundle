<?php
namespace Strontium\SpecificationBundle\Builder;

use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractSpecificationBuilder implements SpecificationBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
    }
}
