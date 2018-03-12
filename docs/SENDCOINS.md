# Send Coins

## Code Snipet
```php

    $response = 
        Bitgo::tbtc($config)
            ->wallet($walletId)
            ->send($amount)
            ->to($address)
            ->passphrase($passphrase)

            ->comment($comment) //Optional
            ->run();
```