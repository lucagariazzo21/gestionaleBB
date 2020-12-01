<?php

namespace App\Http\Controllers;

use App\Prenotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function index(Request $request)
    {
        $year = isset($request->year) ? $request->year : date("Y");
        $first_day = date($year) . '-01-01';
        $last_day = date($year) . '-12-31';

        $prenotations = Prenotation::where('data_partenza', '>=', $first_day)->where('data_partenza', '<=', $last_day)->get();
        $ricavi = [];
        $tot_ricavo = Prenotation::select(DB::raw('SUM(ricavo) as tot_ricavo'))->first();
        $tot['tot_ricavo'] = $tot_ricavo->tot_ricavo;
        $tot['tot_prenotazioni'] = Prenotation::count();

        foreach ($prenotations as $prenotation) {
            $mese = date("m",strtotime($prenotation['data_partenza']));
            
            if (isset($ricavi[$mese])) {
                $ricavi[$mese] += $prenotation['ricavo'];
            } else {
                $ricavi[$mese] = $prenotation['ricavo'];
            }

            if (isset($tot['ricavo'])) {
                $tot['ricavo'] += $prenotation['ricavo'];
            } else {
                $tot['ricavo'] = $prenotation['ricavo'];
            }

            if (isset($tot['prenotazioni'])) {
                $tot['prenotazioni'] += 1;
            } else {
                $tot['prenotazioni'] = 1;
            }
            
        }

        $data = [];

        for ($i=1; $i <= 12 ; $i++) { 
            $data[$i] = isset($ricavi[$i]) ? $ricavi[$i] : 0;
        }
        
        if (!empty($data) && isset($tot['ricavo'])) {
            $data = [
                'type' => 'bar',
                'data' => [
                    'labels' => ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giunio', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],
                    'datasets' => [
                        [
                            'data' => array_values($data),
                            'backgroundColor' => [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            'borderColor' => [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            'borderWidth' => 1
                        ],
                    ],
                ],
                'options' => [
                    'legend' => [
                        'display' => false
                    ],
                    'scales' => [
                        'yAxes' => [[
                            'ticks' => [
                                'beginAtZero' => true,
                            ]
                        ]]
                    ],
                ],
            ];
        } else {
            $tot['ricavo'] = null;
            $tot['prenotazioni'] = null;
            $data = [];
        }
    
        return view('statistic', [
            'data' => $data,
            'year' => $year,
            'tot'  => $tot
        ]);
    }
}
