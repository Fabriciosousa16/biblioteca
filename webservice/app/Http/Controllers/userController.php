<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class userController extends Controller
{
    public function index(){

        $user = User::all();
        return response()->json([
            'user'=>$user,
            'message'=>'usuarios',
            'code'=>200
        ]);
    }

    public function store(Request $request) {
        
        $request->validate([
            'nome' => 'required|min:5',
            'cpf' => 'required|size:14|unique:users'
        ]);
    
        $user = new User();
        $user->nome = $request->nome;
        $user->cpf = $request->cpf;
    
        $user->save();
    
        return response()->json(['message' => 'Usuário adicionado com sucesso'], 200);
    }
    
    

    public function edit($id){
        $user = User::find($id);
        return response()->json($user);
    }

    
    public function update($id, Request $request)
    {
        $request->validate([
            'nome' => 'required|min:5',
            'cpf' => "required|size:14|unique:users,cpf,{$id},usuario_id",
        ]);
    
        // Encontre o livro pelo ID
        $user = User::find($id);
    
        info('Request data:', $request->all());
    
        // Verifique se o livro existe
        if (!$user) {
            return response()->json([
                'message' => 'Livro não encontrado',
            ], 404);
        }
    
        // Atualize os campos do livro
        $user->nome = $request->input('nome'); // Use 'nome' em vez de 'nomeUpt'
        $user->cpf = $request->input('cpf'); // Use 'nome' em vez de 'nomeUpt'
    
        $user->update();
        
        return response()->json([
            'message' => 'Usuário atualizado com sucesso',
            'book' => $user, // Obtenha os valores atualizados do livro
        ], 200);
    }
    
    public function destroy($id){
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json([
                'message' => 'Usuário excluído com sucesso',
                'code' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Usuário não localizado',
                'code' => 404
            ]);
        }
    }
}
