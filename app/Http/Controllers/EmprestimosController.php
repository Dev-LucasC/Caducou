<?php

namespace App\Http\Controllers;

use App\Models\DinheiroEmprestado;
use Inertia\Inertia;
use App\Models\Emprestimo;
use Illuminate\Http\Request;

class EmprestimosController extends Controller
{
   public function index(Request $request)
{
    $emprestimos = $request->user()->emprestimos()->get();

    return Inertia::render('DinheiroEmprestado', [
        'user' => $request->user(),
        'emprestimos' => $emprestimos,
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

    DinheiroEmprestado::create($data);

    return back();
}

    public function update(Request $request, $id)
    {
        $emprestimo = DinheiroEmprestado::findOrFail($id);
        $emprestimo->update($request->all());
        return redirect()->back();
    }

    public function destroy($id)
    {
        DinheiroEmprestado::destroy($id);
        return redirect()->back();
    }
}
