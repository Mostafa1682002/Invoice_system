<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceReportController extends Controller
{
    public function index()
    {
        return view('reports.report_invoice', ['type' => 1]);
    }


    public function search_invoice(Request $request)
    {
        $type = $request->type;
        if ($type == 1) {
            $request->validate(['status' => 'required'], ['status.required' => 'يرجي اختيار نوع الفاتوره']);
            $status = $request->status;
            $start_at = $request->start_at;
            $end_at = $request->end_at;
            //Check Date Empty Or Not
            if (empty($start_at) || empty($end_at)) {
                $details = Invoice::where('value_status', $status)->get();
            } else {
                $details = Invoice::where('value_status', $status)->whereBetween('invoice_date', [date($start_at), date($end_at)])
                    ->get();
            }
            return view('reports.report_invoice', ['details' => $details, 'type' => $type]);
        } else {
            $invoice_number = $request->invoice_number;
            $details = Invoice::where('invoice_number', $invoice_number)->get();
            return view('reports.report_invoice', ['details' => $details, 'type' => $type]);
        }
    }
}