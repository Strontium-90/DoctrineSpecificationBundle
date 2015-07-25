<?php
namespace Strontium\SpecificationBundle\ExpressionLanguage;

use Strontium\SpecificationBundle\Builder\SpecificationBuilderInterface;
use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

/**
 * @author Aleksey Bannov <a.s.bannov@gmail.com>
 */
class SpecificationLanguageProvider implements ExpressionFunctionProviderInterface
{
    /**
     * @var SpecificationBuilderInterface
     */
    protected $specificationBuilder;

    /**
     * @param SpecificationBuilderInterface $specificationBuilder
     */
    public function __construct(SpecificationBuilderInterface $specificationBuilder)
    {
        $this->specificationBuilder = $specificationBuilder;
    }

    public function getFunctions()
    {
        return array(
            new ExpressionFunction(
                'spec',
                function () {
                    return sprintf('spec()');
                },
                function ($c) {
                    return $this->specificationBuilder;
                }
            ),
        );
    }
}
