<?php

namespace App\Http\Controllers;

use App\Prenotation;
use App\Room;
use Illuminate\Http\Request;

class CamereController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $filter = null;
        if (!empty($request) && isset($request->filter)) {
            $camere = Room::where('nome', 'like', '%'.$request->filter.'%')
                ->orwhere('n_letti', '=', $request->filter)->paginate(10);
            
            $filter = $request->filter;
        } else {
            $camere = Room::paginate(10);
        }
        
        $not_delete_rooms = Prenotation::where('data_partenza', '>', date('Y-m-d'))->orwhere('data_arrivo', '>', date('Y-m-d'))->pluck('camera_id')->toArray();

        return view('camere.index', [
            'camere' => $camere,
            'filter' => $filter,
            'not_delete_rooms' => $not_delete_rooms,
        ]);
    }

    public function create(Request $request)
    {
        $camera = Room::create([
            'nome' => $request->nome,
            'n_letti' => $request->n_letti,
        ]);
        
        return redirect()->route('camere.index');
    }

    public function edit(Request $request)
    {
        $camera = Room::find($request->id);
        $camera->nome = $request->nome;
        $camera->n_letti = $request->n_letti;
        $camera->save();
        
        return redirect()->route('camere.index');
    }

    public function destroy($camera_id)
    {
        Room::find($camera_id)->delete();
        
        return redirect()->route('camere.index');
    }

}