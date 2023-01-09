<?php

namespace App\Http\Controllers;

use Facade\FlareClient\Http\Response;
use GuzzleHttp\Exception\TransferException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Promise\Utils;

class ServiceController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function assignTeacher()
	{
        try {
            //dd($this->request->all());
            //$request2 = Http::accept('application/json')->post('http://localhost/admin/public/api/student/register',$this->request->all());
            $promise = Http::async()->accept('application/json')
            ->post('http://localhost/admin/public/api/teacher/assignment',$this->request->all())
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

    public function approveProfile()
	{
        try {
            //dd($this->request->all());
            //$request2 = Http::accept('application/json')->post('http://localhost/admin/public/api/student/register',$this->request->all());
            $promise = Http::async()->accept('application/json')
            ->put('http://localhost/admin/public/api/user/profile/approval',$this->request->all())
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
