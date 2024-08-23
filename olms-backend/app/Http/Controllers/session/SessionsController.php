<?php

namespace App\Http\Controllers;
use App\Domain\Sessions\Actions\CreateSession;
use App\Domain\Sessions\DTO\SessionDTO;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SessionsController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $session = Category::all();
        return response()->json(Response::success($session->toArray()),200);
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
        $validator = Validator::make($request->all(),[
            'name' => ['required','string'],
            'description' => ['nullable','string'],
            'type' => ['string','nullable'],
            'max_capacity'=>['integer','nullable']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $SessionDTO = SessionDTO::fromRequest($request->all());
        $session = CreateSession::execute($SessionDTO);
        return response()->json(Response::success($session->toArray()),200);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {

    }

}
