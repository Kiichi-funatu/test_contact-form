<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
           "last_name" => ['required', 'string', 'max:255'],
            "first_name" => ['required', 'string', 'max:255'],

            "gender" => ['required', 'integer', 'between:1,3'],

            "email" => ['required', 'email'],

            // 電話番号（3分割・仕様書準拠）
            "front-tel" => ['required', 'regex:/^[0-9]+$/', 'max:5'],
            "middle-tel" => ['required', 'regex:/^[0-9]+$/', 'max:5'],
            "back-tel" => ['required', 'regex:/^[0-9]+$/', 'max:5'],

            "address" => ['required', 'string'],
            
            "building" => ['nullable', 'string'],

            "category_id" => ['required', 'integer', 'between:1,5'],

            "detail" => ['required', 'string', 'max:120'],
        ];


    }

    public function messages()
    {
       return [
            "last_name.required" => "姓を入力してください",
            "first_name.required" => "名を入力してください",

            "gender.required" => "性別を選択してください",

            "email.required" => "メールアドレスを入力してください",
            "email.email" => "メールアドレスはメール形式で入力してください",

            // 電話番号（仕様書準拠）
            "front-tel.required" => "電話番号を入力してください",
            "middle-tel.required" => "電話番号を入力してください",
            "back-tel.required" => "電話番号を入力してください",

            "front-tel.regex" => "電話番号は 半角数字で入力してください",
            "middle-tel.regex" => "電話番号は 半角数字で入力してください",
            "back-tel.regex" => "電話番号は 半角数字で入力してください",

            "front-tel.max" => "電話番号は 5桁まで数字で入力してください",
            "middle-tel.max" => "電話番号は 5桁まで数字で入力してください",
            "back-tel.max" => "電話番号は 5桁まで数字で入力してください",

            "address.required" => "住所を入力してください",

            "category_id.required" => "お問い合わせの種類を選択してください",

            "detail.required" => "お問い合わせ内容を入力してください",
            "detail.max" => "お問い合わせ内容は120文字以内で入力してください",
        ];
    }
}
