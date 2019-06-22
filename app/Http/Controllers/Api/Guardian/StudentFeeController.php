<?php

namespace App\Http\Controllers\Api\Guardian;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use App\AdditionalFee;
use App\InvoiceMaster;

class StudentFeeController extends Controller
{

    protected $Invoices;

    public function GetFeeInvoices(Request $request){

        $this->Invoices = InvoiceMaster::where('student_id', $request->input('id'))->with('InvoiceDetail')->orderBy('payment_month', 'desc')->simplePaginate($request->input('per_page'));

        return response()->json($this->Invoices, 200, ['Content-Type' => 'application/json'], JSON_NUMERIC_CHECK);
    }

}
