<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Planta;
use Illuminate\Support\Facades\Storage;

class PlantaController extends Controller
{
    protected Planta $planta;

    public function __construct()
    {
        $this->planta = new Planta();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $plantas = Planta::all();

        if ($request->ajax()) {
            // Retorna só o conteúdo parcial para AJAX
            return view('plantas.partials.list', compact('plantas'))->render();
        }

        // Retorna a página completa para requisição normal
        return view('plantas', compact('plantas'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('planta_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação (opcional, mas recomendado)
        $request->validate([
            'nome' => 'required|string|max:100',
            'nome_cientifico' => 'nullable|string|max:150',
            'descricao' => 'nullable|string',
            'foto' => 'nullable|image|max:5120', // até 5MB
        ]);

        // Prepara os dados
        $dados = [
            'nome' => $request->input('nome'),
            'nome_cientifico' => $request->input('nome_cientifico'),
            'descricao' => $request->input('descricao'),
        ];

        // Se houver imagem, armazena
        if ($request->hasFile('foto')) {
            $dados['foto'] = $request->file('foto')->store('plantas', 'public');
        }

        // Cria planta
        $created = $this->planta->create($dados);

        // Verifica se foi via AJAX
        if ($request->ajax()) {
            if ($created) {
                return response()->json(['message' => 'Planta criada com sucesso'], 200);
            } else {
                return response()->json(['message' => 'Erro ao criar planta'], 500);
            }
        }

        // Se não for AJAX, redireciona normal
        if ($created) {
            return redirect()->back()->with('message', 'Planta criada com sucesso');
        }

        return redirect()->back()->with('message', 'Erro ao criar planta');
    }


    /**
     * Display the specified resource.
     */
    public function show(Planta $planta)
    {
        return view('planta_show', ['planta' => $planta]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $planta = Planta::findOrFail($id);
        return view('planta_edit', ['planta' => $planta]);
    }

    /**
     * Update the specified resource in storage.
     */
/**
 * Update the specified resource in storage.
 */
    public function update(Request $request, string $id)
    {
        $planta = Planta::findOrFail($id);

        // Validação (opcional, mas recomendado)
        $request->validate([
            'nome' => 'required|string|max:100',
            'nome_cientifico' => 'nullable|string|max:150',
            'descricao' => 'nullable|string',
            'foto' => 'nullable|image|max:5120', // até 5MB
        ]);

        // Prepara os dados
        $dados = [
            'nome' => $request->input('nome'),
            'nome_cientifico' => $request->input('nome_cientifico'),
            'descricao' => $request->input('descricao'),
        ];

        // Verifica se há uma nova imagem para atualizar
        if ($request->hasFile('foto')) {
            // Deleta a imagem antiga se existir
            if ($planta->foto) {
                Storage::disk('public')->delete($planta->foto);
            }
            
            // Armazena a nova imagem
            $dados['foto'] = $request->file('foto')->store('plantas', 'public');
        }

        // Atualiza os dados da planta
        $updated = $planta->update($dados);

        if ($updated) {
            return redirect()->back()->with('message', 'Planta atualizada com sucesso');
        }

        return redirect()->back()->with('message', 'Erro ao atualizar planta');
    }


    /**
     * Remove the specified resource from storage.
     */
public function destroy(string $id)
{
    $this->planta->where('id', $id)->delete();

    if (request()->expectsJson()) {
        return response()->json(['message' => 'Planta excluída com sucesso.'], 200);
    }

    return redirect()->route('plantas.index');
}

    public function listarJson() {
    $plantas = Planta::all();
    return response()->json($plantas);
}

}
