<?php
/**
 * FIX
 */
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

namespace Qodehub\Bitgo\Wallet;

use GuzzleHttp\Psr7\Response;
use Qodehub\Bitgo\Api\Api;
use Qodehub\Bitgo\Coin;
use Qodehub\Bitgo\Utility\CanCleanParameters;
use Qodehub\Bitgo\Utility\MassAssignable;
use Qodehub\Bitgo\Wallet;

/**
 * CreateAddress Class
 *
 * This class is responsible for creating addresses
 * on a wallet.
 *
 * @example Wallet::createAddress()
 *
 * Wallet::createWallet()
 * Wallet::create()
 * Wallet::address()->create()
 * Wallet::createAddress()
 * Address::create()->walletId($walletId)->run()
 * Address::create()->wallet($walletId)->run()
 *
 * @SuppressWarnings(PHPMD.ShortVariable)
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class CreateWallet extends Wallet implements WalletInterface
{
    use MassAssignable;
    use CanCleanParameters;
    use Coin;

    /**
     * {@inheritdoc}
     */
    protected $parametersRequired = [
        'label',
        'passphrase',
    ];

    /**
     * {@inheritdoc}
     */
    protected $parametersOptional = [
        'userKey',
        'backupXpub',
        'backupXpubProvider',
        'enterprise',
        'disableTransactionNotifications',
        'gasPrice',
        'passcodeEncryptionCode',
    ];

    /**
     * A Human-readable name for the wallet
     *
     * @var string
     */
    protected $label;
    /**
     * Passphrase to decrypt the wallet’s private key.
     *
     * @var string
     */
    protected $passphrase;
    /**
     * Optional xpub to be used as the user key.
     *
     * @var string
     */
    protected $userKey;
    /**
     * Optional xpub to be used as the backup key.
     *
     * @var string
     */
    protected $backupXpub;
    /**
     * Optional key recovery service to provide
     * and store the backup key.
     *
     * @var string
     */
    protected $backupXpubProvider;
    /**
     * ID of the enterprise to associate
     * this wallet with.
     *
     * @var string
     */
    protected $enterprise;
    /**
     * Will prevent wallet transaction
     * notifications if set to true.
     *
     * @var boolean
     */
    protected $disableTransactionNotifications;
    /**
     * Will prevent wallet transaction
     * notifications if set to true.
     *
     * @var integer
     */
    protected $gasPrice;
    /**
     * Encryption code for wallet passphrase
     * (used for lost passphrase recovery)
     *
     * @var string
     */
    protected $passcodeEncryptionCode;

    /**
     * Construct for creating a new instance of this class
     *
     * @param array $data An array with assignable Parameters
     */
    public function __construct($data = [])
    {
        $this->massAssign($data);
    }

    /**
     * Set a human-readable label for the wallet
     * that will be created
     *
     * @param  string $label A human readable label
     * @return self
     */
    public function label($label)
    {
        return $this->setLabel($label);
    }

    /**
     * Set the security passphrase or otherwise password
     * for the wallet that will be created.
     *
     * @param  string $passphrase A secure password for the wallet.
     * @return self
     */
    public function passphrase($passphrase)
    {
        return $this->setPassphrase($passphrase);
    }

    /**
     * @return mixed
     */
    public function getParametersRequired()
    {
        return $this->parametersRequired;
    }

    /**
     * @param mixed $parametersRequired
     *
     * @return self
     */
    public function setParametersRequired($parametersRequired)
    {
        $this->parametersRequired = $parametersRequired;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getParametersOptional()
    {
        return $this->parametersOptional;
    }

    /**
     * @param mixed $parametersOptional
     *
     * @return self
     */
    public function setParametersOptional($parametersOptional)
    {
        $this->parametersOptional = $parametersOptional;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     *
     * @return self
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassphrase()
    {
        return $this->passphrase;
    }

    /**
     * @param string $passphrase
     *
     * @return self
     */
    public function setPassphrase($passphrase)
    {
        $this->passphrase = $passphrase;

        return $this;
    }

    /**
     * @return string
     */
    public function getUserKey()
    {
        return $this->userKey;
    }

    /**
     * @param string $userKey
     *
     * @return self
     */
    public function setUserKey($userKey)
    {
        $this->userKey = $userKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getBackupXpub()
    {
        return $this->backupXpub;
    }

    /**
     * @param string $backupXpub
     *
     * @return self
     */
    public function setBackupXpub($backupXpub)
    {
        $this->backupXpub = $backupXpub;

        return $this;
    }

    /**
     * @return string
     */
    public function getBackupXpubProvider()
    {
        return $this->backupXpubProvider;
    }

    /**
     * @param string $backupXpubProvider
     *
     * @return self
     */
    public function setBackupXpubProvider($backupXpubProvider)
    {
        $this->backupXpubProvider = $backupXpubProvider;

        return $this;
    }

    /**
     * @return string
     */
    public function getEnterprise()
    {
        return $this->enterprise;
    }

    /**
     * @param string $enterprise
     *
     * @return self
     */
    public function setEnterprise($enterprise)
    {
        $this->enterprise = $enterprise;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isDisableTransactionNotifications()
    {
        return $this->disableTransactionNotifications;
    }

    /**
     * @param boolean $disableTransactionNotifications
     *
     * @return self
     */
    public function setDisableTransactionNotifications($disableTransactionNotifications)
    {
        $this->disableTransactionNotifications = $disableTransactionNotifications;

        return $this;
    }

    /**
     * @return integer
     */
    public function getGasPrice()
    {
        return $this->gasPrice;
    }

    /**
     * @param integer $gasPrice
     *
     * @return self
     */
    public function setGasPrice($gasPrice)
    {
        $this->gasPrice = $gasPrice;

        return $this;
    }

    /**
     * @return string
     */
    public function getPasscodeEncryptionCode()
    {
        return $this->passcodeEncryptionCode;
    }

    /**
     * @param string $passcodeEncryptionCode
     *
     * @return self
     */
    public function setPasscodeEncryptionCode($passcodeEncryptionCode)
    {
        $this->passcodeEncryptionCode = $passcodeEncryptionCode;

        return $this;
    }

    /**
     * This will call the api and create the wallet after all parameters
     * have been set.
     *
     * @return Response  A response from the bitgo server
     */
    public function run()
    {
        $this->propertiesPassRequired();

        return $this->_post('/wallet/generate');
    }
}
