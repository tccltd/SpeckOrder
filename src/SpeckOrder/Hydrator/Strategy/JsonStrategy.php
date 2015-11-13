<?php

namespace SpeckOrder\Hydrator\Strategy;

use Zend\Stdlib\Hydrator\Strategy\Exception\InvalidArgumentException;
use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class JsonStrategy implements StrategyInterface
{
    /**
     * @var int|null
     */
    private $encodeOptions;

    /**
     * @var int|null
     */
    private $encodeDepth;

    /**
     * @var boolean
     */
    private $decodeAssociative;

    /**
     * @var int|null
     */
    private $decodeDepth;

    /**
     * @var int|null
     */
    private $decodeOptions;

    /**
     * Constructor
     *
     * @param null $encodeOptions Bit mask of json_encode options
     * @param null $encodeDepth Depth of encode recursion
     * @param bool $decodeAssociative Return an object or associative array
     * @param null $decodeDepth Depth of decode recursion
     * @param null $decodeOptions Bit mask of json_decode options
     */
    public function __construct($encodeOptions=null, $encodeDepth=null, $decodeAssociative=false, $decodeDepth=null, $decodeOptions=null)
    {
        $this->setEncodeOptions($encodeOptions);
        $this->setEncodeDepth($encodeDepth);
        $this->setDecodeAssociative($decodeAssociative);
        $this->setDecodeDepth($decodeDepth);
        $this->setDecodeOptions($decodeOptions);
    }

    /**
     * @param $encodeOptions
     */
    private function setEncodeOptions($encodeOptions)
    {
        if(empty($encodeOptions)) {
            $encodeOptions = 0;
        }

        if(!is_integer($encodeOptions)) {
            throw new InvalidArgumentException(sprintf(
                '%s expects Encode Options to be an integer, %s provided instead.',
                __METHOD__,
                is_object($encodeOptions) ? get_class($encodeOptions) : gettype($encodeOptions)
            ));
        }


        $this->encodeOptions = $encodeOptions;
    }

    /**
     * @param $encodeDepth
     */
    private function setEncodeDepth($encodeDepth)
    {
        if(empty($encodeDepth)) {
            $encodeDepth = 512;
        }

        if(!is_integer($encodeDepth)) {
            throw new InvalidArgumentException(sprintf(
                '%s expects Encode Depth to be an integer, %s provided instead',
                __METHOD__,
                is_object($encodeDepth) ? get_class($encodeDepth) : gettype($encodeDepth)
            ));
        }

        if($encodeDepth <= 0) {
            throw new InvalidArgumentException(sprintf(
                'Encode Depth must be greater than zero. %s provided.',
                $encodeDepth
            ));
        }

        $this->encodeDepth = $encodeDepth;
    }

    /**
     * @param $decodeAssociative
     */
    private function setDecodeAssociative($decodeAssociative)
    {
        if(empty($decodeAssociative)) {
            $decodeAssociative = false;
        }

        if(!is_bool($decodeAssociative)) {
            throw new InvalidArgumentException(sprintf(
                '%s expects Decode Associative to be boolean, %s provided instead',
                __METHOD__,
                is_object($decodeAssociative) ? get_class($decodeAssociative) : gettype($decodeAssociative)
            ));
        }

        $this->decodeAssociative = $decodeAssociative;
    }

    /**
     * @param $decodeDepth
     */
    private function setDecodeDepth($decodeDepth)
    {
        if(empty($decodeDepth)) {
            $decodeDepth = 512;
        }

        if(!is_integer($decodeDepth)) {
            throw new InvalidArgumentException(sprintf(
                '%s expects Decode Depth to be an integer, %s provided instead',
                __METHOD__,
                is_object($decodeDepth) ? get_class($decodeDepth) : gettype($decodeDepth)
            ));
        }

        if($decodeDepth <= 0) {
            throw new InvalidArgumentException(sprintf(
                'Decode Depth must be greater than zero. %s provided.',
                $decodeDepth
            ));
        }

        $this->decodeDepth = $decodeDepth;
    }

    /**
     * @param $decodeOptions
     */
    private function setDecodeOptions($decodeOptions)
    {
        if(empty($decodeOptions)) {
            $decodeOptions = 0;
        }

        if(!is_integer($decodeOptions)) {
            throw new InvalidArgumentException(sprintf(
                '%s expects Decode Options to be an integer, %s provided instead.',
                __METHOD__,
                is_object($decodeOptions) ? get_class($decodeOptions) : gettype($decodeOptions)
            ));
        }

        $this->decodeOptions = $decodeOptions;
    }


    /**
     * {@inheritDoc}
     *
     * Decode a JSON string into an array
     *
     * @param string|null $value
     *
     * @return mixed[]
     *
     * @throws InvalidArgumentException
     */
    public function hydrate($value)
    {
        if (null === $value) {
            return null;
        }

        if (!(is_string($value) || is_numeric($value))) {
            throw new InvalidArgumentException(sprintf(
                '%s expects argument 1 to be string, %s provided instead',
                __METHOD__,
                is_object($value) ? get_class($value) : gettype($value)
            ));
        }

        return json_decode($value, $this->decodeAssociative,$this->decodeDepth, $this->decodeOptions);
    }

    /**
     * {@inheritDoc}
     *
     * Encode an array into a JSON string
     *
     * @param mixed $value The original value.
     *
     * @return string|null
     */
    public function extract($value)
    {
        return empty($value) ? null : json_encode($value, $this->encodeOptions);
    }
}
