<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agrotop;
use DB;

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
    public function create(Request $request){
        $card_code = $request->input('card_code');
        $id_user = $request->input('id_user');
        $client = new \GuzzleHttp\Client();
        $request = $client->post('http://agrotopapi.empresasagrotop.cl/api/login/authenticate', [
            'form_params' => array(
                "Username"=>$this->user,
                "Password"=>$this->password
            )
        ]);
        if($request->getStatusCode() == 200){
            $url = 'http://agrotopapi.empresasagrotop.cl/api/FichasTecnicas/GetFichasTecnicas?id='.$card_code;
            $request = $client->get($url,[
                'headers' => [
                    'Authorization' => 'Bearer'.str_replace("\""," ",(string)$request->getBody())
                ]
            ]);
            $data = json_decode($request->getBody()->getContents());
            foreach ($data as $key => $value) { 
                $validate = Agrotop::where('IdFichaTecnica',$value->IdFichaTecnica)->first();
                if($validate != null){
                    return json_encode(['Error' => 'Error', 'Value' =>'Id de ficha tecnica repetido: '.$validate->IdFichaTecnica]);
                }
                $id_save = $this->save_agrotop_main_table($value,$id_user);
            }
            return response()->json(['Status' => 'Success', 'Value' =>'Registro guardado con exito']);
            //return response()->json(['Status' => 'Success', 'Value' =>json_decode($request->getBody()->getContents())]);
        }else{
            return response()->json(['Error' => 'Success', 'Value' =>'Problema con la api, codigo de error: '.$request->getStatusCode()]);   
        }        
    }
    private function save_agrotop_main_table($value,$id_user){
        $agrotop = new Agrotop;
        $agrotop->Cliente = $value->Cliente;
        $agrotop->Codigo = $value->Codigo;
        $agrotop->FamiliaProducto = $value->FamiliaProducto;
        $agrotop->Fumigacion = (boolean)$value->Fumigacion;
        $agrotop->Granel = (boolean)$value->Granel;
        $agrotop->HumedadRelativa = $value->HumedadRelativa;
        $agrotop->IdCliente = $value->IdCliente;
        $agrotop->IdClienteSap = $value->IdClienteSap;
        $agrotop->IdFichaTecnica = $value->IdFichaTecnica;
        $agrotop->Observacion = $value->Observacion;
        $agrotop->Pais = $value->Pais;
        $agrotop->PesoTotalPickingTest = $value->PesoTotalPickingTest;
        $agrotop->Producto = $value->Producto;
        $agrotop->Sag = (boolean)$value->Sag;
        $agrotop->Temperatura = $value->Temperatura;
        $agrotop->VerificacionCliente = (boolean)$value->VerificacionCliente;
        $agrotop->Version = $value->Version;
        $agrotop->VidaUtil = $value->VidaUtil;
        $agrotop->id_user = $id_user;
        $agrotop->save();        
        return $agrotop;
    }
}
