<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUjianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'mapel_id'      => ['required', 'exists:mapel,id'],
            'guru_id'       => ['required', 'exists:users,id'],
            'judul'         => ['required', 'string', 'max:255'],
            'waktu_mulai'   => ['required', 'date', 'after:now'],
            'waktu_selesai' => ['required', 'date', 'after:waktu_mulai'],
            'status'        => ['required', 'in:draft,published'],
        ];
    }
}
