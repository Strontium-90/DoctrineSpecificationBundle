<?php
namespace Strontium\SpecificationBundle\ExpressionLanguage;

use Strontium\SpecificationBundle\Builder\SpecificationBuilderInterface;
use Sylius\Bundle\ResourceBundle\ExpressionLanguage\ExpressionLanguage as BaseExpressionLanguage;

/**
 * @author Aleksey Bannov <a.s.bannov@gmail.com>
 */
class SpecificationLanguage extends BaseExpressionLanguage
{
    /**
     * @var SpecificationBuilderInterface
     */
    protected $specificationBuilder;

    /**
     * @param SpecificationBuilderInterface $specificationBuilder
     */
    public function setSpecificationBuilder(SpecificationBuilderInterface $specificationBuilder)
    {
        $this->specificationBuilder = $specificationBuilder;
    }

    public function evaluate($expression, $values = array())
    {
        $values['spec'] = $this->specificationBuilder;

        return parent::evaluate($expression, $values);
    }
}
