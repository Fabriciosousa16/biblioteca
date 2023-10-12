<?php

namespace App\Http\Controllers;

use App\Rent;
use App\User;
use App\Book;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class rentController extends Controller
{
    public function index(){

        $rent = Rent::with(['users', 'books'])->get();

        return response()->json([
            'rent'=>$rent,
            'message'=>'Alugueis',
            'code'=>200
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'selectedUser' => 'required',
            'selectedBook' => 'required',
            'dt_aluguel_ini' => 'required|date',
            'dt_aluguel_fim' => 'required|date|after:dt_aluguel_ini',
            'dt_aluguel_ini' => 'required|livro_nao_alocado:'.$request->input('selectedBook').','.$request->input('dt_aluguel_ini'),
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

            $rent = new Rent();
            $rent->usuario_id = $request->selectedUser;
            $rent->livro_id = $request->selectedBook;
            $rent->dt_aluguel_ini = $request->dt_aluguel_ini;
            $rent->dt_aluguel_fim = $request->dt_aluguel_fim;
            $rent->save();

            return response()->json([
                'message' => 'Aluguel criado com sucesso',
                'rent' => $rent,
            ], 200);
    }

    public function edit($id){
        $rent = rent::find($id);
        return response()->json([
            'id' => $rent->aluguel_id, 
            'usuario_id' => $rent->usuario_id,
            'livro_id' => $rent->livro_id,
            'dt_aluguel_ini' => $rent->dt_aluguel_ini,
            'dt_aluguel_fim' => $rent->dt_aluguel_fim
        ]);
    }

    public function update($id, Request $request)
    {

        $validator = Validator::make($request->all(), [
            'selectedUser' => 'required',
            'selectedBook' => 'required',
            'dt_aluguel_ini' => 'required|date',
            'dt_aluguel_fim' => 'required|date|after:dt_aluguel_ini',
            'dt_aluguel_ini' => 'required|livro_nao_alocado:'.$request->input('selectedBook').','.$request->input('dt_aluguel_ini'),
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Encontre o Aluguel pelo ID
        $rent = Rent::find($id);

        if (!$rent) {
            return response()->json(['message' => 'Aluguel não encontrado'], 404);
        }

        $rent->usuario_id = $request->input('selectedUser');
        $rent->livro_id = $request->input('selectedBook');
        $rent->dt_aluguel_ini = $request->input('dt_aluguel_ini');
        $rent->dt_aluguel_fim = $request->input('dt_aluguel_fim');

        $rent->save();

        return response()->json(['message' => 'Aluguel atualizado com sucesso'], 200);

    } 

    public function destroy($id){
        $rent = Rent::find($id);
        if ($rent) {
            $rent->delete();
            return response()->json([
                'message' => 'Aluguel excluído com sucesso',
                'code' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Aluguel não localizado',
                'code' => 404
            ]);
        }
    }

    public function exportRentsToTxt()
    {
        $rents = Rent::all(); // Obtém todos os registros de aluguéis
    
        $txtContent = "Informações de Aluguéis:\n\n";
    
        foreach ($rents as $rent) {
            $user = User::find($rent->usuario_id); // Obtém o usuário
            $book = Book::find($rent->livro_id); // Obtém o livro
    
            $txtContent .= "Usuário: {$user->nome}\n";
            $txtContent .= "Livro Alugado: {$book->nome_livro}\n";
            $txtContent .= "Data de Empréstimo: {$rent->data_emprestimo}\n";
            $txtContent .= "Data de Devolução: {$rent->data_devolucao}\n\n";
        }
    
        // Salve o conteúdo no arquivo .txt
        $filePath = public_path('alugueis.txt');
        file_put_contents($filePath, $txtContent);
    
        return response()->download($filePath)->deleteFileAfterSend(true);
    }
    
}