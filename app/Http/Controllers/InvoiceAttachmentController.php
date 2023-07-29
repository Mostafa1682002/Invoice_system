<?php

namespace App\Http\Controllers;

use App\Models\Invoice_Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceAttachmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:اضافة مرفق', ['only' => ['create', 'store']]);
        $this->middleware('permission:حذف مرفق', ['only' => ['destroy']]);
    }
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
        $request->validate([
            'file_name' => 'required|unique:invoice__attachments|mimes:png,jpg,pdf,jpeg'
        ], [
            'file_name.required' => "برجاء اختيار مرفق",
            'file_name.unique' => " هذا المرفق موجود بالفعل",
            'file_name.mimes' => "صيغه المرفق يجب ان تكون pdf,jpg,jpeg,png"
        ]);
        $file_name = $request->file('file_name')->getClientOriginalName();
        $request->file('file_name')->storeAs("$request->invoice_number/", $file_name, 'invoice_attachments');
        Invoice_Attachment::create([
            'file_name' => $file_name,
            'invoice_number' => $request->invoice_number,
            'invoice_id' => $request->invoice_id,
            'created_by' => Auth()->user()->name
        ]);
        return redirect()->back()->with('success_invoice', 'تم اضافة المرفق بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice_Attachment $invoice_Attachment)
    {
        // return $invoice_Attachment;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice_Attachment $invoice_Attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice_Attachment $invoice_Attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $attach = Invoice_Attachment::find($id);
        if ($attach) {
            $attach->delete();
            Storage::disk('invoice_attachments')->delete("$request->invoice_name/$request->file_name");
            return redirect()->back()->with('success_invoice', 'تم حذف المرفق بنجاح');
        }
    }
}