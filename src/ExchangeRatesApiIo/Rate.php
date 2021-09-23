<?php

namespace Lok0613\ExchangeRatesApiIo;

class Rate
{
    /**
     * @var Currency
     */
    protected $currency;

    /**
     * @var float
     */
    protected $rate;

    /**
     * Constructor
     * 
     * @param Currency $currency
     * @param float $rate
     */
    public function __construct(Currency $currency, float $rate)
    {
        $this->currency = $currency;
        $this->rate = $rate;
    }

    /**
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * @return float
     */
    public function getRate(): float
    {
        return $this->rate;
    }
}
