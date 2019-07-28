<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNews extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'content' => 'nullable|max:1000',

            // CATEGORY ID
            // - Can be only of an existing Category
            // - Only categories that are not reserved (e.g: weather forecast and daily summary)
            'category_id' => [
                'required',
                function ($attribute, $value, $fail) {

                    // For safety
                    // If category doesn't exist
                    $category_id = intval($value);

                    $count = \App\Category::where(
                        [
                            ['id', $category_id],
                            ['appears_in_form', 1]
                        ]
                    )->count();

                    if ($count == 0)
                    {
                        $fail($attribute.' does\'t exist');
                    }
                },
            ],
        ];
    }
}
