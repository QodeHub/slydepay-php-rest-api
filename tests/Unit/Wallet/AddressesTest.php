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

namespace Qodehub\Bitgo\Tests\Unit\WalletTest;

use PHPUnit\Framework\TestCase;
use Qodehub\Bitgo\Bitgo;
use Qodehub\Bitgo\Config;
use Qodehub\Bitgo\Wallet;
use Qodehub\Bitgo\Wallet\Addresses;
use Qodehub\Bitgo\Wallet\CreateAddress;

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
     * This is the ID of the address used in this test
     * @var string
     */
    protected $addressId = 'existing-address';

    /**
     * This is the coin used in this test
     * @var string
     */
    protected $coin = 'tbtc';

    /**
     * Setup the test environment viriables
     * @return [type] [description]
     */
    public function setup()
    {
        $this->config = new Config($this->token, $this->secure, $this->host);
    }

    /** @test */
    public function the_get_address_method_can_be_called_with_an_entry_static_coin_method()
    {
        /**
         * Set the currency name-space
         * @var Addresses
         */
        $instance = Bitgo::tbtc()->wallet($this->walletId)->addresses();

        $this->assertInstanceOf(Addresses::class, $instance);
    }

    /** @test */
    public function the_instace_should_have_a_wallet_id_when_called_from_a_wallet_instance()
    {

        /**
         * Create the wallet instance
         * @var Wallet
         */
        $wallet = new Wallet($this->walletId);

        /**
         * Call the createAddress Magic method on the wallet instance
         */
        $createAddressInstance = $wallet->createAddress();

        /**
         * Assert that the Addresses Instance received the wallet ID
         */
        $this->assertEquals($createAddressInstance->getWalletId(), $this->walletId);

        return $createAddressInstance;
    }

    /** @test */
    public function the_create_method_should_return_a_createAddress_instance()
    {
        $instance = Bitgo::{$this->coin}()->wallet($this->walletId)->addresses()->create();

        $this->assertInstanceOf(CreateAddress::class, $instance);

        $this->assertSame($this->walletId, $instance->getWalletId());

        $this->assertSame($this->coin, $instance->getCoinType());
    }
}
