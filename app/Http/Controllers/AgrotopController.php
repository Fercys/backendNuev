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
        $request = $client->post('http://agrotopapi.empresasagrotop.cl/api/login/authenticate', [
            'form_params' => array(
                "Username"=>$this->user,
                "Password"=>$this->password
            )
        ]);
        if($request->getStatusCode() == 200){
            $url = 'http://agrotopapi.empresasagrotop.cl/api/FichasTecnicas/GetFichasTecnicas?id='.$card_code;
            //$client->setDefaultOption('header', array('Authorization' => 'Bearer '.(string)$request->getBody()));
            $request = $client->get($url,[
                'headers' => [
                    'Authorization' => 'Bearer'.str_replace("\""," ",(string)$request->getBody())
                ]
            ]);
            return response()->json(['Status' => 'Success', 'Value' =>json_decode($request->getBody()->getContents())]);
        }else{
            return response()->json(['Error' => 'Success', 'Value' =>'Problema con la api, codigo de error: '.$request->getStatusCode()]);   
        }       
        
    }
}
