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
 * SendCoinsAccessors Trait
 *
 * This traits holds accessors for the SendCoins class
 */
trait SendCoinsAccessors
{

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     *
     * @return self
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return integer
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param integer $amount
     *
     * @return self
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string
     */
    public function getWalletPassphrase()
    {
        return $this->walletPassphrase;
    }

    /**
     * @param string $walletPassphrase
     *
     * @return self
     */
    public function setWalletPassphrase($walletPassphrase)
    {
        $this->walletPassphrase = $walletPassphrase;

        return $this;
    }

    /**
     * @return integer
     */
    public function getFee()
    {
        return $this->fee;
    }

    /**
     * @param integer $fee
     *
     * @return self
     */
    public function setFee($fee)
    {
        $this->fee = $fee;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return self
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return integer
     */
    public function getFeeRate()
    {
        return $this->feeRate;
    }

    /**
     * @param integer $feeRate
     *
     * @return self
     */
    public function setFeeRate($feeRate)
    {
        $this->feeRate = $feeRate;

        return $this;
    }

    /**
     * @return number
     */
    public function getFeeTxConfirmTarget()
    {
        return $this->feeTxConfirmTarget;
    }

    /**
     * @param number $feeTxConfirmTarget
     *
     * @return self
     */
    public function setFeeTxConfirmTarget($feeTxConfirmTarget)
    {
        $this->feeTxConfirmTarget = $feeTxConfirmTarget;

        return $this;
    }

    /**
     * @return integer
     */
    public function getMaxFeeRate()
    {
        return $this->maxFeeRate;
    }

    /**
     * @param integer $maxFeeRate
     *
     * @return self
     */
    public function setMaxFeeRate($maxFeeRate)
    {
        $this->maxFeeRate = $maxFeeRate;

        return $this;
    }

    /**
     * @return integer
     */
    public function getMinUnspentSize()
    {
        return $this->minUnspentSize;
    }

    /**
     * @param integer $minUnspentSize
     *
     * @return self
     */
    public function setMinUnspentSize($minUnspentSize)
    {
        $this->minUnspentSize = $minUnspentSize;

        return $this;
    }

    /**
     * @return integer
     */
    public function getMinConfirms()
    {
        return $this->minConfirms;
    }

    /**
     * @param integer $minConfirms
     *
     * @return self
     */
    public function setMinConfirms($minConfirms)
    {
        $this->minConfirms = $minConfirms;

        return $this;
    }

    /**
     * @return boolean
     * @SuppressWarnings(PHPMD.LongVariable)
     */
    public function isEnforceMinConfirmsForChange()
    {
        return $this->enforceMinConfirmsForChange;
    }

    /**
     * @param boolean $enforceMinConfirmsForChange
     *
     * @return self
     * @SuppressWarnings(PHPMD.LongVariable)
     */
    public function setEnforceMinConfirmsForChange($enforceMinConfirmsForChange)
    {
        $this->enforceMinConfirmsForChange = $enforceMinConfirmsForChange;

        return $this;
    }

    /**
     * @return string
     */
    public function getSequenceId()
    {
        return $this->sequenceId;
    }

    /**
     * @param string $sequenceId
     *
     * @return self
     */
    public function setSequenceId($sequenceId)
    {
        $this->sequenceId = $sequenceId;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isInstant()
    {
        return $this->instant;
    }

    /**
     * @param boolean $instant
     *
     * @return self
     */
    public function setInstant($instant)
    {
        $this->instant = $instant;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isForceChangeAtEnd()
    {
        return $this->forceChangeAtEnd;
    }

    /**
     * @param boolean $forceChangeAtEnd
     *
     * @return self
     */
    public function setForceChangeAtEnd($forceChangeAtEnd)
    {
        $this->forceChangeAtEnd = $forceChangeAtEnd;

        return $this;
    }

    /**
     * @return string
     */
    public function getChangeAddress()
    {
        return $this->changeAddress;
    }

    /**
     * @param string $changeAddress
     *
     * @return self
     */
    public function setChangeAddress($changeAddress)
    {
        $this->changeAddress = $changeAddress;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isNoSplitChange()
    {
        return $this->noSplitChange;
    }

    /**
     * @param boolean $noSplitChange
     *
     * @return self
     */
    public function setNoSplitChange($noSplitChange)
    {
        $this->noSplitChange = $noSplitChange;

        return $this;
    }

    /**
     * @return integer
     */
    public function getTargetWalletUnspents()
    {
        return $this->targetWalletUnspents;
    }

    /**
     * @param integer $targetWalletUnspents
     *
     * @return self
     */
    public function setTargetWalletUnspents($targetWalletUnspents)
    {
        $this->targetWalletUnspents = $targetWalletUnspents;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isValidate()
    {
        return $this->validate;
    }

    /**
     * @param boolean $validate
     *
     * @return self
     */
    public function setValidate($validate)
    {
        $this->validate = $validate;

        return $this;
    }

    /**
     * @return string
     */
    public function getFeeSingleKeySourceAddress()
    {
        return $this->feeSingleKeySourceAddress;
    }

    /**
     * @param string $feeSingleKeySourceAddress
     *
     * @return self
     * @SuppressWarnings(PHPMD.LongVariable)
     */
    public function setFeeSingleKeySourceAddress($feeSingleKeySourceAddress)
    {
        $this->feeSingleKeySourceAddress = $feeSingleKeySourceAddress;

        return $this;
    }

    /**
     * @return string
     */
    public function getFeeSingleKeyWIF()
    {
        return $this->feeSingleKeyWIF;
    }

    /**
     * @param string $feeSingleKeyWIF
     *
     * @return self
     */
    public function setFeeSingleKeyWIF($feeSingleKeyWIF)
    {
        $this->feeSingleKeyWIF = $feeSingleKeyWIF;

        return $this;
    }

    /**
     * @return string
     */
    public function getOtp()
    {
        return $this->otp;
    }

    /**
     * @param string $otp
     *
     * @return self
     */
    public function setOtp($otp)
    {
        $this->otp = $otp;

        return $this;
    }
}
