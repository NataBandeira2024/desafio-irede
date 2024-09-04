<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
    public function index()
    {
        return Produto::with('categoria')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:50',
            'descricao' => 'nullable|string|max:200',
            'preco' => 'required|numeric|min:0',
            'data_validade' => 'required|date|after_or_equal:today',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $imagemPath = null;
        if ($request->hasFile('imagem')) {
            $imagemPath = $request->file('imagem')->store('imagens', 'public');
        }

        Produto::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'data_validade' => $request->data_validade,
            'imagem' => $imagemPath,
            'categoria_id' => $request->categoria_id,
        ]);

        return response()->json(['message' => 'Produto criado com sucesso!'], 201);
    }


    public function show(Produto $produto)
    {
        return $produto->load('categoria');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:50',
            'descricao' => 'nullable|string|max:200',
            'preco' => 'required|numeric|min:0',
            'data_validade' => 'required|date|after_or_equal:today',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $produto = Produto::findOrFail($id);
        $imagemPath = $produto->imagem;

        if ($request->hasFile('imagem')) {
            if ($imagemPath) {
                Storage::delete($imagemPath);
            }
            $imagemPath = $request->file('imagem')->store('imagens');
        }

        $produto->update([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'data_validade' => $request->data_validade,
            'imagem' => $imagemPath,
            'categoria_id' => $request->categoria_id,
        ]);

        return response()->json(['message' => 'Produto atualizado com sucesso!']);
    }

    public function destroy(Produto $produto)
    {
        // Deleta o produto
        $produto->delete();
        return response()->json(null, 204);
    }

    public function getImage($filename)
    {
        return Storage::download($filename);
    }

}
