# ExchangeRatesApiIO, PHP API

[![CI](https://github.com/lok0613/exchange-rates-api-io-php/actions/workflows/ci.yml/badge.svg?branch=master)](https://github.com/lok0613/exchange-rates-api-io-php/actions/workflows/ci.yml)

```php
use Lok0613\ExchangeRatesApiIo;
use Lok0613\ExchangeRatesApiIo\Currency;

$exchange_rates_api_io = new ExchangeRatesApiIo('access-token');
$rates = $exchange_rates_api_io->latestRates(new Currency('EUR'))->getRates();
$rates[0]->getCurrency()->getName(); // 'AED'
$rates[0]->getRate(); // 4.306
```

## Installation

The recommended way to install Guzzle is through
[Composer](https://getcomposer.org/).

```bash
composer require lok0613/exchange-rates-api-io
```

## License

Guzzle is made available under the MIT License (MIT). Please see [License File](LICENSE) for more information.
