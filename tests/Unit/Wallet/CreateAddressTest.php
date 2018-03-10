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
use Qodehub\Bitgo\Wallet\CreateAddress;

class CreateAddressTest extends TestCase
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
     * Setup the test environment viriables
     * @return [type] [description]
     */
    public function setup()
    {
        $this->config = new Config($this->token, $this->secure, $this->host);
    }

    /** @test */
    public function the_create_address_method_can_be_called_with_an_entry_static_coin_method()
    {
        /**
         * Set the currency name-space
         * @var CreateAddress
         */
        $instance = Bitgo::{$this->coin}()->wallet($this->walletId)->createAddress();

        $this->assertInstanceOf(CreateAddress::class, $instance);
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
         * Assert that the CreateAddress Instance received the wallet ID
         */
        $this->assertEquals($createAddressInstance->getWalletId(), $this->walletId);

        return $createAddressInstance;
    }

    /**
     * @test
     * @depends the_instace_should_have_a_wallet_id_when_called_from_a_wallet_instance
     */
    public function the_instance_has_a_chain_method_for_setting_the_chain($createAddressInstance)
    {
        $createAddressInstance->chain(10);

        $this->assertEquals($createAddressInstance->getChain(), 10);

        $createAddressInstance->chain(1);

        $this->assertEquals($createAddressInstance->getChain(), 1);

        return $createAddressInstance->chain(2);
    }

    /**
     * @test
     * @depends the_instace_should_have_a_wallet_id_when_called_from_a_wallet_instance
     */
    public function the_instance_can_chain_to_an_allowMigrated_method_and_set_allowMigrated_property($createAddressInstance)
    {
        $createAddressInstance->allowMigrated(true);

        $this->assertEquals($createAddressInstance->getAllowMigrated(), true);

        $createAddressInstance->allowMigrated(false);

        $this->assertEquals($createAddressInstance->getAllowMigrated(), false);

        return $createAddressInstance->allowMigrated(true);
    }

    /**
     * @test
     * @depends the_instace_should_have_a_wallet_id_when_called_from_a_wallet_instance
     */
    public function the_instance_can_chain_to_a_gasPrice_method_and_set_the_gasPrice_property($createAddressInstance)
    {

        $createAddressInstance->gasPrice(10);

        $this->assertEquals($createAddressInstance->getGasPrice(), 10);

        $createAddressInstance->gasPrice(20);

        $this->assertEquals($createAddressInstance->getGasPrice(), 20);

        return $createAddressInstance->gasPrice(30);
    }

    /**
     * @test
     * @depends the_instace_should_have_a_wallet_id_when_called_from_a_wallet_instance
     */
    public function the_instance_can_chain_to_a_label_method_and_set_a_label_property($createAddressInstance)
    {
        $createAddressInstance->label('my new address');

        $this->assertEquals($createAddressInstance->getLabel(), 'my new address');

        $createAddressInstance->label('my old address');

        $this->assertEquals($createAddressInstance->getLabel(), 'my old address');

        return $createAddressInstance->label('my address');
    }

    /** @test */
    public function the_insance_can_be_accessed_statically_and_determine_the_coin_type_based_on_entry()
    {
        $instance = CreateAddress::tltc();

        $this->assertInstanceOf(CreateAddress::class, $instance);

        $this->assertEquals($instance->getCoinType(), 'tltc');
    }
}
