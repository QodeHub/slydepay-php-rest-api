# Create Wallet

## Code Snipet
```php

    $response = 
        Bitgo::tbtc($config)
            ->wallet()->create()
            ->label($label)
            ->passphrase($passphrase)
            ->run();
```