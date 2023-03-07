<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
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
            "title"=>"required|string",
            "deadline"=>"nullable|date",
            "department_id"=>"nullable|exists:departments,id",
            "project_id"=>"required|exists:projects,id",
            "status"=>[Rule::in(["todo","in_progress","done"]),"nullable"]
        ];
    }
}
