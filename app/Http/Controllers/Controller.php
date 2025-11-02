<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="Sistema de Receitas API",
 *     version="1.0.0",
 *     description="API para gerenciamento de receitas culinárias com autenticação e CRUD completo",
 *     @OA\Contact(
 *         email="admin@receitas.com"
 *     )
 * )
 * 
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Servidor da API"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 * 
 * @OA\Tag(
 *     name="Autenticação",
 *     description="Endpoints para autenticação de usuários"
 * )
 * 
 * @OA\Tag(
 *     name="Receitas",
 *     description="Endpoints para gerenciamento de receitas"
 * )
 * 
 * @OA\Tag(
 *     name="Categorias",
 *     description="Endpoints para gerenciamento de categorias"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
