<?php
namespace Strontium\SpecificationBundle\Exception;

/**
 * @author Aleksey Bannov <a.s.bannov@gmail.com>
 */
class NotExistingSpecificationException extends \InvalidArgumentException
{
    /**
     * {@inheritdoc}
     */
    public function __construct($name)
    {
        parent::__construct(sprintf('Specification "%s" does not exists', $name));
    }
}
