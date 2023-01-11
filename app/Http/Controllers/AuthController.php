<?php

namespace App\Http\Controllers;

use Facade\FlareClient\Http\Response;
use GuzzleHttp\Exception\TransferException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Promise\Utils;

class AuthController extends Controller
{
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function StudentRegister()
	{
        try {
            $promise = Http::async()->accept('application/json')
            ->attach('profile_picture',file_get_contents($this->request->profile_picture),
            $this->request->file('profile_picture')->getClientOriginalName())
            ->post('http://localhost/microservices/Student/public/api/teacher/register',$this->request->all())
            ->then(function ($awaitresponse) {
                return $awaitresponse->body();
            });
            $response  = Utils::unwrap($promise);
            $response =  Utils::settle($promise)->wait();
            return $response;
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['message' => $th->getMessage(),'status' => 500],500);
        }
	}

    public function TeacherRegister()
	{
        try {

            $promise = Http::async()->accept('application/json')
            ->attach('profile_picture',file_get_contents($this->request->profile_picture),
            $this->request->file('profile_picture')->getClientOriginalName())
            ->post('http://localhost/microservices/User/public/api/teacher/register',$this->request->all())
            ->then(function ($awaitresponse) {
                return $awaitresponse->body();
            });
            $response  = Utils::unwrap($promise);
            $response =  Utils::settle($promise)->wait();
            return $response;
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['message' => $th->getMessage(),'status' => 500],500);
        }
	}

    public function StudentUserLogin()
	{
        try {

            $promise = Http::async()->accept('application/json')
            ->post('http://localhost/microservices/Student/public/api/teacher/login',$this->request->all())
            ->then(function ($awaitresponse) {
                return $awaitresponse->body();
            });
            $response  = Utils::unwrap($promise);
            $response =  Utils::settle($promise)->wait();
            return $response;
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['message' => $th->getMessage(),'status' => 500],500);
        }
	}

    public function TeacherUserLogin()
	{
        try {

            $promise = Http::async()->accept('application/json')
            ->post('http://localhost/microservices/User/public/api/teacher/login',$this->request->all())
            ->then(function ($awaitresponse) {
                return $awaitresponse->body();
            });
            $response  = Utils::unwrap($promise);
            $response =  Utils::settle($promise)->wait();
            return $response;
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['message' => $th->getMessage(),'status' => 500],500);
        }
	}


    public function AdminUserLogin()
	{
        try {

            $promise = Http::async()->accept('application/json')
            ->post('http://localhost/microservices/Admin/public/api/teacher/login',$this->request->all())
            ->then(function ($awaitresponse) {
                return $awaitresponse->body();
            });
            $response  = Utils::unwrap($promise);
            $response =  Utils::settle($promise)->wait();
            return $response;
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['message' => $th->getMessage(),'status' => 500],500);
        }
	}
}
