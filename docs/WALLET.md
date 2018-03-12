# Wallet

## Code Snipet
### Get wallet
```php

    $response = 
        Bitgo::tbtc($config)
            ->wallet($walletId)
            ->get();
```

### Get wallet balance
```php

    $response = 
        Bitgo::tbtc($config)
            ->wallet($walletId)
            ->get()
            ->balance;
```