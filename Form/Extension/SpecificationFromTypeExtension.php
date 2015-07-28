<?php
namespace Strontium\SpecificationBundle\Form\Extension;

use Strontium\SpecificationBundle\Builder\SpecificationBuilder;
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
        if (!empty($options['specification']) && null !== $options['specification']) {
            $builder->addModelTransformer(
                new SpecificationTransformer(
                    $options['specification'],
                    $this->specificationFactory,
                    $options['specification_arguments']
                )
            );
            /*if (is_callable($options['specification'])) {

            } elseif (is_string($options['specification'])) {
                if (!in_array($options['specification'], ['andX', 'orX'])) {
                    throw new InvalidOptionsException(
                        sprintf('Недопустимое значение спецификации, допустимые: andX, OrX')
                    );
                }
                $builder->addModelTransformer(
                    new CompoundSpecificationTransformer($options['specification'])
                );
            }*/
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
                'specification_arguments',
            ])
            ->setAllowedTypes([
                'specification'           => ['string', 'callable'],
                'specification_arguments' => 'array',
            ])
            ->setDefaults([
                'specification_arguments' => [],
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
