# Create Address

## Code Snipet
```php

    $response = 
        Bitgo::tbtc($config)
            ->wallet()
            ->addresses()
            ->create()
            ->label($label)
            ->run();
```