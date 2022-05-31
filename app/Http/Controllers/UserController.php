<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;
use App\Http\Requests;
use App\Services;

class UserController extends Controller
{
    private $user;
    private $userStorageDbService;

    public function __construct(Models\User $user, $userStorageDbService = new Services\UserStorageDbService)
    {
        $this->user = $user;
        $this->userStorageDbService = $userStorageDbService;
    }

    /**
     * @OA\Get(
     * path="/api/user/all",
     * operationId="All",
     * tags={"Todos os Usuários"},
     * summary="User All",
     * description="Retorna todos os usuários",
     *      @OA\Response(
     *          response=201,
     *          description="Success",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function all()
    {
        try {
            $listModel = $this->userStorageDbService->getAll();
            return response()->json($listModel, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @OA\Get(
     * path="/api/user/{id}",
     * operationId="GetById",
     * tags={"Usuário por Id"},
     * summary="User Id",
     * description="Retorna o usuário pelo identificador (id)",
     *   @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="number"
     *      )
     *   ),
     *      @OA\Response(
     *          response=201,
     *          description="Success",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getById($id)
    {
        try {
            if (!$id) throw new \Exception("Identificador do usuário não enviado");

            $model = $this->userStorageDbService->getById($id);
            return response()->json($model, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @OA\Get(
     * path="/api/user/{id}/profile",
     * operationId="Profile",
     * tags={"Perfil do Usuário por Id"},
     * summary="Profile User Id",
     * description="Retorna o perfil pelo identificador (id) do usuário",
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="number"
     *      )
     *   ),
     *      @OA\Response(
     *          response=201,
     *          description="Success",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function profile($id)
    {
        try {
            if (!$id) throw new \Exception("Identificador do usuário não enviado");

            $model = $this->userStorageDbService->profile($id);

            return response()->json($model, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @OA\Post(
     * path="/api/user/create",
     * operationId="Create",
     * tags={"Criar um Usuário"},
     * summary="Create User",
     * description="Cria um usuário",
     *  @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="user_name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *      @OA\Response(
     *          response=201,
     *          description="Success",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function create(Requests\UserCreateRequest $request)
    {
        try {
            $json = $request->all();
            $user = $this->user->fill($json);
            $model = $this->userStorageDbService->insert($user);

            return response()->json([
                'success' => 'Usuário cadastrado com sucesso',
                'user' => $model
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @OA\Put(
     * path="/api/user/{id}/update",
     * operationId="Update",
     * tags={"Atualizar um Usuário"},
     * summary="Update User",
     * description="Atualiza um usuário pelo identificador (id)",
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="number"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="user_name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *      @OA\Response(
     *          response=201,
     *          description="Success",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function update($id, Requests\UserUpdateRequest $request)
    {
        try {
            if (!$id) throw new \Exception("Identificador do usuário não enviado");

            if (!$this->userStorageDbService->exist($id))
                throw new \Exception("Este usuário não existe");

            $json = $request->all();
            $user = $this->user->fill($json);
            $model = $this->userStorageDbService->update($id, $user);

            return response()->json([
                'success' => 'Usuário atualizado com sucesso',
                'user' => $model
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @OA\Delete(
     * path="/api/user/{id}/delete",
     * operationId="Destroy",
     * tags={"Deletar um Usuário"},
     * summary="Delete User",
     * description="Deleta um usuário pelo identificador (id)",
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="number"
     *      )
     *   ),
     *      @OA\Response(
     *          response=201,
     *          description="Success",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy($id)
    {
        try {
            if (!$id) throw new \Exception("Identificador do usuário não enviado");

            if (!$this->userStorageDbService->exist($id))
                throw new \Exception("Este usuário não existe");

            $listModel = $this->userStorageDbService->delete($id);

            return response()->json([
                'success' => 'Usuário removido com sucesso',
                'users' => $listModel
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
