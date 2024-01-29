<?php

namespace App\Http\Requests;

use DateTime;
use Illuminate\Foundation\Http\FormRequest;

class RegisterReservationRequest extends FormRequest
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
            'shopId' => 'required|integer',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'numPeople' => 'required|integer|min:1',
        ];
    }

    protected function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $errors = $validator->errors();
            if (!$errors->has('date') and !$errors->has('time')) {
                $dateTime = DateTime::createFromFormat('Y-m-d H:i', $this->input('date') . ' ' . $this->input('time'));
                if ($dateTime < new DateTime('now')) {
                    $validator->errors()->add('date', '予約日時は現在よりも未来の日時を指定してください');
                }
            }
        });
    }
}
