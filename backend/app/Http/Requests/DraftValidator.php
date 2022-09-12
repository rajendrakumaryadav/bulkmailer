<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DraftValidator extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'subject' => 'string|max:255',
            'template' => 'string',
            'from' => 'string',
            "reply_to" => 'string',
            'status' => 'integer|in:0,1,2',
        ];
    }
}
