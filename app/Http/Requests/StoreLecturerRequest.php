<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLecturerRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email' . ($this->route('lecturer') ? ',' . $this->route('lecturer')->user_id . ',id' : ''),
            'lecturer_code' => 'required|string|unique:lecturers,lecturer_code' . ($this->route('lecturer') ? ',' . $this->route('lecturer')->id . ',id' : ''),
            'specialization' => 'required|string|max:255',
            'quota' => 'required|integer|min:1|max:20',
            'phone' => 'nullable|string|max:20',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập họ và tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã được sử dụng',
            'lecturer_code.required' => 'Vui lòng nhập mã giảng viên',
            'lecturer_code.unique' => 'Mã giảng viên đã tồn tại',
            'specialization.required' => 'Vui lòng nhập chuyên ngành',
            'quota.required' => 'Vui lòng nhập số lượng tối đa hướng dẫn',
            'quota.integer' => 'Số lượng phải là số nguyên',
            'quota.min' => 'Số lượng tối thiểu là 1',
            'quota.max' => 'Số lượng tối đa là 20',
        ];
    }
}
