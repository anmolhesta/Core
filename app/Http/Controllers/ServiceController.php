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
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function assignTeacher()
	{
        try {

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
            return response()->json(['message' => $th->getMessage(),'status' => 500],500);
        }
	}

    public function approveProfile()
	{
        try {
            if($this->request->type == 'teacher'){
                $endpoint = 'user/profile/approval';
            }elseif($this->request->type == 'student') {
                $endpoint = 'student/profile/approve';
            }else {
                return response()->json(['message' => 'Invalid Endpoint','status' => 404],404);
            }
            $promise = Http::async()->accept('application/json')
            ->put('http://localhost/microservices/User/public/api/'.$endpoint,$this->request->all())
            ->then(function ($awaitresponse) {
                return $awaitresponse->body();
            });
            $response  = Utils::unwrap($promise);
            $response =  Utils::settle($promise)->wait();
            $responseDecoded = json_decode($response[0]['value']);
            if($responseDecoded->status == 200){
                $data = (array)$responseDecoded;
                $promiseNotification =  Http::async()->accept('application/json')
                ->post('http://localhost/microservices/Notification/public/api/user/approval/notifcation',$data)
                ->then(function ($awaitresponse) {
                    return $awaitresponse->body();
                });
                $responseNotification  = Utils::unwrap($promiseNotification);
                $responseNotification =  Utils::settle($promiseNotification)->wait();

            }
            return $response;
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['message' => $th->getMessage(),'status' => 500],500);
        }
	}
}
