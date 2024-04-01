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
print " Balance: ".$balance."\n";;
```

# reCaptcha
```php
$sitekey = "6LfD3PIbAAAAAJs_eEHvoOl75_83eXSqpPSRFJ_u";
$pageurl = "https://2captcha.com/demo/recaptcha-v2";
$reCaptcha = $api->RecaptchaV2($sitekey, $pageurl );
print " reCaptcha: ".$reCaptcha."\n";
# 03AFcWeA5dAXT8iT12IArrMsKLGrL2qgcGhPp2ES7BWgtPIa5GxGXorB
```

# hCaptcha 0.0055
```php
$sitekey = "9409f20b-6b75-4057-95c4-138e85f69789";
$pageurl = "https://2captcha.com/demo/hcaptcha?difficulty=always-on";
$hCaptcha =  $api->Hcaptcha($sitekey, $pageurl );
print " hCaptcha: ".$hCaptcha."\n";
// P1_eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.hadwYXNza2V5xQWA4
```

# turnstile
```php
$pageurl = "https://onlyfaucet.com/faucet/currency/ltc";
$sitekey = "0x4AAAAAAAPSP6CaBc510-qc";
$Turnstile = $api->Turnstile($sitekey, $pageurl);
print " turstile: ".$Turnstile."\n";
# 0.5YsJy3i-JlJ7QYJnEVXlf6SH83xu7W125CFG060y
```

# image Ocr
```php
# image as base64
# Example
$img = base64_encode(file_get_contents("https://nopecha.com/image/demo/textcaptcha/00Ge55.png"));
# print $img_source;exit;
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
