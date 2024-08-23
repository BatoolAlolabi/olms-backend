<?php

namespace App\Http\Controllers\Financial;

use App\Domain\Financial\Transactions\DTO\TransactionDTO;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Financial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FinancialController extends Controller
{
    public function deposit_amount(Request $request){
        $validator = Validator::make($request->all(),[
            'user_id' => 'required|exists:users,id',
            'amount' => 'numeric|required'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ],422);
        }

        $financial = Financial::query()->where('user_id',$request->input('user_id'))->first();
        $financial->deposit_Total += $request->input('amount');
        $financial->total_balance += $request->input('amount');
        $financial->save();
        $transactionDTO = TransactionDTO::fromRequest([
            'amount' => $request->input('amount'),
            'is_deposit' => true,
            'date'  => now()->toDateTimeString(),
            'financial_id' => $financial->id,
        ]);
        return response()->json(Response::success($financial->toArray()));
    }

    public function index(){
        $financials = Financial::with(['user'])->get();
        return response()->json(Response::success($financials->toArray()),200);
    }

}
