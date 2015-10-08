<?php

namespace SpeckOrder\Entity;

class OrderLineMeta implements \ArrayAccess
{
    protected $arrayProperties = [
        'delegates' => true,
        'additionalInformation' => true,
        'additionalMetadata' => true,
        'productId' => true,
        'itemNumber' => true,
    ];

    protected $delegates = array();

    protected $productId;

    protected $itemNumber;

    protected $additionalInformation = array();

    protected $additionalMetadata = array();

    public function __construct(array $config = array())
    {
//         if (count($config)) {
//            $this->parentOptionId   = isset($config['parent_option_id'])   ? $config['parent_option_id']   : null;
//            $this->productId        = isset($config['product_id'])         ? $config['product_id']         : null;
//            $this->itemNumber       = isset($config['item_number'])        ? $config['item_number']        : null;
//            $this->parentOptionName = isset($config['parent_option_name']) ? $config['parent_option_name'] : null;
//            $this->flatOptions      = isset($config['flat_options'])       ? $config['flat_options']       : array();
//            $this->image            = isset($config['image'])              ? $config['image']              : null;
//            $this->uom              = isset($config['uom'])                ? $config['uom']                : null;
//             $this->productTypeId   = isset($config['product_type_id'])    ? $config['product_type_id']    : null;
//         }
    }

    /**
     * An array of arrays containing first name, last name and email.
     *
     * @param unknown $delegates
     */
    public function setDelegates($delegates)
    {

    }

    public function addDelegate($firstName, $lastName, $email)
    {
        $this->delegates[] = array(
            'firstName' => $firstName,
            'lastName'  => $lastName,
            'email'     => $email,
        );
    }

    public function setProductId($productId)
    {
        $this->productId = $productId;
        return $this;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function setItemNumber($itemNumber)
    {
        $this->itemNumber = $itemNumber;
        return $this;
    }

    public function getItemNumber()
    {
        return $this->itemNumber;
    }

    public function addAdditionalInformation($title, $information)
    {
         $this->additionalInformation[$title] = $information;
    }

    public function addAdditionalMetadata(AbstractOrderLineAdditionalMeta $metadata)
    {
        $this->additionalMetadata[$metadata->getIdentifier()] = $metadata;
    }

    public function removeAdditionalMeta($key)
    {
        if(isset($this->additionalMetadata[$key])) {
            unset($this->additionalMetadata[$key]);
        }
    }

    public function getAdditionalMeta($key=null) {
        if(isset($key)) {
            return isset($this->additionalMetadata[$key]) ? $this->additionalMetadata[$key] : false;
        } else {
            return $this->additionalMetadata;
        }
    }


    public function offsetExists($offset)
    {
        return isset($this->arrayProperties[$offset]) && $this->arrayProperties[$offset];
    }

    public function offsetGet($offset)
    {
        if($this->offsetExists($offset)) {
            return $this->$offset;
        }
        // Should probably throw an exception...
        return false;
    }

    public function offsetSet($offset, $value)
    {
        // Do nothing yet.
    }

    public function offsetUnset($offset)
    {
        // Do nothing yet.
    }
}
