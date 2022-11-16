<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Str;   
use Illuminate\Validation\ValidationException;       

class UpdatePostRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        if ($this->slug === null)
            $slug = Str::slug($this->title) ;
        else {
            $slug = Str::slug($this->slug) ;
        }
        $this->merge([ 'slug' => $slug ]);
    }
    function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
            $response = new Response($validator->errors(), 422);
            throw new ValidationException($validator, $response);
        }
    }
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
        return[
            'titulo' => 'required|min:5|max:500',
            'slug' => 'max:500|unique:posts,slug,'.$this->route("post")->id,
            'contenido' => 'required|min:5',
            'categoria_id' => 'required',
            'image' => 'mimes:jpeg,jpg,png|max:102400'
        ];
    }
}
