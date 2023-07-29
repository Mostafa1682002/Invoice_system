<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Invoice_Attachment;
use App\Models\Invoice_Details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class InvoiceDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //Mark Read Notification
        $id_notification = DB::table('notifications')->where('data->invoice_id', $id)->pluck('id');
        DB::table('notifications')->where('id', $id_notification)->update(['read_at' => now()]);


        $invoices = Invoice::findOrFail($id);
        $invoice_details = Invoice_Details::where('invoice_id', $id)->get();
        $invoice_attachment = Invoice_Attachment::where('invoice_id', $id)->get();
        return view('invoices.invoice_details', compact('invoices', 'invoice_details', 'invoice_attachment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice_Details $invoice_Details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice_Details $invoice_Details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice_Details $invoice_Details)
    {
        //
    }
    public function download($invoice_number, $file_name)
    {
        $file = "imges_uplode/Attachments/$invoice_number/$file_name";
        // return Response::file($file);
        return Response::download($file);
    }
}
