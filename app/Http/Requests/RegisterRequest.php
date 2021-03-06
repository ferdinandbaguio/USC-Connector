<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'registeredIdnumber' =>'required|unique:users,idnumber|numeric',
            'lastName' => 'required|alpha_spaces',
            'firstName' => 'required|alpha_spaces',
            'middleName' => 'nullable',
            'address' => 'required',
            'email' => 'required|email|unique:users,email',
            'contactNo' => 'required|numeric',
            'sex' => 'required',
            'civilStatus' => 'required',
            'birthdate' => 'required',
            'userType' => 'required',
            'password' => 'nullable',
            'userStatus' => 'nullable'
            
        ];
    }
    public function messages(){
        return [
            
            'registeredIdnumber.unique' => 'ID number already exist.',
            'registeredIdnumber.required' => 'ID number is Required.',
            'registeredIdnumber.numeric' => 'ID number must be digit.',
            'lastName.required' => 'Lastname is Required.',
            'lastName.alpha_spaces' => 'Only accepts alphabets.',
            'firstName.required' => 'Firstname is Required.',
            'firstName.alpha_spaces' => 'Only accepts alphabets.',
            'address.required' => 'Address is Required.',
            'email.required' => 'Email is Required.',
            
            'email.email' => 'Please use a valid e-mail.',
            'email.unique' => 'Email already used',
            'contactNo.required' => 'Contact Number is Required.',
            'sex.required' => 'Sex is Required.',
            'civilStatus.required' => 'Civil Status is Required.',
            'birthdate.required' => 'Birthday is Required.',
            'userType.required' => 'Please choose what you are registering for (Student , Teacher or Alumni).',
        ];
    }

}
