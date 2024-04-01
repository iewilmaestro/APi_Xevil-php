# Gas
```php
error_reporting(0);
# because no headers file get contents

$apikey = "APIKEY_XEVIL";
$api = new ApiXevil($apikey);
```

# Balance
```php
$balance = $api->getBalance();
print " Balance: ".$balance."\n";
# 15033
```

# reCaptcha
```php
$sitekey = "6LfD3PIbAAAAAJs_eEHvoOl75_83eXSqpPSRFJ_u";
$pageurl = "https://2captcha.com/demo/recaptcha-v2";
print $api->RecaptchaV2($sitekey, $pageurl );
print " reCaptcha: ".substr($reCaptcha,0,20)."\n";
# 03AFcWeA4Rup5qQLKz3O
```

# hCaptcha
```php
$sitekey = "9409f20b-6b75-4057-95c4-138e85f69789";
$pageurl = "https://2captcha.com/demo/hcaptcha?difficulty=always-on";
$hCaptcha =  $api->Hcaptcha($sitekey, $pageurl );
print " hCaptcha: ".substr($hCaptcha,0,20)."\n";
# P1_eyJ0eXAiOiJKV1QiL
```

# turnstile
```php
$pageurl = "https://onlyfaucet.com/faucet/currency/ltc";
$sitekey = "0x4AAAAAAAPSP6CaBc510-qc";
$Turnstile = $api->Turnstile($sitekey, $pageurl);
print " turstile: ".substr($Turnstile,0,20)."\n";
# 0.8IlRqCONhotKoKHZFk
```

# image Ocr
```php
# image as base64
# Example
$img = base64_encode(file_get_contents("https://nopecha.com/image/demo/textcaptcha/00Ge55.png"));
$Ocr = $api->Ocr($img);
print " ocr: ".$Ocr."\n";
# o0ge55
```

# anti-botlinks
```php
$source = file_get_contents("https://bitonefaucet.com.tr/rsshort/index.php");
$Antibot = $api->AntiBot($source);
print " antibotlink: ".$Antibot."\n";
# +1905+1004+8392+1024
```
