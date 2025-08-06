<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RespondComment extends FormRequest
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
    public function rules()
    {
        return [
            'message' => 'required|string|max:1000',
            'upload' => 'nullable|file|mimes:pdf|max:2048',
            'comment_id' => 'required|uuid|exists:comments,id',
            // 'status' => 'nullable|in:open,in_progress,closed,resolved',
        ];
    }

    // Custom method untuk handle upload file
    public function handleUpload()
    {
        if ($this->hasFile('upload')) {
            return $this->file('upload')->store('uploads/responses', 'public');
        }
        return null;
    }

}
