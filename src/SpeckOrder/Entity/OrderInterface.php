<?php

namespace SpeckOrder\Entity;

use DateTime;
use SpeckOrder\Entity\ItemCollectionInterface;
use SpeckAddress\Entity\AddressInterface;

interface OrderInterface extends ItemCollectionInterface
{
    public function getId();

    public function setId($id);

    /**
     * Order reference number
     *
     * @return string
     */
    public function getRefNum();

    /**
     *
     * @param string $refNum
     * @return self
     */
    public function setRefNum($refNum);

    /**
     * @todo add UUID support
     */
    //public function getUuid();

    //public function setUuid(Uuid $uuid);

    /**
     *
     * @return string
     */
    public function getStatus();

    /**
     *
     * @param string $status
     * @return self Provides fluent interface
     */
    public function setStatus($status);

    /**
     *
     * @param string $flag
     * @return boolean
     */
    public function hasFlag($flag);

    /**
     *
     * @param string $flag
     * @return self
     */
    public function setFlag($flag);

    /**
     *
     * @param string $flag
     * @return self
     */
    public function unsetFlag($flag);

    /**
     *
     * @return array
     */
    public function getFlags();

    /**
     * Overrides order flags with flags in array
     *
     * @param string[] $flags
     * @return self
     */
    public function setFlags($flags);

    /**
     *
     * @return DateTime
     */
    public function getCreated();

    /**
     *
     * @param DateTime $date
     * @return self
     */
    public function setCreated(DateTime $date);

    public function getBillingAddress();

    public function setBillingAddress(AddressInterface $address);

    public function getShippingAddress();

    public function setShippingAddress(AddressInterface $address);

    public function getQuoteId();

    public function setQuoteId($id);

    public function getCustomerId();

    public function setCustomerId($id);

    public function getCurrencyCode();

    public function setCurrencyCode($code);
}
