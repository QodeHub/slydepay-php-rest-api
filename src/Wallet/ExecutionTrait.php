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
 * ExecutionTrait Trait
 *
 * This trait implements the ExecitionInterface
 * methods so that it can easily be copied
 * by classes where it is required since
 * it will be used extensively
 *
 * @see Qodehub\Bitgo\Wallet\ExecutionInterface
 */
trait ExecutionTrait
{
    /**
     * This is the wallet ID for which the address will
     * be created.
     * @var string
     */
    protected $walletId;

    /**
     * This will set the wallet that the address will be created on
     * @param  string $walletId The wallet ID should be passed in here
     * @return Qodehub\Bitgo\Wallet|string           The wallet ID or Instance
     *
     * @see Qodehub\Bitgo\Wallet\ExecutionInterface
     */
    public function wallet($walletId)
    {
        return $this->setWalletId($walletId);
    }

    /**
     * @return string
     */
    public function getWalletId()
    {
        return $this->walletId;
    }

    /**
     * @param string $walletId
     *
     * @return self
     */
    public function setWalletId($walletId)
    {
        $this->walletId = $walletId;

        return $this;
    }
}
