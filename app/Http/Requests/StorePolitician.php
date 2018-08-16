<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePolitician extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'short_name' => 'required|max:50',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:255',
            'image' => 'file|image|max:2048|mimes:jpg,jpeg,bmp,png,gif',
            'party_id' => 'required|integer|exists:App\Http\Models\Party,id',
            'role_id' => 'required|integer|exists:App\Http\Models\PoliticianRole,id',
            'is_active' => 'required|boolean',
        ];
    }
}
