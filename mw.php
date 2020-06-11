<?php

function randstr ($len=10, $abc="aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ") {
    $letters = str_split($abc);
    $str = "";
    for ($i=0; $i<=$len; $i++) {
        $str .= $letters[rand(0, count($letters)-1)];
    };
    return $str;
};

function xDe($aa,$bb){
	$t="";
	$y="\$".$bb."=\\'\\';";
	for ($i=0; $i < strlen($aa) ; $i++) { 
		$t = $t . $aa[$i];
		if(($i % 10 == 0) and $i!=0  or (strlen($aa)-1 == $i)){
	 		$var = randstr(rand(1, 4));
			$y = $y . "\$".$var."=\\'".$t."\\';\$".$bb."=\$".$bb." . \$".$var.";";
			$t= "";
		}
	
	}
	return $y;
}

function encrypt($plaintext, $password) {
    $method = "AES-256-CBC";
    $key = hash('sha256', $password, true);
    $iv = openssl_random_pseudo_bytes(16);

    $ciphertext = openssl_encrypt($plaintext, $method, $key, OPENSSL_RAW_DATA, $iv);
    $hash = hash_hmac('sha256', $ciphertext . $iv, $key, true);

    return $iv . $hash . $ciphertext;
}
$a 	=  randstr(rand(5, 30));
$b 	=  randstr(rand(5, 30));
$c 	=  randstr(rand(5, 30));
$d 	=  randstr(rand(5, 30));
$xx = '$'.randstr(rand(5, 30)).'="'.randstr(rand(5, 30)).'";function '.$b.'($ivHashCiphertext,$password){$method="AES-256-CBC";$iv=substr($ivHashCiphertext,0,16);$hash=substr($ivHashCiphertext,16,32);$ciphertext=substr($ivHashCiphertext,48);$key=hash(\'sha256\',$password,true);if(!hash_equals(hash_hmac(\'sha256\',$ciphertext.$iv,$key,true),$hash))return null;return openssl_decrypt($ciphertext,$method,$key,OPENSSL_RAW_DATA,$iv);}';


if (isset($_POST['c0de']) and is_string($_POST['c0de'])) {
	
	$c0de	=	$_POST['c0de'];
	$c0de	=	str_replace("<?php", "", $c0de);
	$c0de	=	str_replace("?>",    "", $c0de);
	$c0de	=	base64_encode(encrypt($c0de,$_POST['pass']));
	$xx = $xx . "\$a=\"\";";
	$xx = $xx . "eval('" . xDe($c0de,"b") . "');";
	$xx = $xx . "\$c=base64_decode(\$b);";
	$xx = $xx . "@eval(".$b."(\$c,@\$_COOKIE['f']));";
	$crypttext	=	"<?php ";
	$crypttext	=	$crypttext . "eval('" . xDe(base64_encode($xx),$a) . "');";
	$crypttext	=	$crypttext . '$'.$c.'="b"."a"."s"."e"."6"."4"."_"."d"."e"."c"."o"."d"."e";';
	$crypttext	=	$crypttext . "\$".$d."=\$".$c."(\$".$a.");";
	$crypttext	=	$crypttext . "@eval(\$".$d.")";
	$crypttext	=	$crypttext . " ?>";
}

?>

<!DOCTYPE html>
<html>
<head>
<title>obs php | t4lha</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
<h2>Encrypt Your PHP c0de | t4lha</h2>
<form method="POST" action="">
<div class="form-group">
<label for="code">Source Code:</label>
<textarea class="form-control" rows="10" id="code" name="c0de"><?php if (isset($crypttext) && $crypttext!="") {echo htmlspecialchars($crypttext);}?></textarea>
</div>
<input type="text" placeholder="PassW0rD" name="pass">
<button type="submit" class="btn btn-primary">Encrypt</button>
</form>
</div> 
</body>
</html>
