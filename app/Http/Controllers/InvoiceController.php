<?php

namespace App\Http\Controllers;

use App\Exports\InvoiceExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreInvoiceRequest;
use App\Models\Invoice;
use App\Models\Invoice_Attachment;
use App\Models\Invoice_Details;
use App\Models\Section;
use App\Models\User;
use App\Notifications\AddInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:قائمة الفواتير', ['only' => ['index']]);
        $this->middleware('permission:ارشيف الفواتير', ['only' => ['invoice_archive']]);
        $this->middleware('permission:الفواتير المدفوعة', ['only' => ['invoice_paid']]);
        $this->middleware('permission:الفواتير الغير مدفوعة', ['only' => ['invoice_unpaid']]);
        $this->middleware('permission:الفواتير المدفوعة جزئيا', ['only' => ['invoice_partial']]);
        $this->middleware('permission:اضافة فاتورة', ['only' => ['create', 'store']]);
        $this->middleware('permission:تعديل الفاتورة', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف الفاتورة', ['only' => ['destroy']]);
        $this->middleware('permission:تغير حالة الدفع', ['only' => ['edit_status', 'update_status']]);
        $this->middleware('permission:ارشفة الفاتورة', ['only' => ['archiveInvoice']]);
        $this->middleware('permission:استعادة الفاتوره', ['only' => ['restoreInvoice']]);
        $this->middleware('permission:طباعةالفاتورة', ['only' => ['printInvoice']]);
        $this->middleware('permission:تصدير EXCEL', ['only' => ['export']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::get();
        return view('invoices.invoices', ['invoices' => $invoices]);
    }
    public function invoice_archive()
    {
        $invoices = Invoice::onlyTrashed()->get();
        return view('invoices.invoice_archive', ['invoices' => $invoices]);
    }
    public function invoice_paid()
    {
        $invoices = Invoice::where('value_status', 0)->get();
        return view('invoices.invoice_paid', ['invoices' => $invoices]);
    }
    public function invoice_unpaid()
    {
        $invoices = Invoice::where('value_status', 2)->get();
        return view('invoices.invoice_unpaid', ['invoices' => $invoices]);
    }
    public function invoice_partial()
    {
        $invoices = Invoice::where('value_status', 1)->get();
        return view('invoices.invoice_partial', ['invoices' => $invoices]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::get();
        return view('invoices.add_invoice', ['sections' => $sections]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        Invoice::create([
            "invoice_number" => $request->invoice_number,
            "invoice_date" => $request->invoice_date,
            "due_date" => $request->due_date,
            "section_id" => $request->section_id,
            "product" => $request->product,
            "amount_collection" => $request->amount_collection,
            "amount_commission" => $request->amount_commission,
            "discount" => $request->discount,
            "rate_vat" => $request->rate_vat,
            "value_vat" => $request->value_vat,
            "total" => $request->total,
            "status" => 'غير مدفوعه',
            "value_status" => 2,
            "notes" => $request->notes,
        ]);

        $invoice_id = Invoice::latest()->first()->id;
        Invoice_Details::create([
            "invoice_number" => $request->invoice_number,
            'invoice_id' => $invoice_id,
            "section" => $request->section_id,
            "product" => $request->product,
            "status" => 'غير مدفوعه',
            "value_status" => 2,
            "notes" => $request->notes,
            "user" => Auth::user()->name,
        ]);

        if ($request->hasFile('pic')) {
            $fileName = $request->file('pic')->getClientOriginalName();
            Storage::disk('invoice_attachments');
            $request->file('pic')->storeAs("$request->invoice_number/", $fileName, 'invoice_attachments');
            Invoice_Attachment::create([
                'file_name' => $fileName,
                'invoice_number' => $request->invoice_number,
                'created_by' => Auth::user()->name,
                'invoice_id' => $invoice_id
            ]);
        }
        //Send Notification
        if (!empty($invoice_id)) {
            $users = User::where('id', '!=', Auth::user()->id)->get();
            foreach ($users as $user) {
                Notification::send($user, new AddInvoice($invoice_id));
            };
        }
        return redirect()->route('invoices.index')->with('invoice_sucsess', 'تم اضافة الفاتوره بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoice = Invoice::find($id);
        $sections = Section::all();
        return view('invoices.edite_invoice', compact('id', 'invoice', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                "invoice_number" => ['required', "unique:invoices,invoice_number,$id"],
                "invoice_date" => ['required'],
                "due_date" => ['required'],
                "section_id" => ['required'],
                "product" => ['required'],
                "amount_commission" => ['required'],
            ],
            [
                "invoice_number.required" => 'رقم الفاتوره مطلوب',
                "invoice_number.unique" => "هذا الرقم موجود مسبقا برجاء ادخال رقم اخر",
                "invoice_date.required" => "تاريخ الفاتوره مطلوب",
                "due_date.required" => "تاريخ الاستحقاق مطلوب",
                "section_id.required" => "اسم القسم مطلوب",
                "product.required" => "اسم المنتج مطلوب",
                "amount_commission.required" => "مبلغ العموله مطلوب",
            ]
        );
        $invoice_edite = Invoice::findOrFail($id);
        //Rename Folder Invoice Number
        Storage::disk('invoice_attachments')->move("$invoice_edite->invoice_number/", "$request->invoice_number/");
        //Update Invoice table
        $invoice_edite->update($request->all());


        //Update Invoice_Attachments table
        Invoice_Attachment::where('invoice_id', $id)->update([
            'invoice_number' => $request->invoice_number
        ]);

        //Update Invoice_Details table
        Invoice_Details::where('invoice_id', $id)->update([
            'invoice_number' => $request->invoice_number,
            'product' =>  $request->product,
            'section' => $request->section_id,
            'notes' => $request->notes,
        ]);

        return redirect()->route('invoices.index')->with('invoice_sucsess', 'تم تعديل الفاتوره بنجاح');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit_status($id)
    {
        $invoice = Invoice::findOrFail($id);
        return view('invoices.edit_status', compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_status(Request $request, $id)
    {
        $request->validate([
            'value_status' => 'required',
            'payment_date' => 'required',
        ], [
            'value_status.required' => "برجاء تحديد الحاله",
            'payment_date.required' => "برجاء ادخال تاريخ الدفع"
        ]);
        $invoice = Invoice::findOrFail($id);
        if ($request->value_status == 0) {
            $invoice->update([
                'status' => "مدفوعه",
                'value_status' => $request->value_status,
                'payment_date' => $request->payment_date,
            ]);
            Invoice_Details::create([
                "invoice_number" => $request->invoice_number,
                'invoice_id' => $id,
                "section" => $request->section_id,
                "product" => $request->product,
                "status" => 'مدفوعه',
                "value_status" => $request->value_status,
                "notes" => $request->notes,
                "user" => auth()->user()->name,
                'payment_date' => $request->payment_date,
            ]);
        } else {
            $invoice->update([
                'status' => "مدفوعه جزئيا",
                'value_status' => $request->value_status,
                'payment_date' => $request->payment_date,
            ]);
            Invoice_Details::create([
                'invoice_id' => $id,
                "invoice_number" => $request->invoice_number,
                "section" => $request->section_id,
                "product" => $request->product,
                'status' => "مدفوعه جزئيا",
                "value_status" => $request->value_status,
                "notes" => $request->notes,
                "user" => auth()->user()->name,
                'payment_date' => $request->payment_date
            ]);
        }
        return redirect()->route('invoices.index')->with('invoice_sucsess', 'تم تعديل  حالة دفع الفاتوره بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $delete_id = $request->id;
        $delete_number = $request->invoice_number;
        Invoice::withTrashed()->where('id', $delete_id)->forceDelete();
        Storage::disk('invoice_attachments')->deleteDirectory($delete_number);
        return redirect()->back()->with('invoice_sucsess', 'تم حذف الفاتوره بنجاح');
    }

    public function archiveInvoice(Request $request, $id)
    {
        Invoice::where('id', $request->id)->delete();
        return redirect()->route('invoices.index')->with('invoice_sucsess', 'تم ارشفة الفاتوره بنجاح');
    }

    public function restoreInvoice(Request $request, $id)
    {
        Invoice::withTrashed()->where('id', $request->id)->restore();
        return redirect()->route('invoices.index')->with('invoice_sucsess', 'تم استعادة الفاتوره بنجاح');
    }

    public function printInvoice($id)
    {
        $invoice = Invoice::withTrashed()->where('id', $id)->first();
        return view('invoices.print_invoice', compact('invoice'));
    }

    public function getProducts($id)
    {
        $products = DB::table('products')->where('section_id', $id)->pluck('product_name', 'id');
        return json_encode($products);
    }
    public function export()
    {
        return Excel::download(new InvoiceExport, 'invoices.xlsx');
    }
}
