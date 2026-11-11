<?php

namespace App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class PerishableFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'sellerID' => ['required', 'exists:users,id'],
            'name' => ['required','string'],
            'quantity' => ['required', 'integer','min:1'],
            'quantityOriginal' => ['required', 'integer','min:1'],
            'priceOriginal' => ['required','numeric','min:0'],
            'priceCurrent' => ['required','numeric','min:0','lte:priceOriginal'],
            'priceLowerBound' => ['required','numeric','min:0','lte:priceOriginal'],
            'description' => ['nullable', 'string'],
            'type' => ['nullable', 'string'],
            'halal' => ['required','in:0,1'],
            'expiryDate' => ['required', 'date', 'after:now'],
            'status' =>['required','in:0,1'],
            'measurement' => ['nullable', 'string'],
            'imagePath' => ['nullable', 'image', 'max:2048'],

        ];
    } 
    protected function prepareforValidation()
    {

        $this->merge([
        'sellerID' => Auth::id(),
        'name' => strip_tags($this->input('name')),
        'quantity' =>$this->input('quantityOriginal'),
        'quantityOriginal' =>$this->input('quantityOriginal'),
        'priceOriginal' => $this->input('priceOriginal'),
        'priceCurrent' => $this->input('priceOriginal'),
        'priceLowerBound' => $this->input('priceLowerBound'),
        'description' => strip_tags($this->input('description')),
        'type' => strip_tags($this->input('type')),
        'halal' =>$this->input('halal'),
        'expiryDate' =>$this->input('expiryDate'),
        'status' => 1,
        'measurement' => strip_tags($this->input('measurement')),
        'imagePath' => $this->input('imagePath'),
        ]);
    }
}
