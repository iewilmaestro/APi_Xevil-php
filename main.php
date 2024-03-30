<?php

Class XevilRequest {
	public $host;
	public $apikey;
	
	function __construct($host, $apikey){
		$this->host = "https://sctg.xyz";
		$this->apikey = $apikey;
	}
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

# https://t.me/Xevil_check_bot?start=1204538927
# free 5 ruble

$apikey = "APIKEY_XEVIL";
$api = new XevilRequest($apikey);


#Balance
$balance = $api->getBalance();
print " Balance: ".$balance."\n";;
//4.8925


#hCaptcha 0.0055
$sitekey = "9409f20b-6b75-4057-95c4-138e85f69789";
$pageurl = "https://2captcha.com/demo/hcaptcha?difficulty=always-on";
$data = "method=hcaptcha&sitekey=$sitekey&pageurl=$pageurl";
$hCaptcha =  $api->getResult($data);
print " hCaptcha: ".$hCaptcha."\n";
//P1_eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.hadwYXNza2V5xQWA4jVt_rlLvBWHO_WRj4AFm6tzFtRSYutzUBNilgUwf1gV5XBIijkKcaipw_KU5chmIMmHQmUyTY8GVFP7rKESX50pYVdWT403uBCchxHE3bgzfle-VY_RESlW5FbYoivybjplK-LcDbZNN6BV6Dm3b6XlAB5W7Ffqy_OXdxlwLY6EagkWo_AB5gSj_rMHHaScHleyZvQhEiuJqy6YMJwLfCHYJdqHKJ1FOPNgT-zNSv6kcbBGKwTdJ-WD8AfTBOvdAfT5BfodUapR944kF8M-00ZkiHgRnL1wItleHYs6r19ov5vVXiR4fcHb2jfiCjozkEZ16IzsGZavO5RuMlWUdxZ9c7Sd9NtC-GEL27PlmeR_avGqRTb-hTmSP_6rhLOdc7O2AIT05G3m9LMbWOv3GCHTjteq0-Ej17aQcS6H5Cll1JFAFe6zu7ykcgN9-8Nr8wKJgh0qDxFLnQMrI_FQo1veBJFyjLnxcomsILmRXBzbPL1ipb-l7Uc4Zc-ZcX5YqnAFNWaXnLSuvDc6mhqQUEJ0t_fIVCv_IwY536z1YRebNcuBe6HwiqREE5SAAMxOdqXLVrYQgPXkm5PUF1D9MSx9b0wZJPrKrW6IQ2wwPpLceh5asVz7OfyW5F6iLMZ1DoeXsH6Q7o3_-1FV9xM4JMRRwOc7BwHCHWLnKSQUYwfIUkLC0jeYpAx-RPrZi8IngDgJ42kbivFj2N9ldFM6uSwZ3QU03NX3DwwCHkbIk0nKIBJGcmPB6dpLrUd7YwLMb0WGM-uu9TW9hho9CqU-DdV13nPTQMTt1Zrk4sRYuJR35BK9wlyB_sU_dO_qMse3kaaVtBhOkmTTvFEw6fdYu52-0xltxjWkQc2ssOtTstvIfN4-lD5xPAghzVbLWGTwHuoeKr8aC1RCj9aG_DZubsJDmP8y8nTIPQ6DtlQ4SuLouJR1ptQB2mvkja5KXdgs_wh_8mTWh_7OIPpONTW2eQl_IFscp-yNdETu3PyaI_zgmhXpScNIEIOblmjb5_QUEWFZYIVkXRB-pWPwVOZuBor4Ax8cgV_E8rK9t_dVU03wOeRDK8W9oqI4JkSUzoUPeUQ2fSUw1xvwI4qZgsthM1awGAI8P77SDPUCjcGFxD0QLkbGqef-te1Bi2sn682yCBvWd0nRgAWlsa1OcI54lZ_4j6As_eEqBK738mrRDPc90EsS-aRGRf1qxh3ySfWS876wcrt4AGDpBvTy0yUIXgMNiz2W5PKuUz7ifiyjFyCL-gtKlwcHEPKGh8RnEUwg8zOwE--8X-M3Rgx8ub-OWvgJU2ngmVYDdzNKK0-gojJGTzTYFSl5PGhOi5XXG-tlLA_NoJ9DDIxQY65yJ7Oxz04Ebt8Hb875dMIxIdUpR7ehG8msPL8Gg3ZSfPHgX5mNr9YAB6FXDVS7pqttXRbgEyLZBbW69hhrmnvUgI9rec2JgwTC-uoLKl2651mESMpAD1VTdrPAEOIsF2khRvY3uveSS2NTE0xZdjJPQgRzVn7cEHU2F0u0tfqo9c2VV3wr9hea6_FTLPYjXgVa7nq4mg9jCUnLQdjAcX1RyOj1gtM657mz0-cZa8JlP5CpOeggSlXgvqDJNRO8pyeR_AgtsN2GRUs3eX98l5yeGogLyANpsJuDIQQ7hHRQ3Pabw8NMr-Fmuv_bpuAaaQpDOsmP8ojNW_RRFPuZuZWTUZ8WeoJE-Kgs1UhTNTvU0asvX08fAdIMtDniTgJKlqL8V620IygghYRCcsvwPia75enL0_3zJcmse8AejlNVkJiFvaBcMY4rgzf9gSA4YISDh67qAXlr2vh767wm6itHkNL176woEUchbKnzh8NNTOIaGwEjTWqNwlg3qVeYnMfDxpKueaNleHDOZghIZqhzaGFyZF9pZM4UPIQfomtyqDIzMzFhYzY3onBkAA.IewuNoZnYCDnjU3VY3gYiIWfajx07-jt8AzLIKuA1dw


#reCaptcha
$sitekey = "6LfD3PIbAAAAAJs_eEHvoOl75_83eXSqpPSRFJ_u";
$pageurl = "https://2captcha.com/demo/recaptcha-v2";
$data = "method=userrecaptcha&sitekey=$sitekey&pageurl=$pageurl";
$reCaptcha = $api->getResult($data);
print " reCaptcha: ".$reCaptcha."\n";
#03AFcWeA5dAXT8iT12IArrMsKLGrL2qgcGhPp2ES7BWgtPIa5GxGXorBMO_zFMCdLINWqw9gnPMJKBE3Lib7caMnxriSn7Eu7AHXKzAaZ28dnUMIAj46-4n7Ppy47pGLcNBOYgAoiWn9tHQYJmcxE5IHYPtjRLEqSw9evmyuCiWZjYUkvMisVTIljf7UAC4gRdjJfAHm9MXPpxnx-ZKIRCJWhgepecg_PV8-GWMEtCB-ulpX-QqM_1xQVLovBXfeY6wRMA15x3ooJu5ICGdtlA4nBPQ6WMRSzkiHst22srqxVaedsaDA50ZsVCnrQauMzMZjrR2-qInb69-eNlTcZ2wHB008jsw3vPYj0XgmnSL_xpraq4CTJTqA-h2-y3aP8OlpgI8hUdZoJKmsQ_lfwF3JXuPprRlxZ205aoxAXw6vObwCXaTwprcYVhrl47Fd1aB_UOWRktRYkEdFFjzz1sq2pAAnDG5rRwpHM8c-fMsNI-X9rOfrwRIkoXvDmkF_nCNO7AXJEre-PaEA9okLpXo8Omybtj-S-Eb4DQ9SU17MgG0bONo9KTxmIcSpMT3wUlmP18s_pHzY9U6qnpUgDpk4rJ8loME6NPBZIl9oMwsIjM8mAbBa5zY6m7lMVHl8F3tZd4NhNvdq3Gx_F4DRuq6KHdKgQYHkSFXELMcH_mb54OySYKTMbBhASebWGcerKWRQWe1n3vMRTVBIUOxGqdRGMK6Cxubqo0YVv0wX_wYAMLEiQ1LWpw_8lTmCohXc66jpkcG6zNS4a4TnylHFyN771_Jd2B0YIhHw


# turnstile
$pageurl = "https://onlyfaucet.com/faucet/currency/ltc";
$sitekey = "0x4AAAAAAAPSP6CaBc510-qc";
$data = "method=turnstile&sitekey=".$sitekey."&pageurl=".$pageurl;
$Turnstile = $api->getResult($data, "GET");
print " turstile: ".$Turnstile."\n";
#0.5YsJy3i-JlJ7QYJnEVXlf6SH83xu7W125CFG060y


# image Ocr
# image as base64
//Example
$img_source = base64_encode(file_get_contents("https://nopecha.com/image/demo/textcaptcha/00Ge55.png"));
//print $img_source;exit;
# data Ocr xevil
$data = "method=base64&body=".$img_source;
$Ocr = $api->getResult($data);
print " ocr: ".$Ocr."\n";
#o0ge55


# anti-botlinks 
$source = file_get_contents("https://bitonefaucet.com.tr/rsshort/index.php");
$main = explode('"',explode('data:image/png;base64,',explode('Bot links',$source)[1])[1])[0];
$data = "method=antibot&main=$main";
$src = explode('rel=\"',$source);
foreach($src as $x => $sour){
	if($x == 0)continue;
	$no = explode('\"',$sour)[0];
	$img = explode('\"',explode('data:image/png;base64,',$sour)[1])[0];
	$data .= "&$no=$img";
}
//method=antibot
//main=base64img
//1130=base64img x 3 or 4
//print $data;
$Antibot = $api->getResult($data);
print " antibotlink: ".$Antibot."\n";
#1905,1004,8392,1024
