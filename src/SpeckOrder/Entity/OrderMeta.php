<?php

namespace SpeckOrder\Entity;

class OrderMeta implements OrderMetaInterface, \ArrayAccess
{
    static protected $arrayProperties = [
        'customer' => true,
        'billing'  => true,
	    'payment'  => true,
        'consent'  => true,
    ];

    protected $customer = [];
    protected $billing = [
	   'title' => null,
    ];
    protected $payment = [];
    protected $consent = [];

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

    public function getCustomer()
    {
        return $this->customer;
    }

    public function setCustomerTitle($title)
    {
        $this->customer['title'] = $title;

        return $this;
    }

    public function setCustomerFirstName($firstName)
    {
        $this->customer['firstName'] = $firstName;

        return $this;
    }

    public function setCustomerLastName($lastName)
    {
        $this->customer['lastName'] = $lastName;

        return $this;
    }

    public function setCustomerName($firstName, $lastName=null)
    {
        // TODO: Add logic when firstname and lastname are not separate.

        $this->setCustomerFirstName($firstName)
             ->setCustomerLastName($lastName);

        return $this;
    }

    public function setCustomerTelephone($telephone)
    {
        $this->customer['telephone'] = $telephone;

        return $this;
    }

    public function setCustomerEmail($email)
    {
        $this->customer['email'] = $email;

        return $this;
    }

    public function getCustomerAddress()
    {
        return $this->customer['address'];
    }

    public function setCustomerAddress($address)
    {
        $this->customer['address'] = $address;

        return $this;
    }

    public function setCustomerCompanyName($companyName)
    {
        $this->customer['companyName'] = $companyName;

        return $this;
    }

    public function setCustomerJobTitle($jobTitle)
    {
        $this->customer['jobTitle'] = $jobTitle;

        return $this;
    }

    public function setCustomerCompanySize($companySize)
    {
        $this->customer['companySize'] = $companySize;

        return $this;
    }

    public function setBillingTitle($title)
    {
        $this->billing['title'] = $title;

        return $this;
    }


    public function setBillingFirstName($firstName)
    {
        $this->billing['firstName'] = $firstName;

        return $this;
    }

    public function setBillingLastName($lastName)
    {
        $this->billing['lastName'] = $lastName;

        return $this;
    }

    public function setBillingName($firstName, $lastName=null)
    {
        // Separate into first and last name for storage.
        if(!isset($lastName)) {
            $firstName = preg_split('/\s+/', $firstName);
            $lastName = array_pop($firstName);
            $firstName = implode(' ', $firstName);
        }

        $this->setBillingFirstName($firstName)
             ->setBillingLastName($lastName);

        return $this;
    }

    public function setBillingTelephone($telephone)
    {
        $this->billing['telephone'] = $telephone;

        return $this;
    }

    public function setBillingEmail($email)
    {
        $this->billing['email'] = $email;

        return $this;
    }

    public function getBillingAddress()
    {
        return $this->billing['address'];
    }

    public function setBillingAddress($address)
    {
        $this->billing['address'] = $address;

        return $this;
    }


    public function setPaymentDue($paymentDue)
    {
        $this->payment['due'] = $paymentDue;

        return $this;
    }

    public function setPaymentMethod($paymentMethod)
    {
        $this->payment['method'] = $paymentMethod;

        return $this;
    }

    public function getConsentCommunication()
    {
        return $this->consent['communication'];
    }

    public function setConsentCommunication($consentCommunication)
    {
        $this->consent['communication'] = $consentCommunication;
        return $this;
    }

    public function getConsentTerms()
    {
        return $this->consent['terms'];
    }

    public function setConsentTerms($consentTerms)
    {
        $this->consent['terms'] = $consentTerms;
        return $this;
    }

    public function getConsentIpAddress()
    {
        return $this->consent['terms'];
    }

    public function setConsentIpAddress($consentIpAddress)
    {
        $this->consent['ipAddress'] = $consentIpAddress;
        return $this;
    }

    public function offsetExists($offset)
    {
        return isset(self::$arrayProperties[$offset]) && self::$arrayProperties[$offset];
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
