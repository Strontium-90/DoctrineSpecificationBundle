<?php
namespace Strontium\SpecificationBundle\ExpressionLanguage;

use Strontium\SpecificationBundle\SpecificationFactory;
use Sylius\Bundle\ResourceBundle\ExpressionLanguage\ExpressionLanguage as BaseExpressionLanguage;

/**
 * @author Aleksey Bannov <a.s.bannov@gmail.com>
 */
class SpecificationLanguage extends BaseExpressionLanguage
{
    /**
     * @var SpecificationFactory
     */
    protected $factory;

    /**
     * @param SpecificationFactory $specificationBuilder
     */
    public function setSpecificationBuilder(SpecificationFactory $factory)
    {
        $this->factory = $factory;
    }

    public function evaluate($expression, $values = array())
    {
        $values['spec'] = $this->factory;

        return parent::evaluate($expression, $values);
    }
}
