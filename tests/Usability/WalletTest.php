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

namespace Qodehub\Bitgo\Tests\Usability;

use PHPUnit\Framework\TestCase;
use Qodehub\Bitgo\Bitgo;
use Qodehub\Bitgo\Config;
use Qodehub\Bitgo\Wallet;

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
     * Optional Parameters for getting a list of wallet
     */
    protected $allTokens = true;
    protected $prevId = 'a-valid-prev-id';
    protected $limit = 10;

    /**
     * Setup the test environment viriables
     * @return [type] [description]
     */
    public function setup()
    {
        $this->config = new Config($this->token, $this->secure, $this->host);
    }

    /** @test */
    public function it_can_get_a_list_of_wallet_expressively()
    {
        $instance =

        Bitgo::{$this->coin}($this->config)
            ->wallet()
            ->prevId($this->prevId) //Optional
            ->allTokens($this->allTokens) //Optional
            ->limit($this->limit) //Optional

        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkGetWalletListInstanceValues($instance);
    }

    /** @test */
    public function getting_a_single_wallet_expressively()
    {

        $instance1 =

        Bitgo::{$this->coin}($this->config)
            ->wallet($this->walletId)
        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkGetSingleWalletInstanceValues($instance1);

        /**
         * The class also exposes a find helper method
         */
        $instance2 =

        Bitgo::{$this->coin}($this->config)
            ->wallet()
            ->find($this->walletId)
        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkGetSingleWalletInstanceValues($instance2);
    }

    /** @test */
    public function get_a_list_of_wallet_using_massAssignment()
    {
        $instance =

        Bitgo::{$this->coin}($this->config)
            ->wallet([
                'prevId' => $this->prevId, //Optional
                'allTokens' => $this->allTokens, //Optional
                'limit' => $this->limit, //Optional
            ])
        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkGetWalletListInstanceValues($instance);
    }

    /** @test */
    public function getting_a_single_wallet_using_massassignment()
    {
        $instance =

        Bitgo::{$this->coin}($this->config)
            ->wallet([
                'walletId' => $this->walletId, // Required
            ])
        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkGetSingleWalletInstanceValues($instance);
    }

    protected function checkGetWalletListInstanceValues($instance)
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

        $this->assertNull(
            $instance->getWalletId(),
            'The wallet must be null to get list of wallet'
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

        $this->assertEquals(
            $this->limit,
            $instance->getLimit(),
            'limit is Optional but should match ' . $this->limit . ' for this test'
        );
    }

    protected function checkGetSingleWalletInstanceValues($instance)
    {

        $this->assertEquals(
            $this->config,
            $instance->getConfig(),
            'It should match the config that was passed into the static currency.'
        );

        $this->assertSame(
            $instance->getCoinType(),
            $this->coin,
            'It must have a coin type'
        );

        $this->assertSame(
            $instance->getWalletId(),
            $this->walletId,
            'The walletId must have the valid wallet Id'
        );
    }
}
