<?php

namespace App\Http\Requests\Api\V1\Vote;

use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;

class ChangeStatusRequest extends FormRequest
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
            'status' => 'required|string|in:'. implode(',', Comment::ALL_STATUSES)
        ];
    }
}
