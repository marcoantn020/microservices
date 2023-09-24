<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $uuid = $this->company;
        return [
            'name' => "nullable|string|min:3|max:150|unique:companies,name,{$uuid},uuid",
            'phone' => "nullable|string|unique:companies,phone,{$uuid},uuid",
            'whatsapp' => "nullable|string|unique:companies,whatsapp,{$uuid},uuid",
            'email' => "nullable|email|unique:companies,email,{$uuid},uuid",
            'facebook' => "nullable|string|unique:companies,facebook,{$uuid},uuid",
            'instagram' => "nullable|string|unique:companies,instagram,{$uuid},uuid",
            'youtube' => "nullable|string|unique:companies,youtube,{$uuid},uuid",
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
        ];
    }
}
