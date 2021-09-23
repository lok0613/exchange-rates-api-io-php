<?php

namespace Lok0613\ExchangeRatesApiIo;

class Currency
{
    /**
     * @var string
     */
    protected $name;

    /**
     * Constructor
     * 
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
