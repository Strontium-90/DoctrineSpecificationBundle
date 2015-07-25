<?php
namespace spec\Strontium\SpecificationBundle\Builder;

use Happyr\DoctrineSpecification\Spec;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Strontium\SpecificationBundle\Builder\SpecificationBuilder;
use Strontium\SpecificationBundle\spec\Fixture\Faked;
use Strontium\SpecificationBundle\spec\Fixture\NameEqual;

/**
 * @author Aleksey Bannov <a.s.bannov@gmail.com>
 * @mixin SpecificationBuilder
 */
class SpecificationBuilderSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith();

        $this
            ->registerSpecification('isActive', function () {
                return Spec::eq('active', true);
            })
            ->registerSpecification('eq', ['Happyr\DoctrineSpecification\Spec', 'eq'])
            ->registerSpecification('name_equal', 'Strontium\SpecificationBundle\spec\Fixture\NameEqual');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Strontium\SpecificationBundle\Builder\SpecificationBuilder');
    }

    function it_should_build_static_spec()
    {
        $this->spec('eq', ['field', 123])->shouldBeLike(Spec::eq('field', 123));
    }

    function it_should_build_object_spec()
    {
        $definition = new Faked();
        $this->registerSpecification('fake', $definition);
        $this->spec('fake')->shouldReturn($definition);
    }

    function it_should_build_new_spec()
    {
        $this->spec('name_equal', ['some_name'])
             ->shouldBeLike(new NameEqual('some_name'));
    }
}
