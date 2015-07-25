<?php
namespace Strontium\DoctrineSpecificationBundle\Form\DataTransformer;

use Happyr\DoctrineSpecification\Logic\LogicX;
use Happyr\DoctrineSpecification\Specification;
use Symfony\Component\Form\DataTransformerInterface;

class CompoundSpecificationTransformer implements DataTransformerInterface
{
    /**
     * @var string
     */
    protected $type;


    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        if ($value === null || !is_array($value)) {
            return null;
        }
        $spec = null;

        $sp = [];
        foreach ($value as $child) {
            if ($child instanceof \Happyr\DoctrineSpecification\Filter\Filter
                || $child instanceof Specification
            ) {
                $sp[] = $child;
            }
        }
        if (count($sp)) {
            $spec = new LogicX($this->type, $sp);
        }

        return $spec;
    }
}
