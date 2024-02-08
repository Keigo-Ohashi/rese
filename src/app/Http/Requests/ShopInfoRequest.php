<?php

namespace App\Http\Requests;

use DateTime;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class ShopInfoRequest extends FormRequest
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
            'name' => 'required|max:255',
            'areaId' => 'required',
            'genreId' => 'required',
            'detail' => 'required|max:255',
        ];
    }

    protected function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (is_null($this->file("image"))) {
                $imagePath = $this->input("imagePath");
                if (is_null($imagePath)) {
                    $validator->errors()->add("image", "画像を選択してください");
                } elseif (preg_match('/temp.*/', $imagePath)) {
                    $imagePath = Storage::disk('public')->url($imagePath, now()->addMinute());
                    session()->flash('image', $imagePath);
                }
            } else {
                $image = $this->file('image');
                $imageExtension = $image->getClientOriginalExtension();
                if (in_array($imageExtension, ["jpeg", "jpg", "png"])) {
                    $imagePath =  $image->store('temp', 'public');
                    session()->flash("imagePath", $imagePath);
                    $this->merge(["imagePath" => $imagePath]);
                    $imagePath = Storage::disk('public')->url($imagePath, now()->addMinute());
                    session()->flash('image', $imagePath);
                } else {
                    $validator->errors()->add("image", "jpeg形式またはpng形式の画像を選択してください");
                }
            }
        });
    }
}
