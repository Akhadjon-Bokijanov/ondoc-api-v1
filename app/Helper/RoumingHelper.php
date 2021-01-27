<?php


namespace App\Helper;

class RoumingHelper extends BaseHelper
{
    public static function getNdsCode($tin,$key='all'){
        $opts = array(
            'http' => array(
                'method' => "GET",
                'header' => "Authorization: Basic " . base64_encode("onlinefactura:9826315157e93a13e05$")
            ),
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $context = stream_context_create($opts);

        $url = self::SOLIQ_HOST."/services/nds/reference?tin=".$tin;
        if($key=="all"){
            return file_get_contents($url, false, $context);
        } else{
            $result = [
                'error'=>"",
                'result'=>""
            ];
            $data = file_get_contents($url, false, $context);
            $data = json_decode((string) $data, true);
            $result['success'] = $data['success'];
            if($data['success']==true){
                $data = $data['data'];
                if(isset($data[$key])) {
                    $result['result'] = $data[$key];
                } else{
                    $result['error']="NDS:Bunday formatli malumot mavjud emas";
                }
            } else {
                $result['error'] = "NDS:Malumot yetib kelmadi";
            }
            return $result;
        }
    }


    public static function getFacturaID(){
        $opts = array(
            'http' => array(
                'method' => "GET",
                'header' => "Authorization: Basic " . base64_encode(env("ROUMING_USERNAME").":".env("ROUMING_PASSWORD"))
            ),
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $context = stream_context_create($opts);
        $url =  self::FACTURA_HOST."/provider/api/ru/utils/guid";
        $res = file_get_contents($url, false, $context);
        $id="";
        $res = json_decode((string) $res, true);

        if($res['success']){
            $id = $res['data'];
        }

        return $id;
    }
}
