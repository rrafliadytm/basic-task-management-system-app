<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Ambil 'task' yang sedang diakses dari parameter route
        $task = $this->route('task');

        // Izinkan aksi ini jika user yang sedang login
        // bisa (can) melakukan 'update' pada task tersebut (sesuai TaskPolicy).
        return $task && $this->user()->can('update', $task);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'sometimes' allows the field to be optional, meaning it can be present or absent in the request.
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'deadline' => 'sometimes|nullable|date',
            'status' => ['sometimes', 'required', Rule::in(['pending', 'in-progress', 'completed'])],
            'category_id' => 'sometimes|required|exists:categories,id',
            'priority_id' => 'sometimes|required|exists:priorities,id',
        ];
    }
}
