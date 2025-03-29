<?php

declare(strict_types=1);

namespace App\CurrencyExchangeRate;

class ExchangeRateApi implements CurrencyExchangeRateInterface
{
    protected const string BASE_URI = 'https://v6.exchangerate-api.com/v6/%s/pair/%s/%s';
    private string $apiKey;
    private array $cache = [];

    public function __construct()
    {
        $this->apiKey = (string) getenv('EXCHANGE_RATE_API_KEY');
    }

    /**
     * @throws InvalidResponseException
     */
    public function getExchangeRate(string $currencyFrom, string $currencyTo): float
    {
        if (isset($this->cache[$currencyFrom][$currencyTo])) {
            return $this->cache[$currencyFrom][$currencyTo];
        }

        $response = file_get_contents(sprintf(static::BASE_URI, $this->apiKey, $currencyFrom, $currencyTo));

        if ($response === false) {
            throw new InvalidResponseException('Exchange rates API error response');
        }

        try {
            $response = json_decode($response, false, 512, JSON_THROW_ON_ERROR);

            if ($response->result === 'success') {
                $this->cache[$currencyFrom][$currencyTo] = $response->conversion_rate;

                return $response->conversion_rate;
            }
        } catch (\Exception $e) {
            throw new InvalidResponseException('Exchange rates API invalid response', $e->getCode(), $e);
        }

        throw new InvalidResponseException('Exchange rates API invalid response');
    }
}
