<?php

namespace SpeckOrder\Entity;

use DateTime;
use SpeckOrder\Entity\ItemCollectionInterface;
use SpeckAddress\Entity\AddressInterface;

interface OrderInterface extends ItemCollectionInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return String
     */
    public function getRefNum();

    /**
     * @param string $refNum
     * @return $this
     */
    public function setRefNum($refNum);

    /**
     * @return String
     */
    public function getStatus();

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus($status);

    /**
     * @param string $flag
     * @return bool
     */
    public function hasFlag($flag);

    /**
     * @param string $flag
     * @return $this
     */
    public function setFlag($flag);

    /**
     * @param string $flag
     * @return $this
     */
    public function unsetFlag($flag);

    /**
     * @return array
     */
    public function getFlags();

    /**
     * @param \string[] $flags
     * @return $this
     */
    public function setFlags($flags);

    /**
     * @return DateTime
     */
    public function getCreated();

    /**
     * @param DateTime $created
     * @return $this
     */
    public function setCreated(DateTime $created);

    /**
     * @return $this
     */
    public function setCreatedNow();

    /**
     * @return AddressInterface
     */
    public function getBillingAddress();

    /**
     * @param AddressInterface $address
     * @return $this
     */
    public function setBillingAddress(AddressInterface $address);

    /**
     * @return AddressInterface
     */
    public function getShippingAddress();

    /**
     * @param AddressInterface $address
     * @return $this
     */
    public function setShippingAddress(AddressInterface $address);

    /**
     * @return int
     */
    public function getQuoteId();

    /**
     * @param $id
     * @return $this
     */
    public function setQuoteId($id);

    /**
     * @return int
     */
    public function getCustomerId();

    /**
     * @param $id
     * @return $this
     */
    public function setCustomerId($id);

    /**
     * @return String
     */
    public function getCurrencyCode();

    /**
     * @param $code
     * @return $this
     */
    public function setCurrencyCode($code);

    /**
     * @return OrderMetaInterface
     */
    public function getMeta();

    /**
     * @param OrderMetaInterface $meta
     * @return $this
     */
    public function setMeta(OrderMetaInterface $meta);

    /**
     * @param bool $includeTax
     * @param bool $recursive
     * @return float
     */
    public function getTotal($includeTax = true, $recursive = true);

    /**
     * @param bool $recursive
     * @return float
     */
    public function getTaxTotal($recursive = true);
}
