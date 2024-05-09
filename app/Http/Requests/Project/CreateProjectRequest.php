<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class CreateProjectRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|integer|between:1,3',
            'timesheets' => 'array',
            'timesheets.*.task_name' => 'string|max:255|required_if:timesheets,array',
            'timesheets.*.date' => 'date_format:Y-m-d|required_if:timesheets,array',
            'timesheets.*.hours' => 'decimal:0,2|min:0|required_if:timesheets,array',
            'timesheets.*.user_id' => 'exists:users,id|required_if:timesheets,array',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'timesheets.*.task_name.required' => 'The task name in timesheet must be a string.',
            'timesheets.*.task_name.max' => 'The task name in timesheet must be maximun of 255 characters',
            'timesheets.*.date.date_format' => 'The date in timesheet must be in the format YYYY-MM-DD.',
            'timesheets.*.hours.decimal' => 'The hours in timesheet must be with 0 or 2 decimal.',
            'timesheets.*.user_id.exists' => 'The user_id in timesheet must be valid.',
        ];
    }
}
