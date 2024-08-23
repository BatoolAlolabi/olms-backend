<?php

namespace App\Http\Controllers\Test;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $users = User::query()->where('id', 1)->get(); // return array
        $user = User::find(1); // return row 
        $response = ['data' => $users, 'data to array' => $users->toArray(), "manual array" => [$users]];
        return $response;
    }
}