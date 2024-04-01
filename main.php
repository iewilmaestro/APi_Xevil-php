<?php
Class RequestApi {
	function in_api($data, $method = "POST"){
		$data =  "key=".$this->apikey."&json=1&".$data;
		if($method == "GET")return json_decode(file_get_contents($this->host.'/in.php?'.$data),1);
		$opts = ['http' =>['method'  => 'POST','content' => $data]];
		return json_decode(file_get_contents($this->host.'/in.php', false, stream_context_create($opts)),1);
	}
	function res_api($api_id){
		$params = "?key=".$this->apikey."&action=get&id=".$api_id."&json=1";
		return json_decode(file_get_contents($this->host."/res.php".$params),1);
	}
	function getBalance(){
		$res =  json_decode(file_get_contents($this->host."/res.php?action=userinfo&key=".$this->apikey),1);
		return $res["balance"];
	}
	function wait($tmr){
		$sym = [' ─ ',' / ',' │ ',' \ ',];
		$timr = time()+$tmr;$a = 0;
		while(1){
			$res=$timr-time();
			if(!$res)break;
			print " bypass".$sym[$a % 4]." \r";
			usleep(100000);
			$a++;
		}
	}
	function getResult($data ,$method = 0){
		$get_in = $this->in_api($data ,$method);
		if(!$get_in["status"]){
			print $get_in["request"]."\n";
			return 0;
		}
		while(true){
			echo " bypass |   \r";
			$get_res = $this->res_api($get_in["request"]);
			if($get_res["request"] == "CAPCHA_NOT_READY"){
				echo " bypass ─ \r";
				$this->wait(10);
				continue;
			}
			if($get_res["status"])return $get_res["request"];
			return 0;
		}
	}
}
Class ApiXevil extends RequestApi {
	public $apikey;
	
	function __construct($apikey){
		$this->host = "https://sctg.xyz";
		$this->apikey = $apikey;
	}
	function RecaptchaV2($sitekey, $pageurl){
		$data = "method=userrecaptcha&sitekey=$sitekey&pageurl=$pageurl";
		return $this->getResult($data);
	}
	function Hcaptcha($sitekey, $pageurl ){
		$data = "method=hcaptcha&sitekey=$sitekey&pageurl=$pageurl";
		return $this->getResult($data);
	}
	function Turnstile($sitekey, $pageurl){
		$data = "method=turnstile&sitekey=".$sitekey."&pageurl=".$pageurl;
		return $this->getResult($data, "GET");
	}
	function Ocr($img){
		$data = "method=base64&body=".trim(str_replace('data:image/png;base64,','',$img));
		return $this->getResult($data);
	}
	function AntiBot($source){
		$main = explode('"',explode('data:image/png;base64,',explode('Bot links',$source)[1])[1])[0];
		if(!$main)return 0;
		$data = "method=antibot&main=$main";
		$src = explode('rel=\"',$source);
		foreach($src as $x => $sour){
			if($x == 0)continue;
			$no = explode('\"',$sour)[0];
			$img = explode('\"',explode('data:image/png;base64,',$sour)[1])[0];
			$data .= "&$no=$img";
		}
		$r = $this->getResult($data);
		if($r)return "+".str_replace(",","+",$r);
		return 0;
	}
}

# 31 Mar 2024
# https://t.me/Xevil_check_bot?start=1204538927
# free 5 ruble

error_reporting(0);
# because no headers file get contents

$apikey = "APIKEY_XEVIL";
$api = new ApiXevil($apikey);

# Balance
$balance = $api->getBalance();
print " Balance: ".$balance."\n";;
# 4.8925

# reCaptcha
$sitekey = "6LfD3PIbAAAAAJs_eEHvoOl75_83eXSqpPSRFJ_u";
$pageurl = "https://2captcha.com/demo/recaptcha-v2";
$reCaptcha = $api->RecaptchaV2($sitekey, $pageurl );
print " reCaptcha: ".$reCaptcha."\n";
# 03AFcWeA5dAXT8iT12IArrMsKLGrL2qgcGhPp2ES7BWgtPIa5GxGXorB

# hCaptcha 0.0055
$sitekey = "9409f20b-6b75-4057-95c4-138e85f69789";
$pageurl = "https://2captcha.com/demo/hcaptcha?difficulty=always-on";
$hCaptcha =  $api->Hcaptcha($sitekey, $pageurl );
print " hCaptcha: ".$hCaptcha."\n";
// P1_eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.hadwYXNza2V5xQWA4


# turnstile
$pageurl = "https://onlyfaucet.com/faucet/currency/ltc";
$sitekey = "0x4AAAAAAAPSP6CaBc510-qc";
$Turnstile = $api->Turnstile($sitekey, $pageurl);
print " turstile: ".$Turnstile."\n";
# 0.5YsJy3i-JlJ7QYJnEVXlf6SH83xu7W125CFG060y


# image Ocr
# image as base64
$img = base64_encode(file_get_contents("https://nopecha.com/image/demo/textcaptcha/00Ge55.png"));
$Ocr = $api->Ocr($img);
print " ocr: ".$Ocr."\n";
# o0ge55


# anti-botlinks 
$source = file_get_contents("https://bitonefaucet.com.tr/rsshort/index.php");
$Antibot = $api->AntiBot($source);
print " antibotlink: ".$Antibot."\n";
# +1905+1004+8392+1024
