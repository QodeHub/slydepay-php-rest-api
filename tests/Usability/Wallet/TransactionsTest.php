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
use Qodehub\Bitgo\Wallet\Transactions;

class TransactionsTest extends TestCase
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
    public function getting_a_list_of_transaction_expressively()
    {
        $instance =

        Bitgo::{$this->coin}($this->config)
            ->wallet($this->walletId)
            ->transactions()
            ->allTokens() // Optional
            ->prevId($this->transactionId) // Optional
        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkGetTeansactionsListInstanceValues($instance);
    }

    /** @test */
    public function getting_a_list_of_transaction_using_massassignment()
    {
        $instance =

        Bitgo::{$this->coin}($this->config)
            ->wallet($this->walletId)
            ->transactions([
                'allTokens' => true, // Optional
                'prevId' => $this->transactionId, // Optional
            ])
        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkGetTeansactionsListInstanceValues($instance);
    }

    /** @test */
    public function getting_a_single_transaction_expressively()
    {

        $instance1 =

        Bitgo::{$this->coin}($this->config)
            ->wallet($this->walletId)
            ->transactions($this->transactionId)
        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkGetSingleTransactionInstanceValues($instance1);

        /**
         * The class also exposes a find helper method
         */
        $instance2 =

        Bitgo::{$this->coin}($this->config)
            ->wallet($this->walletId)
            ->transactions()
            ->find($this->transactionId)
        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkGetSingleTransactionInstanceValues($instance2);
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
            'The walletId must have the valid wallet Id'
        );

        $this->assertNull(
            $instance->getTransactionId(),
            'The transactionId must be null to get list of transactions'
        );

        $this->assertTrue(
            $instance->getAllTokens(),
            'The allTokens should be optional and exactly "True" for this test.'
        );

        $this->assertEquals(
            $this->transactionId,
            $instance->getPrevId(),
            'The prevID should be optional and exactly "' . $this->transactionId . '"" for this test'
        );

        $this->assertEquals(
            $this->config,
            $instance->getConfig(),
            'It should match the config that was passed into the static currency.'
        );
    }

    protected function checkGetSingleTransactionInstanceValues($instance)
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
            $instance->getTransactionId(),
            $this->transactionId,
            'The transactionId is required for getting a single transaction'
        );

        $this->assertEquals(
            $this->config,
            $instance->getConfig(),
            'It should match the config that was passed into the static currency.'
        );
    }
}
