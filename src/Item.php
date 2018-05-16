<?php

/**
 * @package     Qodehub\Slydepay
 * @link        https://github.com/qodehub/slydepay-php
 *
 * @author      Ariama O. Victor (ovac4u) <victorariama@qodehub.com>
 * @link        http://www.ovac4u.com
 *
 * @license     https://github.com/qodehub/slydepay-php/blob/master/LICENSE
 * @copyright   (c) 2018, QodeHub, Ltd
 */

namespace Qodehub\Slydepay;

/**
 * Item Class
 *
 * This represents an item in an invoice
 *
 * @example new Item($emailOrMobileNumber, $merchantKey);
 */
class Item
{
    /**
     * Code of the specific item
     * @var string
     */
    protected $itemCode;

    /**
     * Name of the specific item
     * @var  string
     */
    protected $itemName;
    /**
     * Price of the item
     * @var  string
     */
    protected $unitPrice;

    /**
     * quantity of this specific item puchased by the customer
     * @var integer
     */
    protected $quantity;
    /**
     * Subtotal on the item ie quantity times unitPrice
     * @var integer
     */
    protected $subTotal;

    /**
     * @return string
     */
    public function getItemCode()
    {
        return $this->itemCode;
    }

    /**
     * @param string $itemCode
     *
     * @return self
     */
    public function setItemCode($itemCode)
    {
        $this->itemCode = $itemCode;

        return $this;
    }

    /**
     * @return  string
     */
    public function getItemName()
    {
        return $this->itemName;
    }

    /**
     * @param  string $itemName
     *
     * @return self
     */
    public function setItemName($itemName)
    {
        $this->itemName = $itemName;

        return $this;
    }

    /**
     * @return  string
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * @param  string $unitPrice
     *
     * @return self
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    /**
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param integer $quantity
     *
     * @return self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return integer
     */
    public function getSubTotal()
    {
        return $this->subTotal;
    }

    /**
     * @param integer $subTotal
     *
     * @return self
     */
    public function setSubTotal($subTotal)
    {
        $this->subTotal = $subTotal;

        return $this;
    }
}
