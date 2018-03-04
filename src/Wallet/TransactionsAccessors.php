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
 * TransactionsAccessors Trait
 *
 * This traits holds accessors for the transactions class
 */
trait TransactionsAccessors
{
    /**
     * @return boolean
     */
    public function getSkip()
    {
        return $this->skip;
    }

    /**
     * @param boolean $skip
     *
     * @return self
     */
    public function setSkip($skip)
    {
        $this->skip = $skip;

        return $this;
    }

    /**
     * @return number
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param number $limit
     *
     * @return self
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getCompact()
    {
        return $this->compact;
    }

    /**
     * @param boolean $compact
     *
     * @return self
     */
    public function setCompact($compact)
    {
        $this->compact = $compact;

        return $this;
    }

    /**
     * @return number
     */
    public function getMinHeight()
    {
        return $this->minHeight;
    }

    /**
     * @param number $minHeight
     *
     * @return self
     */
    public function setMinHeight($minHeight)
    {
        $this->minHeight = $minHeight;

        return $this;
    }

    /**
     * @return number
     */
    public function getMaxHeight()
    {
        return $this->maxHeight;
    }

    /**
     * @param number $maxHeight
     *
     * @return self
     */
    public function setMaxHeight($maxHeight)
    {
        $this->maxHeight = $maxHeight;

        return $this;
    }

    /**
     * @return number
     */
    public function getMinConfirms()
    {
        return $this->minConfirms;
    }

    /**
     * @param number $minConfirms
     *
     * @return self
     */
    public function setMinConfirms($minConfirms)
    {
        $this->minConfirms = $minConfirms;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @param mixed $transactionId
     *
     * @return self
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;

        return $this;
    }
}
