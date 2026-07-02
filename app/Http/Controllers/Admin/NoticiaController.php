<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticiaController extends Controller
{
    /**
     *Lista de Notícias
     */
    public function index()
    {
        $noticias = Noticia::all();
        return view ('admin.noticias.index',[
            'noticias'=> $noticias
        ]);
    }

    /**
     * Mostrar formulário para cadastrar nova notícia
     */
    public function create()
    {
        $categorias = Categoria::orderBy('nome','ASC')->pluck('nome','id');

        
        return view ('admin.noticias.cadastrar',[
            'categorias'=> $categorias
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|min:10',
            'resumo' => 'required|min:10',
            'conteudo' => 'required|min:20',
            'categoria_id' => 'required',
            'imagem' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $noticia = new Noticia();
        $noticia->titulo = $request->titulo;
        $noticia->resumo = $request->resumo;
        $noticia->conteudo = $request->conteudo;
        $noticia->categoria_id = $request->categoria_id;
        $noticia->status = $request->status;
        $noticia->usuario_id = Auth::user()->id;

        if($request->hasFile('imagem')){
            $noticia->imagem = $request->file('imagem')->store('noticias','public');
            
        };

        $noticia->save();

        return redirect()->route('admin.noticias.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $noticias = Noticia::findOrFail($id);
        $noticias->delete();
        return redirect()->route('admin.noticias.index');
    }
}
