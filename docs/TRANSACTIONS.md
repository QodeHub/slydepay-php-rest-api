# Wallet Transactions

## Code Snipet
### Get List of transactions
```php

    $response = 
        Bitgo::tbtc($config)
            ->wallet($walletId)
            ->transactions()
            ->get();
```

### Get single transaction
```php

    $response = 
        Bitgo::tbtc($config)
            ->wallet($walletId)
            ->transactions($transactionId)
            ->get();
```