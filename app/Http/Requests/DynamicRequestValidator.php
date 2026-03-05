<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class DynamicRequestValidator extends FormRequest
{
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

        switch ($routeName) {
            // Ruta: POST /login/{tipo} -> name('login.submit')
            case 'login.submit':
                return [
                    'email' => 'required|string|email|max:255',
                    'password' => 'required|string|min:8',
                ];
            break;

            // Ruta: POST /registro -> name('register.submit')
            case 'register.submit':
                return [
                    'nombre' => 'required|string|max:255',
                    'apellidos' => 'required|string|max:255',
                    'dni' => 'required|string|max:9|unique:clientes,dni',
                    'email' => 'required|string|email|max:255|unique:clientes,email',
                    'telefono' => 'required|string|max:9',
                    'password' => 'required|string|min:8',
                ];
            break;

            // Ruta: PUT /cliente/editar -> name('cliente.update')
            case 'cliente.update':
                $clienteId = session('user_id');
                return [
                    'email' => 'required|string|email|max:255|unique:clientes,email,' . $clienteId,
                    'telefono' => 'required|string|max:9',
                ];
            break;

            default:
                return [];
        }
    }

    /**
     * @return array
     * @author Alonso Coronado Alcalde
     * @description Define los mensajes de error para cada regla de validación.
     */
    public function messages(): array {
        return [
            //Login
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Introduce un correo electrónico válido.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            
            //Registro
            'nombre.required' => 'El nombre es obligatorio.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'dni.required' => 'El DNI es obligatorio.',
            'dni.unique' => 'El DNI ya está registrado.',
            'telefono.required' => 'El teléfono es obligatorio.',
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