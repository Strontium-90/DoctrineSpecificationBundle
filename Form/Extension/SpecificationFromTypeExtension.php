<?php
namespace Strontium\SpecificationBundle\Form\Extension;

use Strontium\SpecificationBundle\Form\DataTransformer\SpecificationTransformer;
use Strontium\SpecificationBundle\SpecificationFactory;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SpecificationFromTypeExtension extends AbstractTypeExtension
{
    /**
     * @var SpecificationFactory
     */
    private $specificationFactory;

    /**
     * @param SpecificationFactory $specificationFactory
     */
    public function __construct(SpecificationFactory $specificationFactory)
    {
        $this->specificationFactory = $specificationFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!empty($options['specification'])) {
            $builder->addModelTransformer(
                new SpecificationTransformer(
                    $options['specification'],
                    $this->specificationFactory,
                    $options['specification_arguments']
                )
            );
        }
    }

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
            ->setDefined([
                'specification',
                'specification_options',
            ])
            ->setAllowedTypes([
                'specification'         => ['string', 'callable'],
                'specification_options' => 'array',
            ])
            ->setDefaults([
                'specification_options' => [],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'form';
    }
} 
