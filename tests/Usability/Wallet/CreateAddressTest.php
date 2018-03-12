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
     * Values of other optional parameters
     * used in this test.
     */
    protected $label = 'A-random-label';
    protected $allowMigrated = true;
    protected $chain = 10;
    protected $gasPrice = 1000;

    /**
     * Setup the test environment viriables
     * @return [type] [description]
     */
    public function setup()
    {
        $this->config = new Config($this->token, $this->secure, $this->host);
    }

    /** @test */
    public function it_can_create_a_wallet_expressively()
    {
        /**
         * This expression uses the create method
         * from the walet addresses instance.
         */
        $instance1 =

        Bitgo::{$this->coin}($this->config)
            ->wallet($this->walletId)
            ->addresses()->create()
        // === Optional parameters
            ->label($this->label) //Optional
            ->chain($this->chain) //Optional
            ->gasPrice($this->gasPrice) //Optional
            ->allowMigrated($this->allowMigrated) //Optional
        /**
         * Even more optional parameters.
         * ==============================
         *
         * I percieve that this will be rarely used
         * so I have left them as conventional
         * accessors using set and get
         */
        // ->setUserKey($this->userKey)
        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkCreateWalletInstanceValues($instance1);

        /**
         * This expression uses the createWallet
         * method from the wallet
         * instance.
         */
        $instance2 =

        Bitgo::{$this->coin}($this->config)
            ->wallet($this->walletId)
            ->createAddress()
        // ==============================
            ->label($this->label) //Optional
            ->allowMigrated($this->allowMigrated) //Optional
            ->chain($this->chain) //Optional
            ->gasPrice($this->gasPrice) //Optional
        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkCreateWalletInstanceValues($instance2);
    }

    /** @test */
    public function getting_a_single_address_using_massassignment()
    {
        /**
         * This expression uses the create
         * method from the wallet
         * instance.
         */
        $instance1 =

        Bitgo::{$this->coin}($this->config)
            ->wallet($this->walletId)
            ->addresses()->create([
            // === Optional parameters
            'label' => $this->label,
            'allowMigrated' => $this->allowMigrated,
            'chain' => $this->chain,
            'gasPrice' => $this->gasPrice,
            ])
        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkCreateWalletInstanceValues($instance1);

        /**
         * This expression uses the createWallet
         * method from the wallet
         * instance.
         */
        $instance2 =

        Bitgo::{$this->coin}($this->config)
            ->wallet($this->walletId)
            ->addresses()->createAddress([
            // ==============================
            'label' => $this->label,
            'allowMigrated' => $this->allowMigrated,
            'chain' => $this->chain,
            'gasPrice' => $this->gasPrice,
            ])
        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkCreateWalletInstanceValues($instance2);
    }

    protected function checkCreateWalletInstanceValues($instance)
    {

        $this->assertSame(
            $instance->getCoinType(),
            $this->coin,
            'Must have a coin type'
        );

        $this->assertEquals(
            $this->config,
            $instance->getConfig(),
            'It should match the config that was passed into the static currency.'
        );

        $this->assertEquals(
            $this->walletId,
            $instance->getWalletId(),
            'The walletId should match ' . $this->walletId . ' for this test'
        );

        $this->assertEquals(
            $this->allowMigrated,
            $instance->getAllowMigrated(),
            'allowMigrated is Optional but should match ' . $this->allowMigrated . ' for this test'
        );

        $this->assertEquals(
            $this->chain,
            $instance->getChain(),
            'chain is Optional but should match ' . $this->chain . ' for this test'
        );

        $this->assertEquals(
            $this->gasPrice,
            $instance->getGasPrice(),
            'gasPrice is Optional but should match ' . $this->gasPrice . ' for this test'
        );
    }
}
