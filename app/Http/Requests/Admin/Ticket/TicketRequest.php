<?php

namespace App\Http\Requests\Admin\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
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
            'answer' => 'required|max:300|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,؟!،?! ]+$/u',
            'file' => 'nullable|mimes:png,jpg,jpeg,gif,webp,rar,zip,doc,docx',
        ];
    }
}
