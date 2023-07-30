<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class HomeController extends Controller
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
    public function index()
    {
        $number_invoices = Invoice::count();
        if ($number_invoices == 0) {
            $number_invoices = 1;
        }
        $sum_total_allinvoice = number_format(Invoice::sum('total'), 2);
        $pre_allinvoice = ($number_invoices / $number_invoices) * 100;

        $number_unpaidinvoices = Invoice::where('value_status', 2)->count();
        $sum_total_unpaidinvoice = number_format(Invoice::where('value_status', 2)->sum('total'), 2);
        $pre_unpaidinvoice = ($number_unpaidinvoices / $number_invoices) * 100;

        $number_sempaidinvoices = Invoice::where('value_status', 1)->count();
        $sum_total_sempaidinvoice = number_format(Invoice::where('value_status', 1)->sum('total'), 2);
        $pre_sempaidinvoice = ($number_sempaidinvoices / $number_invoices) * 100;

        $number_paidinvoices = Invoice::where('value_status', 0)->count();
        $sum_total_paidinvoice = number_format(Invoice::where('value_status', 0)->sum('total'), 2);
        $pre_paidinvoice = ($number_paidinvoices / $number_invoices) * 100;

        $chartjs = app()->chartjs
            ->name('lineChartTest')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['الفواتير الغير مدفوعه', 'الفواتير المدفوعه جزئيا', 'الفواتير المدفوعه'])
            ->datasets([
                [
                    "label" => "نسبة الفواتير الغير مدفوعه",
                    'backgroundColor' => ['#f93a5a', '', ''],
                    'data' => [$pre_unpaidinvoice, 0, 0]
                ],
                [
                    "label" => "نسبة الفواتير المدفوعه جزئيا",
                    'backgroundColor' => ['#efa65f', '#efa65f', ''],
                    'data' => [0, $pre_sempaidinvoice, 0]
                ],
                [
                    "label" => "نسبة الفواتير المدفوعه",
                    'backgroundColor' => ['#029666 ', '', '#029666'],
                    'data' => [0, 0, $pre_paidinvoice]
                ],
            ])
            ->options([]);



        $chartjsc = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 400, 'height' => 280])
            ->labels(['الفواتير الغير مدفوعه', 'الفواتير المدفوعه جزئيا', 'الفواتير المدفوعه'])
            ->datasets([
                [
                    'backgroundColor' => ['#f93a5a', '#efa65f', '#029666'],
                    'hoverBackgroundColor' => ['#f7778c', '#f76a2d', '#48d6a8'],
                    'data' => [$pre_unpaidinvoice, $pre_sempaidinvoice, $pre_paidinvoice]
                ]
            ])
            ->options([]);
        return view(
            'home',
            compact(
                'chartjs',
                'chartjsc',
                'number_invoices',
                'sum_total_allinvoice',
                'pre_allinvoice',
                'number_unpaidinvoices',
                'sum_total_unpaidinvoice',
                'pre_unpaidinvoice',
                'number_sempaidinvoices',
                'sum_total_sempaidinvoice',
                'pre_sempaidinvoice',
                'number_paidinvoices',
                'sum_total_paidinvoice',
                'pre_paidinvoice'
            )
        );
    }
}
