<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Exists;

class UserController extends Controller
{
    public function index() : JsonResponse
    {


        $users = User::orderBy('id', 'DESC')->get();


        return response()->json([
            'status' => true,
            'users' => $users,
        ],200);
    }

    public function check(Request $request){

        $emailExists = User::where('email', $request->email)->exists();

        return response()->json(['exists' => $emailExists]);
    }

    public function show(User $user) : JsonResponse
    {
        return response()->json([
            'status' => true,
            'users' => $user,
        ],200);
    }

    public function store(UserRequest $request){
        DB::beginTransaction();



        $data = $request->validated();

        //Aqui faço a conversão para padrão americano
        $data['birthday'] = Carbon::parse($request->birthday)->format('Y-m-d');
        try{
            $user = User::create($data);
            DB::commit();

            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => "Usuario cadastrado com sucesso!",
            ],201);

        }catch(Exception $e){
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => "Usuario não cadastrado!",
            ],400);
        }
    }


    public function update(UserRequest $request, User $user) : JsonResponse
    {
        DB::beginTransaction();

        try{

            $user->update([
                'name' => $request->name,
                'email' =>$request->email,
                'password' =>$request->password,
                'birthday'=>$request->birthday,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => "Usuario editado com sucesso!",
            ],200);


        }catch (Exception $e){
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => "Usuario não editado!",
            ],400);
        }

        return response()->json([
            'status' => true,
            'user' => $user,
            'message' => "Usuario editado com sucesso!",
        ],200);
    }

    public function destroy(User $user) : JsonResponse {
        try {
            if ($user->movements()->exists()) {
                return response()->json([
                    'status' => false,
                    'message' => "Usuário não pode ser apagado enquanto estiver associado a movimentações.",
                ], 400);
            }

            $user->delete();

            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => "Usuário apagado com sucesso!",
            ], 200);

        } catch(Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Usuário não apagado!",
            ], 400);
        }
    }


}
