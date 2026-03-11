<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class DynamicRequestValidator extends FormRequest {
    /**
     * @return bool
     * @author Alonso Coronado Alcalde
     * @description Determina si la petición está autorizada.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * @return array
     * @author Alonso Coronado Alcalde
     * @description Define las reglas de validación para cada ruta.
     */
    public function rules(): array {
        $routeName = $this->route()->getName(); //Obtiene el nombre de la ruta
        $userId = session('user_id');

        switch ($routeName) {
            //Ruta: POST /login/{tipo} -> name('login.submit')
            case 'login.submit':
                return [
                    'email' => 'required|string|email|max:255',
                    'password' => 'required|string|min:8',
                ];

            case 'register.submit':
                return [
                    'nombre' => 'required|string|max:255',
                    'apellido' => 'required|string|max:255',
                    'dni' => 'required|string|max:9|unique:clientes,dni',
                    'email' => 'required|string|email|max:255|unique:clientes,email',
                    'telefono' => 'required|string|max:9',
                    'password' => 'required|string|min:8',
                ];

            //CLIENTE
            case 'cliente.update':
                return [
                    'email' => 'required|string|email|max:255|unique:clientes,email,' . ($userId ?? 'null'),
                    'telefono' => 'required|string|max:9',
                ];

            case 'cliente.incidencia.store':
                return [
                    'descripcion' => 'required|string|min:10',
                ];

            //MANAGER
            case 'manager.trabajadorSubmit':
                return [
                    'nombre' => 'required|string|max:255',
                    'apellido' => 'required|string|max:255',
                    'dni' => 'required|string|max:9|unique:trabajadores,dni',
                    'email' => 'required|string|email|max:255|unique:trabajadores,email',
                    'telefono' => 'required|string|max:9',
                    'password' => 'required|string|min:8',
                    'rol' => 'required|in:manager,marketing,jefe_tecnico,tecnico',
                ];

            case 'tarifaSubmit':
                return [
                    'nombre' => 'required|string|max:255',
                    'tipo' => 'required|in:internet,movil,tv',
                    'precio' => 'required|numeric|min:0',
                    'descripcion' => 'required|string|max:500',
                    'productos' => 'nullable|array',
                    'productos.*' => 'nullable|exists:productos,id',
                ];

            case 'productoSubmit':
                return [
                    'nombre' => 'required|string|max:255',
                    'cantidad' => 'required|integer|min:0',
                    'precio' => 'required|numeric|min:0',
                ];

            //TECNICO
            case 'tecnico.incidencia.actualizar':
                return [
                    'estado' => 'required|in:pendiente,en_progreso,cerrado',
                ];

            //ACCIONES GENÉRICAS
            case 'manager.cliente.delete':
            case 'marketing.cliente.delete':
                return [
                    'id' => 'required|exists:clientes,id',
                ];

            case 'manager.incidencia.asignar':
                return [
                    'id' => 'required|exists:incidencias,id',
                    'tecnico_id' => 'required|exists:trabajadores,id',
                ];

            default:
                return [];
        }
    }

    /**
     * @return array
     * @author Alonso Coronado Alcalde
     * @description Define los mensajes de error para cada regla de validación de forma global.
     */
    public function messages(): array {
        return [
            //Genéricos
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser una cadena de texto.',
            'max' => 'El campo :attribute no puede tener más de :max caracteres.',
            'min' => 'El campo :attribute debe tener al menos :min caracteres.',
            'email' => 'El campo :attribute debe ser un correo electrónico válido.',
            'unique' => 'El :attribute ya se encuentra registrado.',
            'numeric' => 'El campo :attribute debe ser un valor numérico.',
            'integer' => 'El campo :attribute debe ser un número entero.',
            'exists' => 'El :attribute seleccionado no es válido.',
            'in' => 'El valor seleccionado para :attribute no es válido.',

            //Personalizados
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Introduce un formato de correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya está en uso.',
            
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            
            'dni.required' => 'El DNI es obligatorio.',
            'dni.unique' => 'Este DNI ya está registrado en el sistema.',
            'dni.max' => 'El DNI no puede exceder los 9 caracteres.',
            
            'telefono.required' => 'El número de teléfono es obligatorio.',
            'telefono.max' => 'El teléfono no puede superar los 9 dígitos.',

            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            
            'descripcion.required' => 'Por favor, escribe una descripción.',
            'descripcion.min' => 'La descripción debe tener al menos 10 caracteres para ser útil.',

            'precio.required' => 'El precio es obligatorio.',
            'precio.min' => 'El precio no puede ser negativo.',
            
            'cantidad.required' => 'La cantidad es obligatoria.',
            'cantidad.integer' => 'La cantidad debe ser un número entero.',
            'cantidad.min' => 'La cantidad no puede ser menor a 0.',

            'rol.required' => 'Debes asignar un rol al trabajador.',
            'estado.required' => 'Debes seleccionar un nuevo estado para la incidencia.',
        ];
    }

    /**
     * @param Validator $validator
     * @throws ValidationException
     * @author Alonso Coronado Alcalde
     * @description Redirige de vuelta con los errores.
     */
    protected function failedValidation(Validator $validator) {
        throw new ValidationException($validator);
    }
}