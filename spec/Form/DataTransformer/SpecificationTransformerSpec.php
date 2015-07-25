<?php
namespace spec\Strontium\SpecificationBundle\Form\DataTransformer;

use Happyr\DoctrineSpecification\Spec;
use PhpSpec\ObjectBehavior;
use Strontium\SpecificationBundle\Builder\SpecificationBuilderInterface;
use Strontium\SpecificationBundle\Form\DataTransformer\SpecificationTransformer;

/**
 * @author Aleksey Bannov <a.s.bannov@gmail.com>
 * @mixin SpecificationTransformer
 */
class SpecificationTransformerSpec extends ObjectBehavior
{
    protected $closure;

    function let(SpecificationBuilderInterface $specificationBuilder)
    {
        $this->closure = function ($value) {
            return Spec::eq('name', 'foo');
        };
        $this->beConstructedWith($this->closure, $specificationBuilder, ['name']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Strontium\SpecificationBundle\Form\DataTransformer\SpecificationTransformer');
    }

    function it_should_not_reverseTransform_empty_values()
    {
        $this->reverseTransform(null)->shouldReturn(null);
        $this->reverseTransform('')->shouldReturn(null);
        $this->reverseTransform([])->shouldReturn(null);
    }

    function it_should_reverseTransform_value_by_closure(SpecificationBuilderInterface $specificationBuilder)
    {
        $this->beConstructedWith(
            function ($value) {
                return Spec::eq('name', $value);
            },
            $specificationBuilder
        );
        $this->reverseTransform('foo')->shouldBeLike(Spec::eq('name', 'foo'));
    }

    function it_should_reverseTransform_value_by_builder(SpecificationBuilderInterface $specificationBuilder)
    {
        $this->beConstructedWith('eq', $specificationBuilder, ['name']);

        $spec = Spec::eq('name', 'foo');

        $specificationBuilder->spec('eq', ['name', 'foo'])
                             ->willReturn($spec);

        $this->reverseTransform('foo')->shouldReturn($spec);
    }
}
