<?php

	$servername = '162.241.3.25';
	$user = 'jdc_santos';
	$pw = '@webservice';
	$db = 'jdc_webservice';

	try{
		$conn = new PDO("mysql:host=$servername;dbname=$db", $user, $pw);
	}catch(Exception $e){
		echo $e->getMessage();
	}