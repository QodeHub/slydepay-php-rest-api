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
     * @return integer
     */
    public function getLedgerSequenceDelta()
    {
        return $this->ledgerSequenceDelta;
    }

    /**
     * @param integer $ledgerSequenceDelta
     *
     * @return self
     */
    public function setLedgerSequenceDelta($ledgerSequenceDelta)
    {
        $this->ledgerSequenceDelta = $ledgerSequenceDelta;

        return $this;
    }

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
     * @return boolean
     */
    public function getNoSplitChange()
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
     * @return                                  boolean
     */
    public function getEnforceMinConfirmsForChange()
    {
        return $this->enforceMinConfirmsForChange;
    }

    /**
     * @param                                  boolean $enforceMinConfirmsForChange
     *
     * @return self
     */
    public function setEnforceMinConfirmsForChange($enforceMinConfirmsForChange)
    {
        $this->enforceMinConfirmsForChange = $enforceMinConfirmsForChange;

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
     * @return string
     */
    public function getPrv()
    {
        return $this->prv;
    }

    /**
     * @param string $prv
     *
     * @return self
     */
    public function setPrv($prv)
    {
        $this->prv = $prv;

        return $this;
    }

    /**
     * @return integer
     */
    public function getNumblocks()
    {
        return $this->numblocks;
    }

    /**
     * @param integer $numblocks
     *
     * @return self
     */
    public function setNumblocks($numblocks)
    {
        $this->numblocks = $numblocks;

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
     * @return integer
     */
    public function getMinValue()
    {
        return $this->minValue;
    }

    /**
     * @param integer $minValue
     *
     * @return self
     */
    public function setMinValue($minValue)
    {
        $this->minValue = $minValue;

        return $this;
    }

    /**
     * @return integer
     */
    public function getMaxValue()
    {
        return $this->maxValue;
    }

    /**
     * @param integer $maxValue
     *
     * @return self
     */
    public function setMaxValue($maxValue)
    {
        $this->maxValue = $maxValue;

        return $this;
    }

    /**
     * @return integer
     */
    public function getGasLimit()
    {
        return $this->gasLimit;
    }

    /**
     * @param integer $gasLimit
     *
     * @return self
     */
    public function setGasLimit($gasLimit)
    {
        $this->gasLimit = $gasLimit;

        return $this;
    }

    /**
     * @return integer
     */
    public function getGasPrice()
    {
        return $this->gasPrice;
    }

    /**
     * @param integer $gasPrice
     *
     * @return self
     */
    public function setGasPrice($gasPrice)
    {
        $this->gasPrice = $gasPrice;

        return $this;
    }

    /**
     * @return integer
     */
    public function getSequenceId()
    {
        return $this->sequenceId;
    }

    /**
     * @param integer $sequenceId
     *
     * @return self
     */
    public function setSequenceId($sequenceId)
    {
        $this->sequenceId = $sequenceId;

        return $this;
    }

    /**
     * @return integer
     */
    public function getSegwit()
    {
        return $this->segwit;
    }

    /**
     * @param integer $segwit
     *
     * @return self
     */
    public function setSegwit($segwit)
    {
        $this->segwit = $segwit;

        return $this;
    }

    /**
     * @return integer
     */
    public function getLastLedgerSequence()
    {
        return $this->lastLedgerSequence;
    }

    /**
     * @param integer $lastLedgerSequence
     *
     * @return self
     */
    public function setLastLedgerSequence($lastLedgerSequence)
    {
        $this->lastLedgerSequence = $lastLedgerSequence;

        return $this;
    }

    /**
     * @return integer
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param integer $comment
     *
     * @return self
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }
}
