<?php
namespace Strontium\SpecificationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ResourceFilterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'csrf_protection' => false,
            ])
            ->setDefined([
                'resource_repository',
                'resource_specification',
            ])
            ->setRequired([
                'specification'
            ])
            ->setAllowedTypes([
                'resource_repository'    => 'Doctrine\\ORM\\EntityRepository',
                'resource_specification' => 'Happyr\\DoctrineSpecification\\Specification',
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'resource_filter';
    }
}
