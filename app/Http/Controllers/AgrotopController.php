<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agrotop;
use App\Sacos;
use App\ParametroAnalisis;
use App\ParametroAnalisisPesticida;
use App\ParametroAnalisisMetalesPesados;
use App\ParametroAnalisisMicotoxinas;
use App\ParametroAnalisisMicrobiologia;
use App\ParametroAnalisisNutricionales;
use App\FrecuenciaAnalisis;
use App\ControlVersion;

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
                $this->save_agrotop_sacos_table($value->Sacos,$id_save->id);
                $this->save_agrotop_analisisParametros_table($value->ParametroAnalisis,$id_save->id);
                $this->save_agrotop_analisisParametrosPesticida_table($id_save->id);
                $this->save_agrotop_controlVersion_table($id_save->id);
                $this->save_agrotop_frecuenciaAnalisis_table($id_save->id);
                $this->save_agrotop_analisisParametrosMetalesPesados_table($value->ParametroAnalisisMetalesPesados,$id_save->id);
                $this->save_agrotop_analisisParametrosMicotoxinas_table($value->ParametroAnalisisMicotoxinas,$id_save->id);
                $this->save_agrotop_analisisParametrosMicrobiologia_table($value->ParametroAnalisisMicrobiologia,$id_save->id);
                $this->save_agrotop_analisisParametrosNutricionales_table($value->ParametroAnalisisNutricionales,$id_save->id);               
            }
            return response()->json(['Status' => 'Success', 'Value' =>'Registro guardado con exito']);
            //return response()->json(['Status' => 'Success', 'Value' =>json_decode($request->getBody()->getContents())]);
        }else{
            return response()->json(['Error' => 'Success', 'Value' =>'Problema con la api, codigo de error: '.$request->getStatusCode()]);   
        }        
    }
    public function show(Request $request)
    {
        $agrotop = Agrotop::where('id',$request->route('id'))->first();
        $agrotop['Sacos'] = Sacos::where('id_agrotop',$request->route('id'))->get();
        $agrotop['ParametroAnalisisPesticida'] = ParametroAnalisisPesticida::where('id_agrotop',$request->route('id'))->get();
        $agrotop['ParametroAnalisisMetalesPesados'] = ParametroAnalisisMetalesPesados::where('id_agrotop',$request->route('id'))->get();
        $agrotop['ParametroAnalisis'] = ParametroAnalisis::where('id_agrotop',$request->route('id'))->get();
        $agrotop['ParametroAnalisisMicotoxinas'] = ParametroAnalisisMicotoxinas::where('id_agrotop',$request->route('id'))->get();
        $agrotop['ParametroAnalisisMicrobiologia'] = ParametroAnalisisMicrobiologia::where('id_agrotop',$request->route('id'))->get();
        $agrotop['ParametroAnalisisNutricionales'] = ParametroAnalisisNutricionales::where('id_agrotop',$request->route('id'))->get();
        $agrotop['FrecuenciaAnalisis'] = FrecuenciaAnalisis::where('id_agrotop',$request->route('id'))->get();
        $agrotop['ControlVersion'] = ControlVersion::where('id_agrotop',$request->route('id'))->get();
        return response()->json($agrotop);
    }
    public function show_all(Request $request)
    {
        $agrotop = Agrotop::all();
        foreach ($agrotop as $key => $value) {
            $agrotop[$key]['Sacos'] = Sacos::where('id_agrotop',$value['id'])->get();
            $agrotop[$key]['ParametroAnalisisPesticida'] = ParametroAnalisisPesticida::where('id_agrotop',$value['id'])->get();
            $agrotop[$key]['ParametroAnalisisMetalesPesados'] = ParametroAnalisisMetalesPesados::where('id_agrotop',$value['id'])->get();
            $agrotop[$key]['ParametroAnalisis'] = ParametroAnalisis::where('id_agrotop',$value['id'])->get();
            $agrotop[$key]['ParametroAnalisisMicotoxinas'] = ParametroAnalisisMicotoxinas::where('id_agrotop',$value['id'])->get();
            $agrotop[$key]['ParametroAnalisisMicrobiologia'] = ParametroAnalisisMicrobiologia::where('id_agrotop',$value['id'])->get();
            $agrotop[$key]['ParametroAnalisisNutricionales'] = ParametroAnalisisNutricionales::where('id_agrotop',$value['id'])->get();
            $agrotop[$key]['FrecuenciaAnalisis'] = FrecuenciaAnalisis::where('id_agrotop',$value['id'])->get();
            $agrotop[$key]['ControlVersion'] = ControlVersion::where('id_agrotop',$value['id'])->get();
        }        
        return response()->json($agrotop);
    }
    public function destroy(Request $request)
    {
        $agrotop  = new Agrotop;
        $agrotop->destroy($request->route('id'));
        return response()->json(['Status' => 'Success', 'Value' => 'Registro Eliminado']);        
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
    private function save_agrotop_sacos_table($sacos,$id_agrotop){
        foreach ($sacos as $key => $value) {
            $sacos = new Sacos;
            $sacos->ColorHilo = $value->ColorHilo;
            $sacos->Descripcion = $value->Descripcion;
            $sacos->IdSaco = $value->IdSaco;
            $sacos->Nombre = $value->Nombre;
            $sacos->Peso = $value->Peso;
            $sacos->id_agrotop = $id_agrotop;
            $sacos->save();
        }
    }
    private function save_agrotop_analisisParametros_table($parametroAnalisis,$id_agrotop){
        foreach ($parametroAnalisis as $key => $value) {
            $parametroAnalisis = new ParametroAnalisis;
            $parametroAnalisis->IdParametroAnalisis = $value->IdParametroAnalisis;
            $parametroAnalisis->MaxValidValue = $value->MaxValidValue;
            $parametroAnalisis->MinValidValue = $value->MinValidValue;
            $parametroAnalisis->Nombre = $value->Nombre;
            $parametroAnalisis->Nombre_en = $value->Nombre_en;
            $parametroAnalisis->UM = $value->UM;
            $parametroAnalisis->UM_en = $value->UM_en;
            $parametroAnalisis->id_agrotop = $id_agrotop;
            $parametroAnalisis->save();
        }
    }
    private function save_agrotop_analisisParametrosPesticida_table($id_agrotop){
        $parametroAnalisisPesticida = new ParametroAnalisisPesticida;
        $parametroAnalisisPesticida->id_agrotop = $id_agrotop;
        $parametroAnalisisPesticida->save();
    }
    private function save_agrotop_controlVersion_table($id_agrotop){
        $parametroAnalisisPesticida = new ControlVersion;
        $parametroAnalisisPesticida->id_agrotop = $id_agrotop;
        $parametroAnalisisPesticida->save();
    }
    private function save_agrotop_frecuenciaAnalisis_table($id_agrotop){
        $parametroAnalisisPesticida = new FrecuenciaAnalisis;
        $parametroAnalisisPesticida->id_agrotop = $id_agrotop;
        $parametroAnalisisPesticida->save();
    }
    private function save_agrotop_analisisParametrosMetalesPesados_table($parametroAnalisisMetalesPesados,$id_agrotop){
        foreach ($parametroAnalisisMetalesPesados as $key => $value) {
            $parametroAnalisisMetalesPesados = new ParametroAnalisisMetalesPesados;
            $parametroAnalisisMetalesPesados->MaxValidValue = $value->MaxValidValue;
            $parametroAnalisisMetalesPesados->MinValidValue = $value->MinValidValue;
            $parametroAnalisisMetalesPesados->Nombre = $value->Nombre;
            $parametroAnalisisMetalesPesados->Nombre_en = $value->Nombre_en;
            $parametroAnalisisMetalesPesados->UM = $value->UM;
            $parametroAnalisisMetalesPesados->UM_en = $value->UM_en;
            $parametroAnalisisMetalesPesados->id_agrotop = $id_agrotop;
            $parametroAnalisisMetalesPesados->save();
        }
    }
    private function save_agrotop_analisisParametrosMicotoxinas_table($parametroAnalisisMetalesPesados,$id_agrotop){
        foreach ($parametroAnalisisMetalesPesados as $key => $value) {
            $parametroAnalisisMetalesPesados = new ParametroAnalisisMicotoxinas;
            $parametroAnalisisMetalesPesados->MaxValidValue = $value->MaxValidValue;
            $parametroAnalisisMetalesPesados->MinValidValue = $value->MinValidValue;
            $parametroAnalisisMetalesPesados->Nombre = $value->Nombre;
            $parametroAnalisisMetalesPesados->Nombre_en = $value->Nombre_en;
            $parametroAnalisisMetalesPesados->UM = $value->UM;
            $parametroAnalisisMetalesPesados->UM_en = $value->UM_en;
            $parametroAnalisisMetalesPesados->id_agrotop = $id_agrotop;
            $parametroAnalisisMetalesPesados->save();
        }
    }
    private function save_agrotop_analisisParametrosMicrobiologia_table($parametroAnalisisMetalesPesados,$id_agrotop){
        foreach ($parametroAnalisisMetalesPesados as $key => $value) {
            $parametroAnalisisMetalesPesados = new ParametroAnalisisMicrobiologia;
            $parametroAnalisisMetalesPesados->MaxValidValue = $value->MaxValidValue;
            $parametroAnalisisMetalesPesados->MinValidValue = $value->MinValidValue;
            $parametroAnalisisMetalesPesados->Nombre = $value->Nombre;
            $parametroAnalisisMetalesPesados->Nombre_en = $value->Nombre_en;
            $parametroAnalisisMetalesPesados->UM = $value->UM;
            $parametroAnalisisMetalesPesados->UM_en = $value->UM_en;
            $parametroAnalisisMetalesPesados->id_agrotop = $id_agrotop;
            $parametroAnalisisMetalesPesados->save();
        }
    }
    private function save_agrotop_analisisParametrosNutricionales_table($parametroAnalisisMetalesPesados,$id_agrotop){
        foreach ($parametroAnalisisMetalesPesados as $key => $value) {
            $parametroAnalisisMetalesPesados = new ParametroAnalisisNutricionales;
            $parametroAnalisisMetalesPesados->MaxValidValue = $value->MaxValidValue;
            $parametroAnalisisMetalesPesados->MinValidValue = $value->MinValidValue;
            $parametroAnalisisMetalesPesados->Nombre = $value->Nombre;
            $parametroAnalisisMetalesPesados->Nombre_en = $value->Nombre_en;
            $parametroAnalisisMetalesPesados->UM = $value->UM;
            $parametroAnalisisMetalesPesados->UM_en = $value->UM_en;
            $parametroAnalisisMetalesPesados->id_agrotop = $id_agrotop;
            $parametroAnalisisMetalesPesados->save();
        }
    }
}
