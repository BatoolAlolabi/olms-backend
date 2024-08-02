<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categoires = Category::with(['courses' => function ($query) {
            $query->with(['teacher'])->inRandomOrder()->limit(4);
        }])->inRandomOrder()->limit(3)->get();
        $data['categoires'] = $categoires;
        return response()->json(Response::success($data), 200);
    }
}