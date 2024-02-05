<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
        $rules = [
            'name' => 'required|min:5',
            'description' => 'required',
            'priority' => 'required',
            'due_date' => 'required|date',
            'file_path' => 'nullable|file|mimes:pdf,docx,xlsx'
        ];

        if($this->method() === 'PATCH') {
            $regrasDinamicas = array();

            foreach($rules as $input => $regra) {
                if(array_key_exists($input, $this->request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }
            return $regrasDinamicas;
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório',
            'description.required' => 'O campo descrição é obrigatório',
            'priority.required' => 'O campo prioridade é obrigatório',
            'due_date.required' => 'O campo vencimento é obrigatório',
            'name.min' => 'O nome da tarefa deve ter no mínimo 5 caracteres',
            'due_date.date' => 'O vencimento deve receber data e hora no formato "dd/mm/aaaa hh:mm"',
            'file_path.file' => 'O campo deve receber um arquivo',
            'file_path.mimes' => 'O arquivo deve ser no formato PDF, DOCX ou XLSX'
        ];
    }
}
