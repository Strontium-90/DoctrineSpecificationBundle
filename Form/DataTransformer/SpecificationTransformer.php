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
     * @var string
     */
    private $valueName;

    /**
     * @param string|callable      $callback
     * @param SpecificationFactory $specificationFactory
     * @param string               $valueName
     * @param array                $arguments
     */
    public function __construct(
        $callback,
        SpecificationFactory $specificationFactory,
        $valueName,
        array $arguments = []
    ) {
        $this->callback = $callback;
        $this->arguments = $arguments;
        $this->specificationFactory = $specificationFactory;
        $this->valueName = $valueName;
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

        try {
            if (is_callable($this->callback)) {
                return call_user_func_array($this->callback, [$this->specificationFactory, $value]);
            } else {
                return $this->specificationFactory->{$this->callback}(
                    array_merge($this->arguments, [$this->valueName => $value])
                );
            }
        } catch (\Exception $e) {
            throw new TransformationFailedException(sprintf('Unable create specification: %s', $e->getMessage()));
        }
    }
}
