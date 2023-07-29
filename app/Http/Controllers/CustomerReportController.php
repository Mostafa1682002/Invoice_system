<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Section;
use Illuminate\Http\Request;

class CustomerReportController extends Controller
{
    public function index()
    {
        $sections = Section::get();
        return view('reports.report_customer', compact('sections'));
    }


    public function search_customer(Request $request)
    {
        $section = $request->section;
        $product = $request->product;
        $start_at = $request->start_at;
        $end_at = $request->end_at;
        if (empty($start_at) || empty($end_at)) {
            $details = Invoice::where('product', $product)
                ->where('section_id', $section)->get();
        } else {
            $details = Invoice::where('product', $product)->where('section_id', $section)
                ->whereBetween('invoice_date', [date($start_at), date($end_at)])->get();
        }
        $sections = Section::get();
        return view('reports.report_customer', compact('details', 'sections'));
    }
}
