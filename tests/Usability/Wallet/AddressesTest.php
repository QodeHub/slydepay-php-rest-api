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

namespace Qodehub\Bitgo\Tests\Usability\Wallet;

use PHPUnit\Framework\TestCase;
use Qodehub\Bitgo\Bitgo;
use Qodehub\Bitgo\Config;
use Qodehub\Bitgo\Wallet;
use Qodehub\Bitgo\Wallet\Addresses;

class AddressesTest extends TestCase
{
    /**
     * The bearer token that will be used by this API
     * @var string
     */
    protected $token = 'existing-token';

    /**
     * This will determine if HTTP(S) will be used
     * @var boolean
     */
    protected $secure = true;

    /**
     * This is the host on which the Bitgo API is running.
     * @var string
     */
    protected $host = 'some-host.com';

    /**
     * The configuration instance.
     * @var Config
     */
    protected $config;

    /**
     * This is the ID of the wallet used in this test
     * @var string
     */
    protected $walletId = 'existing-wallet-id';

    /**
     * This is the coin type used for this test. Can be changed for other coin tests.
     * @var string
     */
    protected $coin = 'tbtc';

    /**
     * This is an address or the ID of the address used in this test
     * @var string
     */
    protected $address = 'existing-address';

    /**
     * Setup the test environment viriables
     * @return [type] [description]
     */
    public function setup()
    {
        $this->config = new Config($this->token, $this->secure, $this->host);
    }

    /** @test */
    public function getting_a_list_of_wallet_address_expressively()
    {
        $instance =

        Bitgo::{$this->coin}($this->config)
            ->wallet($this->walletId)
            ->addresses()
        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkGetTeansactionsListInstanceValues($instance);
    }

    /** @test */
    public function getting_a_single_address_using_massassignment()
    {
        $instance =

        Bitgo::{$this->coin}($this->config)
            ->wallet($this->walletId)
            ->addresses([
                'address' => $this->address, // Required
            ])
        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkGetTeansactionsListInstanceValues($instance);
    }

    /** @test */
    public function getting_a_single_Address_expressively()
    {

        $instance1 =

        Bitgo::{$this->coin}($this->config)
            ->wallet($this->walletId)
            ->addresses($this->address)
        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkGetSingleAddressInstanceValues($instance1);

        /**
         * The class also exposes a find helper method
         */
        $instance2 =

        Bitgo::{$this->coin}($this->config)
            ->wallet($this->walletId)
            ->addresses()
            ->find($this->address)
        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkGetSingleAddressInstanceValues($instance2);
    }

    protected function checkGetTeansactionsListInstanceValues($instance)
    {

        $this->assertSame(
            $instance->getCoinType(),
            $this->coin,
            'Must have a coin type'
        );

        $this->assertSame(
            $instance->getWalletId(),
            $this->walletId,
            'The instance must have the valid wallet Id'
        );

        $this->assertNull(
            $instance->getAddress(),
            'The address must be null to get list of addresses'
        );

        $this->assertEquals(
            $this->config,
            $instance->getConfig(),
            'It should match the config that was passed into the static currency.'
        );
    }

    protected function checkGetSingleAddressInstanceValues($instance)
    {

        $this->assertSame(
            $instance->getCoinType(),
            $this->coin,
            'Must have a coin type'
        );

        $this->assertSame(
            $instance->getWalletId(),
            $this->walletId,
            'The walletId must have the valid wallet Id'
        );

        $this->assertSame(
            $instance->getAddress(),
            $this->address,
            'The address is required for getting a single address'
        );

        $this->assertEquals(
            $this->config,
            $instance->getConfig(),
            'It should match the config that was passed into the static currency.'
        );
    }
}
