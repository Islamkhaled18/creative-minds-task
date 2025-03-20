<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username'      => 'required|string|between:3,30|unique:users',
            'mobile_number' => 'required|string|unique:users|regex:/^\+[1-9]\d{1,14}$/',
            'password'      => 'required|string|min:8',
            'latitude'      => 'required|numeric|between:-90,90',
            'longitude'     => 'required|numeric|between:-180,180',
            'location_name' => 'required|string|max:255',
            'profile_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
