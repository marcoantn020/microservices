<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
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
        return [
            'category_id' => "required|integer|exists:categories,id",
            'name' => "required|string|min:3|max:150|unique:companies",
            'phone' => "nullable|string|unique:companies",
            'whatsapp' => "required|string|unique:companies",
            'email' => "required|email|unique:companies",
            'facebook' => "nullable|string|unique:companies",
            'instagram' => "nullable|string|unique:companies",
            'youtube' => "nullable|string|unique:companies",
            'image' => 'required|image|mimes:jpeg,png,jpg|max:1024',
        ];
    }
}
