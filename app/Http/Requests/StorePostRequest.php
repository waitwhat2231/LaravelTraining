<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
                /*
        •	title (string)
•	content (text)
•	published_at (datetime, nullable)
•	category_id (foreign key)
•	author_id (foreign key)

        */
        return [
            'title'=>'required|string',
            'content'=>'required|string',
            'category_id'=>'required|exists:categories,id',
            'author_id'=>'required|exists:authors,id'
        ];
    }
}
