<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class bookController extends Controller
{
    public function index(){

        $book = Book::all();
        return response()->json([
            'book'=>$book,
            'message'=>'Livros',
            'code'=>200
        ]);
    }

    public function store(Request $request){
        
        $request->validate([
            'nome' => 'required|min:5',
        ]);

        $book = new book();
        $book->nome_livro = $request->nome;
        $book->save();

        return response()->json(([
            'message' => 'Adicionado com Sucesso',
            'code' => 200
        ]));
    }

    public function edit($id){
        $book = book::find($id);
        return response()->json($book);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'nome' => 'required|min:5',
        ]);
    
        // Encontre o livro pelo ID
        $book = Book::find($id);
    
        info('Request data:', $request->all());
    
        // Verifique se o livro existe
        if (!$book) {
            return response()->json([
                'message' => 'Livro não encontrado',
            ], 404);
        }
    
        // Atualize os campos do livro
        $book->nome_livro = $request->input('nome'); // Use 'nome' em vez de 'nomeUpt'
    
        $book->update();
        
        return response()->json([
            'message' => 'Livro atualizado com sucesso',
            'book' => $book, // Obtenha os valores atualizados do livro
        ], 200);
    }

    public function destroy($id){
        $book = book::find($id);
        if ($book) {
            $book->delete();
            return response()->json([
                'message' => 'Livro excluído com sucesso',
                'code' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Livro não localizado',
                'code' => 404
            ]);
        }
    }
}
