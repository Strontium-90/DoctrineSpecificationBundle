<?php
namespace Strontium\DoctrineSpecificationBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Travian\ResourceBundle\Form\DataTransformer\CompoundSpecificationTransformer;
use Travian\ResourceBundle\Form\DataTransformer\SpecificationTransformer;

class SpecificationFromTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!empty($options['specification']) && null !== $options['specification']) {
            if (is_callable($options['specification'])) {
                $builder->addModelTransformer(
                    new SpecificationTransformer($options['specification'])
                );
            } elseif (is_string($options['specification'])) {
                if (!in_array($options['specification'], ['andX', 'orX'])) {
                    throw new InvalidOptionsException(
                        sprintf('Недопустимое значение спецификации, допустимые: andX, OrX')
                    );
                }
                $builder->addModelTransformer(
                    new CompoundSpecificationTransformer($options['specification'])
                );
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setOptional(['specification'])
            ->setAllowedTypes([
                'specification' => ['string', 'callable'],
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
