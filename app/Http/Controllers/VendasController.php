<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Venda;
use App\Models\VendasRealizada;
use Illuminate\Http\Request;

class VendasController extends Controller
{
    public function index(Request $request)
    {
        $vendas = $request->user()->vendas()->get();

        return Inertia::render('VendasRealizadas', [
            'user' => $request->user(),
            'vendas' => $vendas,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome_cliente' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'data' => 'required|date',
            'descricao' => 'nullable|string',
        ]);

        $data['user_id'] = auth()->id(); // <- adiciona o usuário logado

        VendasRealizada::create($data);

        return back();
    }

    public function update(Request $request, $id)
    {
        $venda = VendasRealizada::findOrFail($id);
        $venda->update($request->all());
        return redirect()->back();
    }

    public function destroy($id)
    {
        VendasRealizada::destroy($id);
        return redirect()->back();
    }
}
