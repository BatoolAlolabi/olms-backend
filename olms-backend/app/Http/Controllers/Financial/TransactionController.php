<?php

namespace App\Http\Controllers\Financial;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index(){
        $transactions = Transaction::with(['financial'])->get();
        return response()->json(Response::success($transactions->toArray()),200);
    }



}
