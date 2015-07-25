<?php
namespace Strontium\SpecificationBundle\Form\Type;

use Happyr\DoctrineSpecification\Spec;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints;
use V3d\Model\RecommendationList;

/**
 * @author Aleksey Bannov <a.s.bannov@gmail.com>
 */
class TestSpec extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', [
                'required'    => true,
                'attr'        => [
                    'maxlength' => 255,
                ],
                'specification' => function ($value) {
                    return Spec::eq($value, 'pc');
                },
                'constraints' => [
                    new Constraints\NotBlank(),
                    new Constraints\Length(['min' => 5]),
                ],
            ])
            ->add('active', null, [
                'required' => false,
                'label'    => 'recommendation_list.active'
            ])
            ->add('type', 'choice', [
                'choices'  => array_map(function ($el) {
                    return [$el => sprintf('recommendation_list.type.%s', $el)];
                }, RecommendationList::getAllowedTypes()),
                'required' => true,
                'multiple' => false,
                'expanded' => true,
            ]);
        $closure = function (FormEvent $event) {
            $event->setData(Spec::eq($event->getData(), 'pc'));
        };
        $builder->get('name')
                ->addEventListener(FormEvents::PRE_SUBMIT, $closure)
                ->addEventListener(FormEvents::SUBMIT, $closure);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'attr' => ['novalidate' => '']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'test_spec';
    }
}
