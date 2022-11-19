<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StatusUpdatePostRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $pending = config('app.const.status.pending');
        $approved = config('app.const.status.approved');
        $reject = config('app.const.status.reject');
        return [
            'post_id' => 'required|exists:posts,id',
            'status' => ['required', Rule::in([$pending, $approved, $reject])],
        ];
    }
}
