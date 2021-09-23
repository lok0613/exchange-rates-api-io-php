<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Lok0613\ExchangeRatesApiIo;
use Lok0613\ExchangeRatesApiIo\Currency;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

final class ExchangeRatesApiIoTest extends TestCase
{
    /**
     * @dataProvider latestRateDataProvider
     */
    public function testLatestRates($json)
    {
        $url = "http://api.exchangeratesapi.io/v1/latest?base=EUR&access_key=fake-token";
        $response = new Response(200, ['Content-Type' => 'application/json'], $json);

        $http_client = $this->mockHttpClient($url, $response);

        $exchange_rates_api_io = new ExchangeRatesApiIo('fake-token', false, $http_client);

        $rates = $exchange_rates_api_io->latestRates(new Currency('EUR'))->getRates();

        $this->assertEquals('AED', $rates[0]->getCurrency()->getName());
        $this->assertEquals(4.306296, $rates[0]->getRate());
    }

    /**
     * @dataProvider historicalRateDataProvider
     */
    public function testHistoricalRates($json)
    {
        $url = "http://api.exchangeratesapi.io/v1/2021-05-06?base=EUR&access_key=fake-token";
        $response = new Response(200, ['Content-Type' => 'application/json'], $json);

        $http_client = $this->mockHttpClient($url, $response);

        $exchange_rates_api_io = new ExchangeRatesApiIo('fake-token', false, $http_client);

        $rates = $exchange_rates_api_io->historicalRates(new Currency('EUR'), new \DateTime('2021-05-06'))->getRates();

        $this->assertEquals('AED', $rates[0]->getCurrency()->getName());
        $this->assertEquals(4.431895, $rates[0]->getRate());
    }

    public function latestRateDataProvider()
    {
        $json = file_get_contents("./tests/fixtures/LatestRates.json");
        return [[$json]];
    }

    public function historicalRateDataProvider()
    {
        $json = file_get_contents("./tests/fixtures/HistoricalRates.json");
        return [[$json]];
    }

    protected function mockHttpClient($url, $response)
    {
        $http_client = $this->createMock(Client::class, []);
        $http_client->expects($this->once())
            ->method("request")
            ->with('GET', $url)
            ->will($this->returnValue($response));

        return $http_client;
    }
}
