<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function crea(Request $request)
    {
        Client::create([
            'nome' => $request->nome_cliente,
            'ora_sveglia' => 0,
            'colazione' => '',
        ]);
        
        return back();
    }

    public function index(Request $request)
    {
        $filter = null;
        if (!empty($request) && isset($request->filter)) {
            $clienti = Client::where('nome', 'like', '%'.$request->filter.'%')->paginate(10);
            $filter = $request->filter;
        } else {
            $clienti = Client::paginate(10);
        }

        return view('clients', [
            'clienti' => $clienti,
            'filter' => $filter
        ]);
    }

    public function edit(Request $request)
    {
        $cliente = Client::find($request->id);
        $cliente->nome = $request->nome;
        $cliente->ora_sveglia = $request->ora_sveglia;
        $cliente->colazione = $request->colazione;
        $cliente->save();
        
        return redirect()->route('client.index');
    }
}
