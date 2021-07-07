<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title'         =>'required',
            'content'       =>'required',
            'category'      =>'required',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:3000',


        ];
    }
    public function messages(){
        return [
          'required'=>'هذا الحقل مطلوب ',
            'content.required'=>'محتوى الخبر مطلوب',
            'image.image'=>'يجب ان يكون الملف صوره',
            'image.max'=>'حجم الملف كبير جدا',


        ];
    }
}
