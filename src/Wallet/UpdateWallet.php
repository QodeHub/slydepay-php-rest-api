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

use GuzzleHttp\Psr7\Response;
use Qodehub\Bitgo\Api\Api;
use Qodehub\Bitgo\Coin;
use Qodehub\Bitgo\Utility\CanCleanParameters;
use Qodehub\Bitgo\Utility\MassAssignable;
use Qodehub\Bitgo\Wallet;

/**
 * UpdateWallet Class
 *
 * This class implements methods for Updating a given wallet
 *
 * This class will require that a walletId is present. Examples are attaches
 *
 * @example Bitgo::btc($config)->wallet($walletId)->update(Array)->run();
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class UpdateWallet extends Api
{
    use WalletTrait;
    use MassAssignable;
    use CanCleanParameters;
    use Coin;

    /**
     * {@inheritdoc}
     */
    protected $parametersRequired = [
        'walletId',
    ];

    /**
     * {@inheritdoc}
     */
    protected $parametersOptional = [
        'label',
        'disableTransactionNotifications',
        'approvalsRequired',
        'tokenFlushThresholds',
    ];

    /**
     * A Human-readable name for the wallet
     * @var string
     */
    protected $label;
    /**
     * Will prevent wallet transaction
     * notifications if set to true.
     *
     * @var boolean
     */
    protected $disableTransactionNotifications;
    /**
     * Change number of required approvals
     * @var integer
     */
    protected $approvalsRequired;
    /**
     * Change threshold for erc20 forwarder (only coin teth)
     * @var Object
     */
    protected $tokenFlushThresholds;

    /**
     * Construct for creating a new instance of this class
     *
     * @param array $data An array with assignable Parameters
     */
    public function __construct($data = [])
    {
        return $this->massAssign($data);
    }

    /**
     * Set a human-readable label for the wallet
     * that will be created
     *
     * @param  string $label A human readable label
     * @return self
     */
    public function label($label)
    {
        return $this->setLabel($label);
    }

    /**
     * @return mixed
     */
    public function getParametersRequired()
    {
        return $this->parametersRequired;
    }

    /**
     * @param mixed $parametersRequired
     *
     * @return self
     */
    public function setParametersRequired($parametersRequired)
    {
        $this->parametersRequired = $parametersRequired;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getParametersOptional()
    {
        return $this->parametersOptional;
    }

    /**
     * @param mixed $parametersOptional
     *
     * @return self
     */
    public function setParametersOptional($parametersOptional)
    {
        $this->parametersOptional = $parametersOptional;

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
     * @return boolean
     */
    public function getDisableTransactionNotifications()
    {
        return $this->disableTransactionNotifications;
    }

    /**
     * @param boolean $disableTransactionNotifications
     *
     * @return self
     */
    public function setDisableTransactionNotifications($disableTransactionNotifications)
    {
        $this->disableTransactionNotifications = $disableTransactionNotifications;

        return $this;
    }

    /**
     * @return integer
     */
    public function getApprovalsRequired()
    {
        return $this->approvalsRequired;
    }

    /**
     * @param integer $approvalsRequired
     *
     * @return self
     */
    public function setApprovalsRequired($approvalsRequired)
    {
        $this->approvalsRequired = $approvalsRequired;

        return $this;
    }

    /**
     * @return Object
     */
    public function getTokenFlushThresholds()
    {
        return $this->tokenFlushThresholds;
    }

    /**
     * @param Object $tokenFlushThresholds
     *
     * @return self
     */
    public function setTokenFlushThresholds($tokenFlushThresholds)
    {
        $this->tokenFlushThresholds = $tokenFlushThresholds;

        return $this;
    }

    /**
     * The method places the call to the Bitgo API
     *
     * @return Response
     */
    public function run()
    {
        $this->propertiesPassRequired();

        return $this->_put(
            '/wallet/{walletId}', $this->propertiesToArray()
        );
    }
}
