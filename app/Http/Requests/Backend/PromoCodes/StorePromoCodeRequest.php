<?php

namespace App\Http\Requests\Backend\PromoCodes;

use Illuminate\Foundation\Http\FormRequest;

class StorePromoCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('store-promocode');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'promo_code' => 'required|unique:promocodes',
            'count_limit' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'amount' => 'required'

        ];
    }

    public function messages()
    {
        return [
            //The Custom messages would go in here
            //For Example : 'title.required' => 'You need to fill in the title field.'
            //Further, see the documentation : https://laravel.com/docs/6.x/validation#customizing-the-error-messages
        ];
    }
}
