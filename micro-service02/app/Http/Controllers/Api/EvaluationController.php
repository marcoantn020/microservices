<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEvaluationRequest;
use App\Http\Requests\updateEvaluationRequest;
use App\Http\Resources\EvaluationResource;
use App\Jobs\EvaluationCreatedJob;
use App\Models\Evaluation;
use App\Service\CompanyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EvaluationController extends Controller
{
    public function __construct(
        protected Evaluation $evaluation,
        protected CompanyService $companyService,
    ){}

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(string $company)
    {
        $companies = $this->evaluation
            ->where('company', '=', $company)
            ->paginate();
        return EvaluationResource::collection($companies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateEvaluationRequest $request
     * @return JsonResponse|EvaluationResource
     */
    public function store(CreateEvaluationRequest $request)
    {
        $data = $request->validated();
        $company = $this->companyService->getCompany($data['company']);
        if(!$company) {
            return response()
                ->json(
                    ['message' => 'company not found'],
                    $company->status()
                );
        }
        $email = $company->data->email;
        $evaluations = $this->evaluation->create($data);
        EvaluationCreatedJob::dispatch($email)
            ->onQueue('queue_email');
        return new EvaluationResource($evaluations);
    }
}
