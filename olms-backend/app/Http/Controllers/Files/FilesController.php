<?php

namespace App\Http\Controllers\Files;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FilesController extends Controller
{
    public function upload_file(Request $request){
        $validator = Validator::make($request->all(),[
            'file' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('images');
            $response = [
                'file_path' => '/storage/'.$path
            ];
            return response()->json(Response::success($response),200);
        }
    }
}
