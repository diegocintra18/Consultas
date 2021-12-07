<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeUpdateSettings extends FormRequest
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
       
        $rules = [
            'schedule_day_start' => 'required',
            'schedule_lunch_start' => 'required|gte:schedule_day_start',
            'schedule_lunch_end' => 'required|gte:schedule_lunch_start',
            'schedule_day_end' => 'required|gte:schedule_lunch_end',
            'schedule_duration_limit' => 'required|gt:5',
        ];

        return $rules;
    }
}
