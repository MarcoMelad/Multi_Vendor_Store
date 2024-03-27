<?php

namespace App\Http\Requests;

use App\Rules\NameFilter;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:255|unique:categories,name',
            'parent_id' => 'nullable|int|exists:categories,id',
            'image' => 'max:1048576',
            'status' => 'required|in:active,archived',
            new NameFilter(['laravel', 'html', 'php']),
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The Filed :attribute Is Required',
            'name.unique' => 'The :attribute Is already Exists'
        ];
    }
}
