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
     * Optional Parameters for getting a list of transfers
     */
    protected $allTokens = true;
    protected $prevId = 'a-valid-prev-id';

    /**
     * Setup the test environment viriables
     * @return [type] [description]
     */
    public function setup()
    {
        $this->config = new Config($this->token, $this->secure, $this->host);
    }

    /** @test */
    public function it_can_get_a_list_of_transfers_expressively()
    {
        $instance =

        Bitgo::{$this->coin}($this->config)
            ->wallet($this->walletId)
            ->transfers()
            ->prevId($this->prevId) //Optional
            ->allTokens($this->allTokens) //Optional

        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkGetTransactionsListInstanceValues($instance);
    }

    /** @test */
    public function getting_a_single_transaction_expressively()
    {

        $instance1 =

        Bitgo::{$this->coin}($this->config)
            ->wallet($this->walletId)
            ->transfers($this->transactionId)
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
            ->transfers()
            ->find($this->transactionId)
        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkGetSingleTransactionInstanceValues($instance2);
    }

    /** @test */
    public function get_a_list_of_transfers_using_massAssignment()
    {
        $instance =

        Bitgo::{$this->coin}($this->config)
            ->wallet($this->walletId)
            ->transfers([
                'prevId' => $this->prevId, //Optional
                'allTokens' => $this->allTokens, //Optional
            ])
        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkGetTransactionsListInstanceValues($instance);
    }

    /** @test */
    public function getting_a_single_transaction_using_massassignment()
    {
        $instance =

        Bitgo::{$this->coin}($this->config)
            ->wallet($this->walletId)
            ->transfers([
                'transactionId' => $this->transactionId, // Required
            ])
        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkGetSingleTransactionInstanceValues($instance);
    }

    protected function checkGetTransactionsListInstanceValues($instance)
    {

        $this->assertEquals(
            $this->config,
            $instance->getConfig(),
            'It should match the config that was passed into the static currency.'
        );

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
            $instance->getTransactionId(),
            'The transactionId must be null to get list of transfers'
        );

        $this->assertEquals(
            $this->prevId,
            $instance->getPrevId(),
            'prevId is Optional but should match ' . $this->prevId . ' for this test'
        );

        $this->assertEquals(
            $this->allTokens,
            $instance->getAllTokens(),
            'allTokens is Optional but should match ' . $this->allTokens . ' for this test'
        );
    }

    protected function checkGetSingleTransactionInstanceValues($instance)
    {

        $this->assertEquals(
            $this->config,
            $instance->getConfig(),
            'It should match the config that was passed into the static currency.'
        );

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
            $this->transactionId,
            $instance->getTransactionId(),
            'The tractionId is required for getting a single transaction'
        );
    }
}
