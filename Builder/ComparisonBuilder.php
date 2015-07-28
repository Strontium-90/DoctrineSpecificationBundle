<?php
namespace Strontium\SpecificationBundle\Builder;

use Happyr\DoctrineSpecification\Filter\Comparison;
use Strontium\SpecificationBundle\SpecificationFactory;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Aleksey Bannov <a.s.bannov@gmail.com>
 */
class ComparisonBuilder implements SpecificationBuilderInterface
{
    /**
     * @var string
     */
    protected $operator;

    /**
     * @param string $operator
     */
    public function __construct($operator)
    {
        $this->operator = $operator;
    }

    /**
     * @inheritDoc
     */
    public function buildSpecification(SpecificationFactory $spec, array $options)
    {
        return new Comparison($this->operator, $options['field'], $options['value'], $options['dql_alias']);
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['field', 'value']);
    }
}
