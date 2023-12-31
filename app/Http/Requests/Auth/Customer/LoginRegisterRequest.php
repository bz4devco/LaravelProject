<?php

namespace App\Http\Requests\Auth\Customer;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class LoginRegisterRequest extends FormRequest
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
        $route = Route::current();
            if($route->getName() == 'auth.customer.login-register'){
            if(request()->mobile){
                return [
                    'mobile' => ['required','regex:/(0|\+98)?([ ]|-|[()]){0,2}9[0|1|2|3|4|9]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/']
                ];
            }
            else if(request()->email){
                return [
                    'email' => ['required','regex:/^\S+@\S+\.\S+$/']
                ];
            }
        }
        elseif($route->getName() == 'auth.customer.login-confirm'){
            return [
                'otp' => 'required|digits:6|numeric'
            ];
        }
    }

    public function attributes()
    {
        return [
            'mobile' => 'شماره موبایل'
        ];
    }
}
