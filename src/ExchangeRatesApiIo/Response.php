<?php

namespace Lok0613\ExchangeRatesApiIo;

use \GuzzleHttp\Psr7\Response as GuzzleResponse;

class Response
{
    public function __construct(GuzzleResponse $response)
    {
        $this->response = $response;

        $this->status_code = $response->getStatusCode();

        $this->raw_body = $response->getBody();
        $this->json = json_decode($this->raw_body, true);

        if ($this->json['success'] == false) {
            $code = $this->json['error']['code'];
            $info = $this->json['error']['info'];

            throw new Exception("{$code}: {$info}");
        }
    }

    public function getRates(): array
    {
        $rates = $this->json['rates'];
        $new_rates = [];

        foreach ($rates as $key => $rate)
        {
            $new_rates[] = new Rate(new Currency($key), $rate);
        }

        return $new_rates;
    }

    public function __toString()
    {
        return $this->raw_body;
    }
}
