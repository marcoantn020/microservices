<?php

namespace App\Service;



use Marcoantn020\MicroservicesCommon\Services\Traits\ConsumeServiceExternalTrait;

class EvaluationService
{
    use ConsumeServiceExternalTrait;
    protected mixed $url;
    protected mixed $token;
    public function __construct()
    {
        $this->url = config('services.micro_02.MICRO_02_URL');
        $this->token = config('services.micro_02.MICRO_02_TOKEN');
    }

    public function getEvaluationCompanyByIdentify(string $identify)
    {
        $response = $this->request('get', "/evaluations/{$identify}");
        return $response->body();
    }


}
