<?php
namespace Strontium\DoctrineSpecificationBundle\ExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage as BaseExpressionLanguage;

/**
 * @author Aleksey Bannov <a.s.bannov@gmail.com>
 */
class ExpressionLanguage extends BaseExpressionLanguage
{
    /**
     * {@inheritdoc}
     */
    protected function registerFunctions()
    {
        parent::registerFunctions();

        $this->register(
            'spec',
            function ($date) {
                return sprintf('(new \DateTime(%s))', $date);
            },
            function (array $values, $date) {
                return new \DateTime($date);
            });
    }
}
