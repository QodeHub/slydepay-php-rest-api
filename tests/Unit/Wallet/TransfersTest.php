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
use Qodehub\Bitgo\Wallet\Transfers;

class TransfersTest extends TestCase
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
    public function the_create_address_method_can_be_called_with_an_entry_static_coin_method()
    {
        /**
         * Set the currency name-space
         * @var Transfers
         */
        $instance = Bitgo::{$this->coin}()->wallet($this->walletId)->transfers();

        $this->assertInstanceOf(Transfers::class, $instance);
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
         * Call the Transfers Magic method on the wallet instance
         */
        $TransfersInstance = $wallet->transfers();

        /**
         * Assert that the Transfers Instance received the wallet ID
         */
        $this->assertEquals($TransfersInstance->getWalletId(), $this->walletId);

        return $TransfersInstance;
    }

    /**
     * @test
     * @depends the_instace_should_have_a_wallet_id_when_called_from_a_wallet_instance
     */
    public function the_instance_has_a_chain_method_for_setting_the_prevId($TransfersInstance)
    {
        $TransfersInstance->prevId('prev-id-1');

        $this->assertEquals($TransfersInstance->getprevId(), 'prev-id-1');

        $TransfersInstance->prevId('prev-id-2');

        $this->assertEquals($TransfersInstance->getprevId(), 'prev-id-2');

        return $TransfersInstance->prevId('prev-id-3');
    }

    /**
     * @test
     * @depends the_instace_should_have_a_wallet_id_when_called_from_a_wallet_instance
     */
    public function the_instance_can_chain_to_an_allowMigrated_method_and_set_allTokens_property($TransfersInstance)
    {
        $TransfersInstance->allTokens(true);

        $this->assertEquals($TransfersInstance->getallTokens(), true);

        $TransfersInstance->allTokens(false);

        $this->assertEquals($TransfersInstance->getallTokens(), false);

        return $TransfersInstance->allTokens(true);
    }

    /**
     * @test
     * @depends the_instace_should_have_a_wallet_id_when_called_from_a_wallet_instance
     */
    public function the_instance_should_be_able_to_find_a_single_record_with_its_id_in_a_chaind_find_method($TransfersInstance)
    {
        $TransfersInstance->find($this->transactionId);

        $this->assertEquals($TransfersInstance->getTransactionId(), $this->transactionId);

        $TransfersInstance->find('change-the-id');

        $this->assertEquals($TransfersInstance->getTransactionId(), 'change-the-id');

        return $TransfersInstance->find($this->transactionId);
    }

    /** @test */
    public function the_insance_can_be_accessed_statically_and_determine_the_coin_type_based_on_entry()
    {
        $instance = Transfers::{$this->coin}();

        $this->assertInstanceOf(Transfers::class, $instance);

        $this->assertEquals($instance->getCoinType(), $this->coin);
    }
}
