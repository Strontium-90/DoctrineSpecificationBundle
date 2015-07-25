<?php
namespace Strontium\SpecificationBundle\Form\DataTransformer;

use Strontium\SpecificationBundle\Builder\SpecificationBuilderInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class SpecificationTransformer implements DataTransformerInterface
{
    /**
     * @var callable
     */
    protected $callback;

    /**
     * @var SpecificationBuilderInterface
     */
    protected $specificationBuilder;

    /**
     * @var array
     */
    protected $arguments;

    /**
     * @param string|callable               $callback
     * @param SpecificationBuilderInterface $specificationBuilder
     * @param array                         $arguments
     */
    public function __construct($callback, SpecificationBuilderInterface $specificationBuilder, array $arguments = null)
    {
        $this->callback = $callback;
        $this->specificationBuilder = $specificationBuilder;
        $this->arguments = $arguments;
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
        if (empty($value)) {
            return null;
        }

        $arguments = !empty($this->arguments) ? array_merge($this->arguments, [$value]) : $value;
        try {
            if (is_string($this->callback)) {
                return $this->specificationBuilder->spec($this->callback, $arguments);
            } else {
                return call_user_func($this->callback, $arguments);
            }
        } catch (\Exception $e) {
            throw new TransformationFailedException(sprintf('Unable create specification: %s', $e->getMessage()));
        }
    }
}
