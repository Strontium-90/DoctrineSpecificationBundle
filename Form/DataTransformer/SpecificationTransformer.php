<?php
namespace Strontium\DoctrineSpecificationBundle\Form\DataTransformer;

use Happyr\DoctrineSpecification\Specification;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class SpecificationTransformer implements DataTransformerInterface
{
    /**
     * @var callable
     */
    protected $callback;


    public function __construct($callback)
    {
        $this->callback = $callback;
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
        if (null === $value || '' === $value) {
            return null;
        }

        $spec = call_user_func($this->callback, $value);
        if ($spec && !($spec instanceof \Happyr\DoctrineSpecification\Filter\Filter
            || $spec instanceof Specification)) {
            throw new TransformationFailedException(sprintf('Не удалось создать спецификацию'));
        }

        return $spec;
    }
}
