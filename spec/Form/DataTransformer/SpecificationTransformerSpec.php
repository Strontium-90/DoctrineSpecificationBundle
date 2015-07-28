<?php
namespace spec\Strontium\SpecificationBundle\Form\DataTransformer;

use Happyr\DoctrineSpecification\Spec;
use PhpSpec\ObjectBehavior;
use Strontium\SpecificationBundle\Form\DataTransformer\SpecificationTransformer;
use Strontium\SpecificationBundle\SpecificationFactory;

/**
 * @author Aleksey Bannov <a.s.bannov@gmail.com>
 * @mixin SpecificationTransformer
 */
class SpecificationTransformerSpec extends ObjectBehavior
{
    protected $closure;

    function let(SpecificationFactory $specificationFactory)
    {
        $this->closure = function ($value) {
            return Spec::eq('name', 'foo');
        };
        $this->beConstructedWith($this->closure, $specificationFactory, 'value', ['name']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Strontium\SpecificationBundle\Form\DataTransformer\SpecificationTransformer');
    }

    function it_is_a_data_transformer()
    {
        $this->shouldImplement('Symfony\Component\Form\DataTransformerInterface');
    }

    function it_should_not_reverseTransform_empty_values()
    {
        $this->reverseTransform(null)->shouldReturn(null);
        $this->reverseTransform('')->shouldReturn(null);
        $this->reverseTransform([])->shouldReturn(null);
    }

    function it_should_reverseTransform_value_by_closure(SpecificationFactory $specificationFactory)
    {
        $this->beConstructedWith(
            function (SpecificationFactory $spec, $value) {
                return Spec::eq('name', $value);
            },
            $specificationFactory,
            'value'
        );
        $this->reverseTransform('foo')->shouldBeLike(Spec::eq('name', 'foo'));
    }

    function it_should_reverseTransform_value_by_builder(SpecificationFactory $specificationFactory)
    {
        $this->beConstructedWith('eq', $specificationFactory, 'value', ['field' => 'name']);

        $spec = Spec::eq('name', 'foo');
        $specificationFactory->eq(['field' => 'name', 'value' => 'foo'])
                             ->willReturn(clone $spec);

        $this->reverseTransform('foo')->shouldBeLike($spec);
    }

    function it_should_throw_transformation_failed_exception(SpecificationFactory $specificationFactory)
    {
        $this->beConstructedWith('eq', $specificationFactory, 'value');

        $specificationFactory->eq()->willThrow(new \Exception('fake exception'));

        $this->shouldThrow('Symfony\Component\Form\Exception\TransformationFailedException')
             ->duringReverseTransform('foo');
    }
}
