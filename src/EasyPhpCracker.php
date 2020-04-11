#!/usr/bin/php
<?php

	function testHash($HASH,$palabra,$CRACKTHIS){

		switch($HASH){
			
			case "MD5":
			case "SHA1":
			case "SHA256":
			case "SHA512":

				$TESTHASH=openssl_digest($palabra,$HASH);

				break;

			default:

				die();
				break;

			}

			if($TESTHASH == strtolower($CRACKTHIS)){
				echo $palabra."\n";
				die();
			}

	}

	$FIRSTCHAR='0';
	$LASTCHAR='z';

	$maxleng=6;
	$leng=1;

	$HASH="MD5";

	$I=1;

	while($I < count($_SERVER['argv'])){

		if($_SERVER['argv'][$I][0] != "-"){

			if(isset($CRACKTHIS)){

				die();

			}

			$CRACKTHIS=$_SERVER['argv'][$I];

		} else {

			if($_SERVER['argv'][$I][1] == "l"){

				$I=$I+1;

				$maxleng=$_SERVER['argv'][$I];

			} else if($_SERVER['argv'][$I][1] == "i"){

				$I=$I+1;

				$leng=$_SERVER['argv'][$I];


			} else if($_SERVER['argv'][$I][1] == "h"){

				$I=$I+1;

				$HASH=strtoupper($_SERVER['argv'][$I]);

			} else if($_SERVER['argv'][$I][1] == "d"){

				$I=$I+1;

				$DICTIONARY=$_SERVER['argv'][$I];

			}

		}

		$I=$I+1;

	}

	if($I == 1){

		die();

	}

	if(!isset($DICTIONARY)){

		while($leng <= $maxleng){

			$I=0;

			while($I < $leng){

				$palabra_arr[$I]=ord($FIRSTCHAR);

				$I=$I+1;

			}

			while($palabra_arr[$leng-1] < ord($LASTCHAR)){

				$I=0;
				$palabra="";

				while($I < $leng){

					$palabra=$palabra.chr($palabra_arr[$I]);

					$I=$I+1;

				}

				testHash($HASH,$palabra,$CRACKTHIS);

				$I=0;

				while($I < $leng && $palabra_arr[$I]==ord($LASTCHAR)){

					$palabra_arr[$I]=ord($FIRSTCHAR);

					$I=$I+1;

				}

				$palabra_arr[$I]=$palabra_arr[$I]+1;

			}

			$leng=$leng+1;

		}

	} else {

		$f = fopen($DICTIONARY,"r");

		if(isset($f)){

			while($palabra = fgets($f)){

				$palabra=trim($palabra);

				testHash($HASH,$palabra,$CRACKTHIS);

			}

		}

	}

?>
