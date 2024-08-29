<?php

namespace App\Http\Controllers\Financial;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Financial;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index(){
        if(!Gate::has('SUPER_ADMIN')){
            $financial = Financial::query()->where('user_id',auth('api')->id())->first();
            $transactions = Transaction::with(['financial.user'])->where('financial_id',$financial->id)->get();
        }else{
            $transactions = Transaction::with(['financial.user'])->get();
        }

        return response()->json(Response::success($transactions->toArray()),200);
    }



}
