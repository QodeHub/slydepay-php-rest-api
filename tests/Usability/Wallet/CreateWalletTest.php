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

class CreateWalletTest extends TestCase
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
     * The Human-readable wallet name
     * used in this test.
     *
     * @var string
     */
    protected $label = 'A-random-label';
    /**
     * Passphrase to decrypt the wallet’s
     * private key used in this test.
     *
     * @var string
     */
    protected $passphrase = 'SecureWalletPassword$%#';

    /**
     * Values of other optional parameters
     * used in this test.
     */
    protected $userKey = 'random-user-key';
    protected $backupXpub = 'backupXpub';
    protected $backupXpubProvider = 'backupXpubProvider';
    protected $enterprise = 'Enterprise Name';
    protected $disableTransactionNotifications = true;
    protected $gasPrice = 1000;
    protected $passcodeEncryptionCode = 'AnotherSecurePassword$%#';

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
         * This expression uses the create
         * method from the wallet
         * instance.
         */
        $instance1 =

        Bitgo::{$this->coin}($this->config)
            ->wallet()->create()
            ->label($this->label)
            ->passphrase($this->passphrase)
        /**
         * Even more optional parameters.
         * ==============================
         *
         * I percieve that this will be rarely used
         * so I have left them as conventional
         * accessors using set and get
         */
            ->setUserKey($this->userKey)
            ->setBackupXpub($this->backupXpub)
            ->setBackupXpubProvider($this->backupXpubProvider)
            ->setEnterprise($this->enterprise)
            ->setDisableTransactionNotifications($this->disableTransactionNotifications)
            ->setGasPrice($this->gasPrice)
            ->setPasscodeEncryptionCode($this->passcodeEncryptionCode)
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
            ->wallet()->createWallet()
            ->label($this->label)
            ->passphrase($this->passphrase)
        // ==============================
            ->setUserKey($this->userKey)
            ->setBackupXpub($this->backupXpub)
            ->setBackupXpubProvider($this->backupXpubProvider)
            ->setEnterprise($this->enterprise)
            ->setDisableTransactionNotifications($this->disableTransactionNotifications)
            ->setGasPrice($this->gasPrice)
            ->setPasscodeEncryptionCode($this->passcodeEncryptionCode)
        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkCreateWalletInstanceValues($instance2);

        /**
         * This expression uses the createWallet
         * method from the magic coinType method.
         */
        $instance3 =

        Bitgo::{$this->coin}($this->config)
            ->createWallet()
            ->label($this->label)
            ->passphrase($this->passphrase)
        // ==============================
            ->setUserKey($this->userKey)
            ->setBackupXpub($this->backupXpub)
            ->setBackupXpubProvider($this->backupXpubProvider)
            ->setEnterprise($this->enterprise)
            ->setDisableTransactionNotifications($this->disableTransactionNotifications)
            ->setGasPrice($this->gasPrice)
            ->setPasscodeEncryptionCode($this->passcodeEncryptionCode)
        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkCreateWalletInstanceValues($instance3);
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
            ->wallet()->create([

            'label' => $this->label,
            'passphrase' => $this->passphrase,

            /**
             * Even more optional parameters.
             * ==============================
             *
             * I percieve that this will be rarely used
             * so I have left them as conventional
             * accessors using set and get
             */
            'userKey' => $this->userKey,
            'gasPrice' => $this->gasPrice,
            'backupXpub' => $this->backupXpub,
            'enterprise' => $this->enterprise,
            'backupXpubProvider' => $this->backupXpubProvider,
            'passcodeEncryptionCode' => $this->passcodeEncryptionCode,
            'disableTransactionNotifications' => $this->disableTransactionNotifications,
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
            ->wallet()->createWallet([

            'label' => $this->label,
            'passphrase' => $this->passphrase,
            // ==============================
            'userKey' => $this->userKey,
            'gasPrice' => $this->gasPrice,
            'backupXpub' => $this->backupXpub,
            'enterprise' => $this->enterprise,
            'backupXpubProvider' => $this->backupXpubProvider,
            'passcodeEncryptionCode' => $this->passcodeEncryptionCode,
            'disableTransactionNotifications' => $this->disableTransactionNotifications,

            ])
        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkCreateWalletInstanceValues($instance2);

        $this->checkCreateWalletInstanceValues($instance1);

        /**
         * This expression uses the createWallet
         * method from the magic coinType method.
         */
        $instance3 =

        Bitgo::{$this->coin}($this->config)
            ->wallet()->createWallet([

            'label' => $this->label,
            'passphrase' => $this->passphrase,
            // ==============================
            'userKey' => $this->userKey,
            'gasPrice' => $this->gasPrice,
            'backupXpub' => $this->backupXpub,
            'enterprise' => $this->enterprise,
            'backupXpubProvider' => $this->backupXpubProvider,
            'passcodeEncryptionCode' => $this->passcodeEncryptionCode,
            'disableTransactionNotifications' => $this->disableTransactionNotifications,

            ])
        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkCreateWalletInstanceValues($instance3);
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
            $this->label,
            $instance->getLabel(),
            'The label should match ' . $this->label . ' for this test'
        );

        $this->assertEquals(
            $this->passphrase,
            $instance->getPassphrase(),
            'The passphrase should match ' . $this->passphrase . ' for this test'
        );

        $this->assertEquals(
            $this->userKey,
            $instance->getUserKey(),
            'userKey is Optional but should match ' . $this->userKey . ' for this test'
        );

        $this->assertEquals(
            $this->gasPrice,
            $instance->getGasPrice(),
            'gasPrice is Optional but should match ' . $this->gasPrice . ' for this test'
        );

        $this->assertEquals(
            $this->backupXpub,
            $instance->getBackupXpub(),
            'backupXpub is Optional but should match ' . $this->backupXpub . ' for this test'
        );

        $this->assertEquals(
            $this->enterprise,
            $instance->getEnterprise(),
            'enterprise is Optional but should match ' . $this->enterprise . ' for this test'
        );

        $this->assertEquals(
            $this->backupXpubProvider,
            $instance->getBackupXpubProvider(),
            'backupXpubProvider is Optional but should match ' . $this->backupXpubProvider . ' for this test'
        );

        $this->assertEquals(
            $this->passcodeEncryptionCode,
            $instance->getPasscodeEncryptionCode(),
            'passcodeEncryptionCode is Optional but should match ' . $this->passcodeEncryptionCode . ' for this test'
        );

        $this->assertEquals(
            $this->disableTransactionNotifications,
            $instance->getDisableTransactionNotifications(),
            'disableTransactionNotifications is Optional but ' . $this->disableTransactionNotifications . ' for this test'
        );
    }
}
