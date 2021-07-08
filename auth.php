<?php
header("Content-type: text/html; charset=utf-8");
$login = $_GET["id"];
$pass = $_GET["pw"];
$API = new Icloud_L($login, $pass);
echo $API->authenticate();
class Icloud_L
{
    public $login = NULL;
    public $pass = NULL;
    public $init = false;
    public $clien_context = array("appName" => "iCloud Find (Web)", "appVersion" => "2.0", "timezone" => "Pacific/Pago_Pago", "inactiveTime" => "0", "apiVersion" => "3.0", "fmly" => true);
    public $server_context = array();
    public function Icloud_L($login, $pass)
    {
        $this->login = $login;
        $this->pass = str_replace(array("+space+"), array(" "), $pass);
    }
    public function authenticate()
    {
        $agent = json_encode(array("app-version" => "4.0", "user-agent" => "FindMyiPhone/472.1 CFNetwork/711.1.12 Darwin/14.0.0"));
        $curl_post_data = json_encode(array("http_code" => "200", "Server" => "AppleHttpServer/e70a1a237a4f", "Content-Type" => "application/json; charset=utf-8", "Accept" => "application/json", "Transfer-Encoding" => "chunked", "Connection" => "keep-alive", "X-Responding-Instance" => "fmipservice:43800401:pv33p38ic-ztbu02164201:8001:1809B80:b12e3a80", "X-Responding-Server" => "pv33p38ic-ztbu02164201_001", "X-Responding-Partition" => "p38", "X-Apple-Loc-Src" => "1", "Vary" => "Accept-Encoding", "Strict-Transport-Security" => "max-age=31536000; includeSubDomains", "Set-Cookie" => "NSC_q38-gnjqtfswjdf=14b5a3d986597351430cb636234f34caabd42eb0268e2e20d071b32c82dfcba64cfe73f2;path=/;secure;httponly", "via" => "icloudedge:sk11p00ic-zteu01032101:7401:18RC204:Stockholm", "X-Apple-Request-UUID" => "adc848cf-d9ac-4679-a604-a6ad43bccfe9", "access-control-expose-headers" => "Via"));
        $service_url = "https://fmipmobile.icloud.com/fmipservice/device/" . $this->login . "/initClient";
        $curl = curl_init($service_url);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, $this->login . ":" . $this->pass);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
        curl_setopt($curl, CURLOPT_USERAGENT, $agent);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $curl_response = curl_exec($curl);
        $response = json_decode($curl_response);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        return $httpcode;
    }
}

?>
