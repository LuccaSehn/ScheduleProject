<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchedulesRequest extends FormRequest
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
        switch($this->method())
        {
            case 'PUT':
                return [
                    'observation' => ['required', 'max:225'],
                    'schedule_date' => ['required', 'date_format:Y-m-d']
                ];
                break;
            case 'PATCH':
            case 'POST':
                return [
                    'clients_id' => ['required', 'exists:clients,id'],
                    'commercial_room_id' => ['required', 'exists:commercial_room,id'],
                    'observation' => ['required', 'max:225'],
                    'schedule_date' => ['required', 'date_format:Y-m-d']
                ];
                break;
            default:
                return [];
                break;
        }
    }
}
