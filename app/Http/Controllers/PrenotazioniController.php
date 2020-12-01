<?php

namespace App\Http\Controllers;

use App\Client;
use App\Prenotation;
use App\Room;
use App\Setting;
use Illuminate\Http\Request;

class PrenotazioniController extends Controller
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
            $prenotazioni = Prenotation::where('nome', 'like', '%' . $request->filter . '%')
                ->orwhere('n_persone', '=', $request->filter)->with('room', 'client')->paginate(10);

            $filter = $request->filter;
        } else {
            $prenotazioni = Prenotation::with('room', 'client')->paginate(10);
        }
        return view('prenotazioni.index', [
            'prenotazioni' => $prenotazioni,
            'filter' => $filter,
        ]);
    }

    public function detail(Request $request)
    {
        $day = null;
        $start_hour = null;
        if (isset($request->day)) {
            $day = $request->day;
        }
        if (isset($request->ora_max)) {
            $start_hour = $request->ora_max;
        }

        $clients = Client::all();

        return view('prenotazioni.detail', [
            'day' => $day,
            'ora_inizio' => $start_hour,
            'clients' => $clients,
        ]);
    }

    public function check(Request $request)
    {
        $error = false;
        $tot_camere = Room::count();
        $prenotazions_today = Prenotation::where('data_partenza', $request->data_arrivo)->where('ora_partenza', '<=', $request->ora_arrivo)->get();

        $prenotations = Prenotation::where('data_arrivo', '<=', $request->data_partenza)
            ->where('data_partenza', '>=', $request->data_arrivo);

        if (isset($request->prenotazione_id)) {
            $prenotations->where('id', '!=', $request->prenotazione_id);
        }

        $prenotations->get();

        $occupied_rooms = $prenotations->pluck('camera_id')->toArray();

        if ($prenotazions_today->first() != null) {
            $count = 0;
            foreach ($prenotazions_today as $prenotation) {
                if (in_array($prenotation->camera_id, $occupied_rooms)) {
                    unset($occupied_rooms[$count]);
                }
                $count++;
            }
        }

        if (count($occupied_rooms) == $tot_camere) {
            $error = 'Non ci sono camere libere per questo periodo';
        }

        if ($error == false) {
            $n_persone = $request->n_persone;
            $camere_libere = Room::whereNotIn('id', $occupied_rooms)->where('n_letti', '>=', $n_persone)->get();
            if ($camere_libere->first() == null) {
                $error = 'Non ci sono camere per il numero di persone selezionato';
            }
            if ($error == false) {
                $period = new \DatePeriod(
                    new \DateTime($request->data_arrivo),
                    new \DateInterval('P1D'),
                    new \DateTime($request->data_partenza)
                );

                $conteggio = [];
                foreach ($period as $date) {
                    $count = 0;
                    foreach ($prenotations as $prenotation) {
                        if ($prenotation->data_arrivo == $date->format('Y-m-d') || $prenotation->data_partenza == $date->format('Y-m-d') || $prenotation->data_partenza > $date->format('Y-m-d') && $prenotation->data_arrivo > $date->format('Y-m-d')) {
                            $conteggio[$date->format('Y-m-d')] =  $count++;
                            if ($conteggio[$date->format('Y-m-d')] == $tot_camere) {
                                $error = true;
                                break;
                            }
                        }
                    }
                }
            }
        }


        $return = [];
        $return['data'] = $request->all();

        $return['clients'] = Client::all();
        if (isset($request->prenotazione_id)) {
            $return['edit'] = true;
        }

        if ($error) {
            $return['message'] = $error;
        } else {
            $return['view_camere'] = true;
            $return['camere_libere'] = $camere_libere;
        }

        return view('prenotazioni.detail', $return);
    }

    public function create(Request $request)
    {
        $has_animals = isset($request->has_animals) ? 1 : 0;
        // $added_bed = isset($request->added_bed) ? 1 : 0;
        $ricavo = $this->calcolaPrezzo($request->data_arrivo, $request->data_partenza, $request->n_persone, $has_animals, $request->sconto);

        Prenotation::create([
            // 'nome' => $request->nome,
            'n_persone' => $request->n_persone,
            'data_arrivo' => $request->data_arrivo,
            'data_partenza' => $request->data_partenza,
            'ora_arrivo' => $request->ora_arrivo,
            'ora_partenza' => $request->ora_partenza,
            'camera_id' => $request->camera_id,
            'has_animals' => $has_animals,
            'ricavo' => $ricavo,
            'sconto' => $request->sconto,
            'client_id' => $request->client_id,
        ]);

        return redirect()->route('agenda', ['day' => $request->data_arrivo]);
    }

    public function calcolaPrezzo($data_arrivo, $data_partenza, $n_persone, $has_animals, $sconto)
    {
        $setting = Setting::first();

        $dStart = new \DateTime($data_arrivo);
        $dEnd  = new \DateTime($data_partenza);
        $dDiff = $dStart->diff($dEnd);
        $days = $dDiff->days;

        $ricavo = 0;
        switch ($n_persone) {
            case 1:
                $ricavo = $days * $setting['single_room_price'];
                break;

            case 2:
                $ricavo = $days * $setting['room_price'];
                break;
            
            default:
                $prezzo_giorno = $setting['room_price'] + (($n_persone - 2) * $setting['added_bed_price']);
                $ricavo = $days * $prezzo_giorno;
                break;
        }

        if ($has_animals) {
            $ricavo += $setting['has_animal_price'];
        }

        if ($sconto) {
            $ricavo = $ricavo - $sconto;
        }

        $ricavo = floatval($ricavo);

        return $ricavo;
    }

    public function edit(Prenotation $prenotazione) {
        $return['clients'] = Client::all();
        $return['data'] = $prenotazione;
        $return['edit'] = true;
        return view('prenotazioni.detail', $return);
    }

    public function destroy($prenotation)
    {
        Prenotation::find($prenotation)->delete();
        
        return redirect()->route('prenotazioni.prenotazioni');
    }

    public function update(Request $request)
    {
        $has_animals = isset($request->has_animals) ? 1 : 0;
        // $added_bed = isset($request->added_bed) ? 1 : 0;
        $ricavo = $this->calcolaPrezzo($request->data_arrivo, $request->data_partenza, $request->n_persone, $has_animals);

        $prenotation = Prenotation::find($request->prenotazione_id);
        $prenotation->n_persone = $request->n_persone;
        $prenotation->data_arrivo = $request->data_arrivo;
        $prenotation->data_partenza = $request->data_partenza;
        $prenotation->ora_arrivo = $request->ora_arrivo;
        $prenotation->ora_partenza = $request->ora_partenza;
        $prenotation->camera_id = $request->camera_id;
        $prenotation->has_animals = $has_animals;
        $prenotation->ricavo = $ricavo;
        // $prenotation->added_bed = $added_bed;
        $prenotation->client_id = $request->client_id;
        $prenotation->save();
        
        return redirect()->route('prenotazioni.prenotazioni');
    }
}
