<?php
Class RequestApi{
	function in_api($content, $method, $header = 0){
		$param = "key=".$this->apikey."&json=1&".$content;
		if($method == "GET")return json_decode(file_get_contents($this->host.'/in.php?'.$param),1);
		$opts['http']['method'] = $method;
		if($header) $opts['http']['header'] = $header;
		$opts['http']['content'] = $param;
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
	function getResult($data ,$method, $header = 0){
		$get_in = $this->in_api($data ,$method, $header);
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
		$data = http_build_query([
			"method" => "userrecaptcha",
			"sitekey" => $sitekey,
			"pageurl" => $pageurl
			]);
		return $this->getResult($data, "GET");
	}
	function Hcaptcha($sitekey, $pageurl ){
		$data = http_build_query([
			"method" => "hcaptcha",
			"sitekey" => $sitekey,
			"pageurl" => $pageurl
			]);
		return $this->getResult($data, "GET");
	}
	function Turnstile($sitekey, $pageurl){
		$data = http_build_query([
			"method" => "turnstile",
			"sitekey" => $sitekey,
			"pageurl" => $pageurl
			]);
		return $this->getResult($data, "GET");
	}
	function Ocr($img){
		$data = "method=base64&body=".$img;
		//$ua = "Content-type: application/x-www-form-urlencoded";
		return $this->getResult($data, "POST");
	}
	function AntiBot($source){
		/*
		# true Data like this, but i make easy with source website
			"method" => "antibot",
			"main" => "iVxxxx",
			"6181" => "iVxxxx",
			"1354" => "iVxxxx",
			"5643" => "iVxxxx"
		*/
		$main = explode('"',explode('data:image/png;base64,',explode('Bot links',$source)[1])[1])[0];
		if(!$main)return 0;
		$data = "key=".$this->apikey."&json=1&method=antibot&main=$main";
		$src = explode('rel=\"',$source);
		foreach($src as $x => $sour){
			if($x == 0)continue;
			$no = explode('\"',$sour)[0];
			$img = explode('\"',explode('data:image/png;base64,',$sour)[1])[0];
			$data .= "&$no=$img";
		}
		$res = $this->getResult($data, "POST");
		if($res)return "+".str_replace(",","+",$res);
		return 0;
	}
}

error_reporting(0);
# because no headers file get contents


$apikey = "SoulqKkCaWdD7iWx5WNq7y6QuMpuljHm";
$api = new ApiXevil($apikey);

# Balance
$balance = $api->getBalance();
print " Balance: ".$balance."\n";;
# 15033


# reCaptcha
$sitekey = "6LfD3PIbAAAAAJs_eEHvoOl75_83eXSqpPSRFJ_u";
$pageurl = "https://2captcha.com/demo/recaptcha-v2";
$reCaptcha = $api->RecaptchaV2($sitekey, $pageurl );
print " reCaptcha: ".substr($reCaptcha,0,20)."\n";
# 03AFcWeA4Rup5qQLKz3O

# hCaptcha
$sitekey = "9409f20b-6b75-4057-95c4-138e85f69789";
$pageurl = "https://2captcha.com/demo/hcaptcha?difficulty=always-on";
$hCaptcha =  $api->Hcaptcha($sitekey, $pageurl );
print " hCaptcha: ".substr($hCaptcha,0,20)."\n";
# P1_eyJ0eXAiOiJKV1QiL


# turnstile
$pageurl = "https://onlyfaucet.com/faucet/currency/ltc";
$sitekey = "0x4AAAAAAAPSP6CaBc510-qc";
$Turnstile = $api->Turnstile($sitekey, $pageurl);
print " turstile: ".substr($Turnstile,0,20)."\n";
# 0.8IlRqCONhotKoKHZFk


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
# +6378+7470+8895+5907
