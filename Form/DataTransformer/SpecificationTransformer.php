<?php
namespace Strontium\SpecificationBundle\Form\DataTransformer;

use Strontium\SpecificationBundle\SpecificationFactory;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class SpecificationTransformer implements DataTransformerInterface
{
    /**
     * @var callable
     */
    protected $callback;

    /**
     * @var array
     */
    protected $arguments;

    /**
     * @var
     */
    private $specificationFactory;

    /**
     * @param string|callable      $callback
     * @param SpecificationFactory $specificationFactory
     * @param array                $arguments
     */
    public function __construct($callback, SpecificationFactory $specificationFactory, array $arguments = null)
    {
        $this->callback = $callback;
        $this->arguments = $arguments;
        $this->specificationFactory = $specificationFactory;
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
            if (is_callable($this->callback)) {
                return call_user_func($this->callback, $arguments);
            } else {
                return $this->specificationFactory->{$this->callback}($arguments);
            }
        } catch (\Exception $e) {
            throw new TransformationFailedException(sprintf('Unable create specification: %s', $e->getMessage()));
        }
    }
}
