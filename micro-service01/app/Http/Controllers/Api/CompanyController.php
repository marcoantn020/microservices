<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CreateCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Jobs\CompanyCreatedJob;
use App\Service\CompanyService;
use App\Service\EvaluationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CompanyController extends Controller
{
    public function __construct(
        private EvaluationService $evaluationService,
        private CompanyService $companyService
    ){}

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $companies = $this->companyService->getCompanies(filter: $request->filter ?? "");
        return CompanyResource::collection($companies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateCompanyRequest $request
     * @return CompanyResource
     */
    public function store(CreateCompanyRequest $request): CompanyResource
    {
        $company = $this->companyService->create($request->validated());

        CompanyCreatedJob::dispatch($company->email)
            ->onQueue('queue_email');

        return new CompanyResource($company);
    }

    /**
     * Display the specified resource.
     *
     * @param string $identify
     * @return CompanyResource
     */
    public function show(string $identify)
    {
        $company = $this->companyService->show($identify);
        $evaluation = $this->evaluationService->getEvaluationCompanyByIdentify($identify);
        return (new CompanyResource($company))
            ->additional(['evaluation' => json_decode($evaluation)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCompanyRequest $request
     * @param string $identify
     * @return JsonResponse
     */
    public function update(UpdateCompanyRequest $request, string $identify): JsonResponse
    {
        $this->companyService->update($identify, $request->validated());
        return response()->json(['message' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $identify
     * @return JsonResponse
     */
    public function destroy(string $identify)
    {
        $this->companyService->destroy($identify);
        return response()->json(null, 204);
    }
}
