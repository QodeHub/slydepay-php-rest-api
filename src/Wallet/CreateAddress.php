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
use Qodehub\Bitgo\Utility\CanCleanParameters;
use Qodehub\Bitgo\Utility\MassAssignable;
use Qodehub\Bitgo\Wallet\ExecutionInterface;
use Qodehub\Bitgo\Wallet\ExecutionTrait;

/**
 * CreateAddress Class
 *
 * This class is responsible for creating addresses
 * on a wallet.
 *
 * @example Wallet::createAddress()
 */
class CreateAddress extends Api implements ExecutionInterface
{
    use ExecutionTrait;
    use MassAssignable;
    use CanCleanParameters;

    /**
     * {@inheritdoc}
     */
    protected $parametersRequired = [
        'chain',
        'walletId',
    ];

    /**
     * {@inheritdoc}
     */
    protected $parametersOptional = [

    ];

    /**
     * 0, 1, 10 or 11 (10 or 11 for SegWit)
     *
     * @var number
     */
    protected $chain = 0;

    /**
     * @return number
     */
    public function getChain()
    {
        return $this->chain;
    }

    /**
     * @param number $chain
     *
     * @return self
     */
    public function setChain($chain)
    {
        $this->chain = $chain;

        return $this;
    }

    /**
     * Set the chain type
     *
     * @param  number $chain (0, 1, 10 or 11 (10 or 11 for SegWit))
     * @return self
     */
    public function chain($chain)
    {
        return $this->setChain($chain);
    }

    /**
     * This will call the api and create the wallet after all parameters
     * have been set.
     *
     * @return Response  A the response from the bitgo server
     */
    public function run()
    {
        $this->propertiesPassRequired();

        return $this->_post('/wallet/' . $this->getWalletId() . '/address/' . $this->getChain());
    }
}
