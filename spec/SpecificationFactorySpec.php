<?php
namespace spec\Strontium\SpecificationBundle;

use Happyr\DoctrineSpecification\Spec;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Strontium\SpecificationBundle\Builder\ComparisonBuilder;
use Strontium\SpecificationBundle\SpecificationFactory;
use Sylius\Component\Registry\ServiceRegistry;

/**
 * @author Aleksey Bannov <a.s.bannov@gmail.com>
 * @mixin SpecificationFactory
 */
class SpecificationFactorySpec extends ObjectBehavior
{
    function let(ServiceRegistry $registry)
    {
        $this->beConstructedWith($registry);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Strontium\SpecificationBundle\SpecificationFactory');
    }

    function it_should_create_buildin_spec()
    {
        $this->andX('foo', 'bar')->shouldHaveType('Happyr\DoctrineSpecification\Logic\LogicX');
    }

    function it_should_create_spec_from_registry(ServiceRegistry $registry)
    {
        $lte = new ComparisonBuilder('<=');
        $registry->has('lte')->willReturn(true);
        $registry->get('lte')->willReturn($lte);

        $this->lte(['field'=> 'stars', 'value' => 4])->shouldBeLike(Spec::lte('stars', 4));
    }

    function it_should_trow_exception_if_spec_does_not_exists(){
        $this->shouldThrow('Strontium\SpecificationBundle\Exception\NotExistingSpecificationException')
             ->duringUnknownSpec();
    }
}
