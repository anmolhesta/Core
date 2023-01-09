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
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function StudentRegister()
	{
        try {
            //dd($this->request->all());
            //$request2 = Http::accept('application/json')->post('http://localhost/admin/public/api/student/register',$this->request->all());
            $promise = Http::async()->accept('application/json')
            ->attach('profile_picture',file_get_contents($this->request->profile_picture),
            $this->request->file('profile_picture')->getClientOriginalName())
            ->post('http://localhost/admin/public/api/student/register',$this->request->all())
            ->then(function ($awaitresponse) {
                return $awaitresponse->body();
            });
            $response  = Utils::unwrap($promise);
            $response =  Utils::settle($promise)->wait();
            return $response;
        } catch (\Throwable $th) {
            Log::error($th);
        }
	}

    public function TeacherRegister()
	{
        try {
            //dd($this->request->all());
            //$request2 = Http::accept('application/json')->post('http://localhost/admin/public/api/student/register',$this->request->all());
            $promise = Http::async()->accept('application/json')
            ->attach('profile_picture',file_get_contents($this->request->profile_picture),
            $this->request->file('profile_picture')->getClientOriginalName())
            ->post('http://localhost/launchpad/public/api/teacher/register',$this->request->all())
            ->then(function ($awaitresponse) {
                return $awaitresponse->body();
            });
            $response  = Utils::unwrap($promise);
            $response =  Utils::settle($promise)->wait();
            return $response;
        } catch (\Throwable $th) {
            Log::error($th);
        }
	}

    public function UserLogin()
	{
        try {
            //dd($this->request->all());
            //$request2 = Http::accept('application/json')->post('http://localhost/admin/public/api/student/register',$this->request->all());
            $promise = Http::async()->accept('application/json')
            ->post('http://localhost/launchpad/public/api/student/login',$this->request->all())
            ->then(function ($awaitresponse) {
                return $awaitresponse->body();
            });
            $response  = Utils::unwrap($promise);
            $response =  Utils::settle($promise)->wait();
            return $response;
        } catch (\Throwable $th) {
            Log::error($th);
        }
	}
}
