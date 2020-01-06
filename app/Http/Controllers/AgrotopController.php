<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgrotopController extends Controller
{

    private $user = "camiongo";
    private $password = "p0rt4ld3cl13nt35";

    public function secure(Request $request){
        $card_code = $request->input('card_code');
        $client = new \GuzzleHttp\Client();
        $request = $client->request('POST', 'http://agrotopapi.empresasagrotop.cl/api/login/authenticate', [
            'json' => array(
                "Username"=>$this->user,
                "Password"=>$this->password
            )
        ]);
        if($request->getStatusCode() == 200){
            return response()->json(['Status' => 'Success', 'Value' =>$request->getBody()]);
        }else{
            return response()->json(['Error' => 'Success', 'Value' =>'Problema con la api, codigo de error: '.$request->getStatusCode()]);   
        }       
        
    }
}
