<?php

namespace App\Service\Traits;

use Illuminate\Support\Facades\Http;

trait ConsumeExternalServiceTrait
{
    public function request(
        string $method,
        string $endpoint,
        array  $formsParams = [],
        array  $headers = ['test' => '789']
    )
    {
        return $this->headers($headers)
            ->$method($this->url . $endpoint, $formsParams);
    }

    public function headers(array $headers = []): \Illuminate\Http\Client\PendingRequest
    {
        $headers[] = [
            'Accept' => 'application/json',
            'Authorization' => $this->token
        ];
        return Http::withHeaders($headers);
    }
}
