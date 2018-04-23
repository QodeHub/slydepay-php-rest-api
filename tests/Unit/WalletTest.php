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
use Qodehub\Bitgo\Wallet\CreateWallet;
use Qodehub\Bitgo\Wallet\SendCoins;
use Qodehub\Bitgo\Wallet\Transactions;
use Qodehub\Bitgo\Wallet\Transfers;

class WalletTest extends TestCase
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
     * Tis the transactionID used in this test.
     * @var string
     */
    protected $transactionId = 'existing-transaction-id';

    /**
     * Setup the test environment viriables
     * @return [type] [description]
     */
    public function setup()
    {
        $this->config = new Config($this->token, $this->secure, $this->host);
    }

    /** @test */
    public function a_wallet_can_set_the_coin_and_create_a_wallet_instance()
    {
        $instance = Wallet::{$this->coin}();

        $this->assertSame($instance->getCoinType(), $this->coin);
    }

    /** @test */
    public function the_addresses_method_should_give_an_addresses_instance()
    {
        $this->assertInstanceOf(Addresses::class, Wallet::{$this->coin}()->addresses());
    }

    /** @test */
    public function the_create_address_method_should_give_a_create_address_instance()
    {
        $this->assertInstanceOf(CreateAddress::class, Wallet::{$this->coin}()->createAddress());
    }

    /** @test */
    public function the_send_coins_method_should_give_a_send_class_instance()
    {
        $this->assertInstanceOf(SendCoins::class, Wallet::{$this->coin}()->SendCoins());
    }

    /** @test */
    public function the_create_wallet_method_returns_a_create_wallet_instance()
    {
        $this->assertInstanceOf(CreateWallet::class, Wallet::{$this->coin}()->CreateWallet());
    }

    /** @test */
    public function the_transactions_method_returns_a_transaction_instance()
    {
        $this->assertInstanceOf(Transactions::class, Wallet::{$this->coin}()->Transactions());
    }

    /** @test */
    public function the_transactions_method_returns_a_transfer_instance()
    {
        $this->assertInstanceOf(Transfers::class, Wallet::{$this->coin}()->Transfers());
    }

    /** @test */
    public function the_create_method_returns_a_wallet_instance()
    {
        $this->assertInstanceOf(CreateWallet::class, Wallet::{$this->coin}()->Create());
    }

    /** @test */
    public function can_set_a_wallet_id_using_the_constructor()
    {
        $instance = new Wallet($this->walletId);

        $this->assertSame($this->walletId, $instance->getWalletId());
    }

    /** @test */
    public function the_find_method_sets_the_walletID_on_the_wallet_instance()
    {
        $instance = new Wallet();

        $instance->find($this->walletId);

        $this->assertSame($this->walletId, $instance->getWalletId());
    }
}
