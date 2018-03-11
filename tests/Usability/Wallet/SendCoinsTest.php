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

class SendCoinsTest extends TestCase
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
     * Passphrase to decrypt the wallet’s
     * private key used in this test.
     *
     * @var string
     */
    protected $passphrase = 'SecureWalletPassword$%#';

    /**
     * This is the amount used in this test.
     *
     * @var string
     */
    protected $amount = 1.742;

    /**
     * A comment for this transaction
     *
     * @var string
     */
    protected $comment = 'Some comment for this transaction';
    /**
     * Values of other optional parameters
     * used in this test.
     */
    protected $prv = 'some-private-key';
    protected $numBlocks = 100000;
    protected $feeRate = 10;
    protected $minConfirms = 3;
    protected $enforceMinConfirmsForChange = true;
    protected $targetWalletUnspents = true;
    protected $noSplitChange = true;
    protected $minValue = 200;
    protected $maxValue = 3000;
    protected $gasPrice = 10;
    protected $gasLimit = 80;
    protected $sequenceId = 5;
    protected $segwit = 1000;
    protected $lastLedgerSequence = 1;
    protected $ledgerSequenceDelta = 2;

    /**
     * Setup the test environment viriables
     * @return [type] [description]
     */
    public function setup()
    {
        $this->config = new Config($this->token, $this->secure, $this->host);
    }

    /** @test */
    public function it_can_send_coins_expressively()
    {
        /**
         * This expression uses the send
         * method from the wallet instance
         */
        $instance1 =

        Bitgo::{$this->coin}($this->config)
            ->wallet($this->walletId)
            ->send($this->amount)
            ->to($this->address)
            ->passphrase($this->passphrase)

            ->comment($this->comment) //Optional
        /**
         * Even more optional parameters.
         * ==============================
         *
         * I percieve that this will be rarely used
         * so I have left them as conventional
         * accessors using set and get
         */
            ->setPrv($this->prv)
            ->setSegwit($this->segwit)
            ->setFeeRate($this->feeRate)
            ->setMinValue($this->minValue)
            ->setMaxValue($this->maxValue)
            ->setGasPrice($this->gasPrice)
            ->setGasLimit($this->gasLimit)
            ->setNumBlocks($this->numBlocks)
            ->setSequenceId($this->sequenceId)
            ->setMinConfirms($this->minConfirms)
            ->setNoSplitChange($this->noSplitChange)
            ->setLastLedgerSequence($this->lastLedgerSequence)
            ->setLedgerSequenceDelta($this->ledgerSequenceDelta)
            ->setTargetWalletUnspents($this->targetWalletUnspents)
            ->setEnforceMinConfirmsForChange($this->enforceMinConfirmsForChange)
        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkSendCoinsInstanceValues($instance1);

        /**
         * This expression uses the sendCoins
         * method from the wallet instance
         */
        $instance2 =

        Bitgo::{$this->coin}($this->config)
            ->wallet($this->walletId)
            ->sendCoins($this->amount)
            ->to($this->address)
            ->passphrase($this->passphrase)

            ->comment($this->comment) //Optional
        /**
         * Even more optional parameters.
         * ==============================
         *
         * I percieve that this will be rarely used
         * so I have left them as conventional
         * accessors using set and get
         */
            ->setPrv($this->prv)
            ->setSegwit($this->segwit)
            ->setFeeRate($this->feeRate)
            ->setMinValue($this->minValue)
            ->setMaxValue($this->maxValue)
            ->setGasPrice($this->gasPrice)
            ->setGasLimit($this->gasLimit)
            ->setNumBlocks($this->numBlocks)
            ->setSequenceId($this->sequenceId)
            ->setMinConfirms($this->minConfirms)
            ->setNoSplitChange($this->noSplitChange)
            ->setLastLedgerSequence($this->lastLedgerSequence)
            ->setLedgerSequenceDelta($this->ledgerSequenceDelta)
            ->setTargetWalletUnspents($this->targetWalletUnspents)
            ->setEnforceMinConfirmsForChange($this->enforceMinConfirmsForChange)
        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkSendCoinsInstanceValues($instance2);

        /**
         * This expression uses the send and places the
         * amount on the amount helper method.
         */
        $instance3 =

        Bitgo::{$this->coin}($this->config)
            ->wallet($this->walletId)
            ->send()
            ->amount($this->amount)
            ->receiver($this->address)
            ->passphrase($this->passphrase)

            ->comment($this->comment) //Optional
        /**
         * Even more optional parameters.
         * ==============================
         *
         * I percieve that this will be rarely used
         * so I have left them as conventional
         * accessors using set and get
         */
            ->setPrv($this->prv)
            ->setSegwit($this->segwit)
            ->setFeeRate($this->feeRate)
            ->setMinValue($this->minValue)
            ->setMaxValue($this->maxValue)
            ->setGasPrice($this->gasPrice)
            ->setGasLimit($this->gasLimit)
            ->setNumBlocks($this->numBlocks)
            ->setSequenceId($this->sequenceId)
            ->setMinConfirms($this->minConfirms)
            ->setNoSplitChange($this->noSplitChange)
            ->setLastLedgerSequence($this->lastLedgerSequence)
            ->setLedgerSequenceDelta($this->ledgerSequenceDelta)
            ->setTargetWalletUnspents($this->targetWalletUnspents)
            ->setEnforceMinConfirmsForChange($this->enforceMinConfirmsForChange)
        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkSendCoinsInstanceValues($instance3);

        /**
         * This expression uses the sendCoins and places the
         * amount on and uses the address method
         * to set the receiving address.
         */
        $instance4 =

        Bitgo::{$this->coin}($this->config)
            ->wallet($this->walletId)
            ->sendCoins()
            ->amount($this->amount)
            ->address($this->address)
            ->passphrase($this->passphrase)

            ->comment($this->comment) //Optional
        /**
         * Even more optional parameters.
         * ==============================
         *
         * I percieve that this will be rarely used
         * so I have left them as conventional
         * accessors using set and get
         */
            ->setPrv($this->prv)
            ->setSegwit($this->segwit)
            ->setFeeRate($this->feeRate)
            ->setMinValue($this->minValue)
            ->setMaxValue($this->maxValue)
            ->setGasPrice($this->gasPrice)
            ->setGasLimit($this->gasLimit)
            ->setNumBlocks($this->numBlocks)
            ->setSequenceId($this->sequenceId)
            ->setMinConfirms($this->minConfirms)
            ->setNoSplitChange($this->noSplitChange)
            ->setLastLedgerSequence($this->lastLedgerSequence)
            ->setLedgerSequenceDelta($this->ledgerSequenceDelta)
            ->setTargetWalletUnspents($this->targetWalletUnspents)
            ->setEnforceMinConfirmsForChange($this->enforceMinConfirmsForChange)
        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkSendCoinsInstanceValues($instance4);
    }

    /** @test */
    public function it_can_send_coins_using_massassignment()
    {
        /**
         * This expression uses the create
         * method from the wallet
         * instance.
         */
        $instance1 =

        Bitgo::{$this->coin}($this->config)
            ->wallet($this->walletId)->send([

            'amount' => $this->amount,
            'address' => $this->address,
            'comment' => $this->comment,
            'minConfirms' => $this->minConfirms,
            'walletPassphrase' => $this->passphrase,

            /**
             * Even more optional parameters.
             * ==============================
             *
             * I percieve that this will be rarely used
             * so I have left them as conventional
             * accessors using set and get
             */
            'prv' => $this->prv,
            'segwit' => $this->segwit,
            'feeRate' => $this->feeRate,
            'minValue' => $this->minValue,
            'maxValue' => $this->maxValue,
            'gasPrice' => $this->gasPrice,
            'gasLimit' => $this->gasLimit,
            'numBlocks' => $this->numBlocks,
            'sequenceId' => $this->sequenceId,
            'noSplitChange' => $this->noSplitChange,
            'targetWalletUnspents' => $this->targetWalletUnspents,
            'lastLedgerSequence' => $this->lastLedgerSequence,
            'ledgerSequenceDelta' => $this->ledgerSequenceDelta,
            'enforceMinConfirmsForChange' => $this->enforceMinConfirmsForChange,

            ])
        // ->run()  will execute the call to the server.
        // ->get()  can be used instead of ->run()
        ;

        $this->checkSendCoinsInstanceValues($instance1);
    }

    protected function checkSendCoinsInstanceValues($instance)
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
            $this->amount,
            $instance->getAmount(),
            'The amount should match ' . $this->amount . ' for this test'
        );

        $this->assertEquals(
            $this->prv,
            $instance->getPrv(),
            'The prv should match ' . $this->prv . ' for this test'
        );

        $this->assertEquals(
            $this->walletId,
            $instance->getWalletId(),
            'The walletId should match ' . $this->walletId . ' for this test'
        );

        $this->assertEquals(
            $this->passphrase,
            $instance->getWalletPassPhrase(),
            'The walletPassphrase should match ' . $this->passphrase . ' for this test'
        );

        $this->assertEquals(
            $this->address,
            $instance->getAddress(),
            'The address should match ' . $this->address . ' for this test'
        );

        // Testing Optional Parameters.

        $this->assertEquals(
            $this->numBlocks,
            $instance->getNumBlocks(),
            'numBlocks is Optional but should match ' . $this->numBlocks . ' for this test'
        );

        $this->assertEquals(
            $this->feeRate,
            $instance->getFeeRate(),
            'feeRate is Optional but should match ' . $this->feeRate . ' for this test'
        );

        $this->assertEquals(
            $this->comment,
            $instance->getComment(),
            'comment is Optional but should match ' . $this->comment . ' for this test'
        );

        $this->assertEquals(
            $this->segwit,
            $instance->getSegwit(),
            'segwit is Optional but should match ' . $this->segwit . ' for this test'
        );

        $this->assertEquals(
            $this->minValue,
            $instance->getMinValue(),
            'minValue is Optional but should match ' . $this->minValue . ' for this test'
        );

        $this->assertEquals(
            $this->maxValue,
            $instance->getMaxValue(),
            'maxValue is Optional but should match ' . $this->maxValue . ' for this test'
        );

        $this->assertEquals(
            $this->gasPrice,
            $instance->getGasPrice(),
            'gasPrice is Optional but should match ' . $this->gasPrice . ' for this test'
        );

        $this->assertEquals(
            $this->gasLimit,
            $instance->getGasLimit(),
            'gasLimit is Optional but should match ' . $this->gasLimit . ' for this test'
        );

        $this->assertEquals(
            $this->gasLimit,
            $instance->getGasLimit(),
            'gasLimit is Optional but should match ' . $this->gasLimit . ' for this test'
        );

        $this->assertEquals(
            $this->sequenceId,
            $instance->getSequenceId(),
            'sequenceId is Optional but should match ' . $this->sequenceId . ' for this test'
        );

        $this->assertEquals(
            $this->minConfirms,
            $instance->getMinConfirms(),
            'minConfirms is Optional but should match ' . $this->minConfirms . ' for this test'
        );

        $this->assertEquals(
            $this->noSplitChange,
            $instance->getNoSplitChange(),
            'noSplitChange is Optional but should match ' . $this->noSplitChange . ' for this test'
        );

        $this->assertEquals(
            $this->lastLedgerSequence,
            $instance->getlastLedgerSequence(),
            'lastLedgerSequence is Optional but should match ' . $this->lastLedgerSequence . ' for this test'
        );

        $this->assertEquals(
            $this->ledgerSequenceDelta,
            $instance->getLedgerSequenceDelta(),
            'ledgerSequenceDelta is Optional but should match ' . $this->ledgerSequenceDelta . ' for this test'
        );

        $this->assertEquals(
            $this->targetWalletUnspents,
            $instance->getTargetWalletUnspents(),
            'targetWalletUnspents is Optional but should match ' . $this->targetWalletUnspents . ' for this test'
        );

        $this->assertEquals(
            $this->enforceMinConfirmsForChange,
            $instance->getEnforceMinConfirmsForChange(),
            'enforceMinConfirmsForChange is Optional but should match ' . $this->enforceMinConfirmsForChange . ' for this test'
        );
    }
}
