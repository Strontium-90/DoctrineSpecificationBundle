<?php
namespace Strontium\DoctrineSpecificationBundle\ExpressionLanguage;

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
            'date',
            function ($date) {
                return sprintf('(new \DateTime(%s))', $date);
            },
            function (array $values, $date) {
                return new \DateTime($date);
            });
    }
}
