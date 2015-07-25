<?php
namespace Strontium\SpecificationBundle\Form\Extension;

use Strontium\SpecificationBundle\Builder\SpecificationBuilder;
use Strontium\SpecificationBundle\Builder\SpecificationBuilderInterface;
use Strontium\SpecificationBundle\Form\DataTransformer\SpecificationTransformer;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SpecificationFromTypeExtension extends AbstractTypeExtension
{
    /**
     * @var SpecificationBuilder
     */
    protected $specificationBuilder;

    /**
     * @param SpecificationBuilderInterface $specificationBuilder
     */
    public function __construct(SpecificationBuilderInterface $specificationBuilder)
    {
        $this->specificationBuilder = $specificationBuilder;
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
                    $this->specificationBuilder,
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
