<?php
namespace spec\Strontium\SpecificationBundle\Form\Extension;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Strontium\SpecificationBundle\Builder\SpecificationBuilderInterface;
use Strontium\SpecificationBundle\Form\Extension\SpecificationFromTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Aleksey Bannov <a.s.bannov@gmail.com>
 * @mixin SpecificationFromTypeExtension
 */
class SpecificationFromTypeExtensionSpec extends ObjectBehavior
{

    function let(SpecificationBuilderInterface $specificationBuilder)
    {
        $this->beConstructedWith($specificationBuilder);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Strontium\SpecificationBundle\Form\Extension\SpecificationFromTypeExtension');
    }

    function it_is_a_form_extension()
    {
        $this->shouldImplement('Symfony\Component\Form\FormTypeExtensionInterface');
    }

    function it_should_not_build_form_with_specification_transformers_if_its_empty(FormBuilderInterface $builder)
    {
        $builder->addModelTransformer()->shouldNotBeCalled();

        $this->buildForm($builder, []);
        $this->buildForm($builder, ['specification' => null]);
        $this->buildForm($builder, ['specification' => '']);
    }

    function it_should_build_form_with_specification_transformers(FormBuilderInterface $builder)
    {
        $builder
            ->addModelTransformer(
                Argument::type('Strontium\SpecificationBundle\Form\DataTransformer\SpecificationTransformer')
            )
            ->shouldBeCalled();

        $this->buildForm($builder, [
            'specification'           => 'eq',
            'specification_arguments' => ['name', 'o'],
        ]);
    }

    function it_should_configure_options_with_specification_and_arguments(OptionsResolver $resolver)
    {
        $resolver
            ->setDefined([
                'specification',
                'specification_arguments',
            ])
            ->willReturn($resolver);
        $resolver
            ->setAllowedTypes([
                'specification'           => ['string', 'callable'],
                'specification_arguments' => 'array',
            ])
            ->willReturn($resolver);
        $resolver
            ->setDefaults([
                'specification_arguments' => [],
            ])
            ->willReturn($resolver);

        $this->configureOptions($resolver);
    }

    function it_extends_a_form_type()
    {
        $this->getExtendedType()->shouldReturn('form');
    }
}
