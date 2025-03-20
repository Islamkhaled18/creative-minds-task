<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $userId = $this->route('user')?->id;
        return [
            'username'      => 'required|string|between:3,30|unique:users,username,' . $userId,
            'password'      => 'required|string|min:8',
            'mobile_number' => 'required|string|regex:/^\+\d{12}$/|unique:users,mobile_number,' . $userId,
            'user_type'     => 'required|string|in:delivery,user,admin',
            'location_name' => 'required|string|max:255',
            'is_verified'   => 'required|boolean',
            'latitude'      => 'nullable|numeric|between:-90,90',
            'longitude'     => 'nullable|numeric|between:-180,180',
            'profile_image' => $this->isMethod('post') ? 'required|image|mimes:jpeg,png,jpg|max:2048' : 'nullable|image|mimes:jpeg,png,jpg|max:2048',

        ];

    }
}
