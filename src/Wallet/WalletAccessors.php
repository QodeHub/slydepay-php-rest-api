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
 * WalletAccessors Trait
 *
 * This traits holds the accessors for a wallet model
 */
trait WalletAccessors
{
    /**
     * @return integer
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param integer $limit
     *
     * @return self
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return string
     */
    public function getAllTokens()
    {
        return $this->allTokens;
    }

    /**
     * @param string $allTokens
     *
     * @return self
     */
    public function setAllTokens($allTokens)
    {
        $this->allTokens = $allTokens;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrevId()
    {
        return $this->prevId;
    }

    /**
     * @param string $prevId
     *
     * @return self
     */
    public function setPrevId($prevId)
    {
        $this->prevId = $prevId;

        return $this;
    }
}
