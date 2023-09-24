<?php

namespace App\Service;

use App\Service\Traits\ConsumeExternalServiceTrait;

class CompanyService
{
    use ConsumeExternalServiceTrait;
    protected mixed $token;
    protected mixed $url;
    public function __construct()
    {
        $this->token = config('services.micro_01.MICRO_01_TOKEN');
        $this->url = config('services.micro_01.MICRO_01_URL');
    }

    public function getCompany(string $company)
    {
        $request = $this->request('get', "/companies/{$company}");

        if($request->status() === 404) {
            return null;
        }

        return json_decode($request->body());
    }
}
