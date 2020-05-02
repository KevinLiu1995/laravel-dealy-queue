<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChouJiangRequest extends FormRequest
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

    public function prepareForValidation()
    {
        $this->offsetSet('current_time', date('Y-m-d H:i:s'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {


        return [
            //
            'email' => 'required|email',
            'time' => 'required|date:Y-m-d H:i:s|after:current_time'
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'email 必须是一个有效的邮箱！',
            'time.after' => '选定的开奖时间必须大于当前时间！！'
        ];
    }
}
