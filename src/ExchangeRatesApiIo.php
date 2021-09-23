<?php

namespace Lok0613;

use Lok0613\ExchangeRatesApiIo\Currency;
use Lok0613\ExchangeRatesApiIo\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Client\ClientInterface;

class ExchangeRatesApiIo
{
    const HTTP_BASE_URL = 'http://api.exchangeratesapi.io/v1/';

    const HTTPS_BASE_URL = 'https://api.exchangeratesapi.io/v1/';

    /**
     * @var ClientInterface
     */
    protected $http_client;

    /**
     * @var string
     */
    protected $base_url;

    /**
     * @var string
     */
    protected $access_key;

    /**
     * Class constructor
     * 
     * @param string $access_key
     * @param bool $ssl_enabled
     * @param ClientInterface $http_client
     */
    public function __construct(string $access_key, bool $ssl_enabled = false, $http_client = null)
    {
        $this->access_key = $access_key;

        if ($ssl_enabled) {
            $this->base_url = self::HTTPS_BASE_URL;
        } else {
            $this->base_url = self::HTTP_BASE_URL;
        }

        if ($http_client == null) {
            $this->http_client = new \GuzzleHttp\Client();
        } else {
            $this->http_client = $http_client;
        }
    }

    /**
     * Get latest rates
     * 
     * @param Currency $base_currency
     * @param [Currency] $symbols
     * 
     * @return Response
     */
    public function latestRates(Currency $base_currency, array $symbols = []): Response
    {
        $params = ['base' => $base_currency->getName()];

        if ($symbols == []) {
            # do nothing
        } else {
            $params['symbols'] = implode($symbols, ",");
        }
        
        return new Response($this->request('latest', $params));
    }

    /**
     * Request API with HTTP client
     * 
     * @param string @endpoint, partial endpoint without $base_url
     * @param array @params, request parameters
     * 
     * @return Psr\Http\Message\ResponseInterface
     */
    protected function request(string $endpoint, array $params): ResponseInterface
    {
        $params['access_key'] = $this->access_key;
        $query_string = http_build_query($params);
        $url = "{$this->base_url}{$endpoint}?{$query_string}";

        return $this->http_client->request('GET', $url);
    }
}
