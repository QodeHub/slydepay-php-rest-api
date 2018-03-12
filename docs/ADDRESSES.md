# Wallet Addresses

## Code Snipet
### Get List of addresses
```php

    $response = 
        Bitgo::tbtc($config)
            ->wallet($walletId)
            ->addresses()
            ->get();
```

### Get single address
```php

    $response = 
        Bitgo::tbtc($config)
            ->wallet($walletId)
            ->addresses($addressOrAddressId)
            ->get();
```