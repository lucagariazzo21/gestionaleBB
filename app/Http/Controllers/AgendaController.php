<?php

namespace App\Http\Controllers;

use App\Prenotation;
use App\Room;
use Illuminate\Http\Request;

class AgendaController extends Controller
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
        if(!empty($request->all()) && isset($request->day) ) {
            $day = date($request->day);
        } else {
            $day = date('Y-m-d');
        }
        
        $start_date = date('Y-m-d', strtotime($day));
        $end_date = date('Y-m-d', strtotime($day. ' + 13 days'));
        $period = new \DatePeriod(
            new \DateTime($start_date),
            new \DateInterval('P1D'),
            new \DateTime($end_date)
        );

        $prenotations = Prenotation::where('data_arrivo', '>=', $start_date)
            ->orwhere('data_partenza', '>=', $start_date)
            ->orwhere('data_arrivo', '<=', $end_date)
            ->orwhere('data_partenza', '<=', $end_date)
            ->with('room', 'client')
            ->get();

        $array = [];
        foreach ($period as $date) {
            foreach ($prenotations as $prenotation) {
                if ($prenotation->data_arrivo == $date->format('Y-m-d')) {
                    $array[$date->format('Y-m-d')][$prenotation->room->nome][] = [
                        'nome' => $prenotation->nome,
                        'data_arrivo' => $prenotation->data_arrivo,
                        'ora_arrivo' => $prenotation->ora_arrivo,
                        'cliente' => $prenotation->client->nome,
                        'colazione' => $prenotation->client->colazione,
                        'ora_sveglia' => $prenotation->client->ora_sveglia,
                    ];
                }
                if ($prenotation->data_partenza == $date->format('Y-m-d')) {
                    $array[$date->format('Y-m-d')][$prenotation->room->nome][] = [
                        'nome' => $prenotation->nome,
                        'data_partenza' => $prenotation->data_partenza,
                        'ora_partenza' => $prenotation->ora_partenza,
                        'cliente' => $prenotation->client->nome,
                        'colazione' => $prenotation->client->colazione,
                        'ora_sveglia' => $prenotation->client->ora_sveglia,
                    ];
                }
                if ($date->format('Y-m-d') < $prenotation->data_partenza && $date->format('Y-m-d') > $prenotation->data_arrivo) {
                    $array[$date->format('Y-m-d')][$prenotation->room->nome][] = [
                        'nome' => $prenotation->nome,
                        'cliente' => $prenotation->client->nome,
                        'colazione' => $prenotation->client->colazione,
                        'ora_sveglia' => $prenotation->client->ora_sveglia,
                    ];
                }
            }
        }
        // dd($array);

        $tot_camere = Room::count();

        return view('agenda',
            [
                'tot_camere' => $tot_camere,
                'period' => $period,
                'array' => $array,
                'day' => $day
            ]
        );
    }

}
