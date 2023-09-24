<?php

namespace App\Service;

use App\Models\Company;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CompanyService
{
    public function __construct(protected Company $repository )
    {
    }

    public function getCompanies($filter): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->repository->getCompanies(filter: $filter ?? "");
    }

    public function create($data)
    {
        $data['image'] = $this->uploadFile(file: $data['image']);
        return $this->repository->create($data);
    }

    public function show($identify)
    {
        return $this->repository->where('uuid', '=', $identify)->firstOrFail();
    }

    public function update($identify, $data)
    {
        $company = $this->repository->where('url', '=', $identify)->firstOrFail();
        if(isset($data['image'])) {
            if(Storage::exists($company->image)) {
                Storage::delete($company->image);
            }
            $data['image'] = $this->uploadFile(file: $data['image']);
        }
        $company->update($data);
    }

    public function destroy($identify)
    {
        $company = $this->show($identify);
        $company->delete();
    }

    protected function uploadFile(UploadedFile $file)
    {
        return $file->store('companies');
    }
}
