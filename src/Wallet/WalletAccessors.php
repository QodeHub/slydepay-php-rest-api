<?php

/**
 * @package     Qodehub\Bitgo
 * @link        https://github.com/qodehub/bitgo-php
 *
 * @author      Ariama O. Victor (ovac4u) <victorariama@qodehub.com>
 * @link        http://www.ovac4u.com
 *
 * @license     https://github.com/qodehub/bitgo-php/blob/master/LICENSE
 * @copyright   (c) 2018, QodeHub, Ltd
 */

namespace Qodehub\Bitgo\Wallet;

/**
 * WalletAccessor Trait
 *
 * This traits holds the accessors for a wallet model
 */
trait WalletAccessors
{

    /**
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->admin;
    }

    /**
     * @param boolean $admin
     *
     * @return self
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param boolean $isActive
     *
     * @return self
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     *
     * @return self
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return array
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @param array $permissions
     *
     * @return self
     */
    public function setPermissions(array $permissions)
    {
        $this->permissions = $permissions;

        return $this;
    }

    /**
     * @return array
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * @param array $private
     *
     * @return self
     */
    public function setPrivate(array $private)
    {
        $this->private = $private;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isSpendingAccount()
    {
        return $this->spendingAccount;
    }

    /**
     * @param boolean $spendingAccount
     *
     * @return self
     */
    public function setSpendingAccount($spendingAccount)
    {
        $this->spendingAccount = $spendingAccount;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return self
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return self
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isApprovalsRequired()
    {
        return $this->approvalsRequired;
    }

    /**
     * @param boolean $approvalsRequired
     *
     * @return self
     */
    public function setApprovalsRequired($approvalsRequired)
    {
        $this->approvalsRequired = $approvalsRequired;

        return $this;
    }

    /**
     * @return float
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param float $balance
     *
     * @return self
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * @return float
     */
    public function getConfirmedBalance()
    {
        return $this->confirmedBalance;
    }

    /**
     * @param float $confirmedBalance
     *
     * @return self
     */
    public function setConfirmedBalance($confirmedBalance)
    {
        $this->confirmedBalance = $confirmedBalance;

        return $this;
    }

    /**
     * @return float
     */
    public function getSpendableBalance()
    {
        return $this->spendableBalance;
    }

    /**
     * @param float $spendableBalance
     *
     * @return self
     */
    public function setSpendableBalance($spendableBalance)
    {
        $this->spendableBalance = $spendableBalance;

        return $this;
    }

    /**
     * Set the wallet iD
     * {@inheritdoc}
     */
    public function wallet($walletId)
    {
        $this->setId($walletId);
    }
}
