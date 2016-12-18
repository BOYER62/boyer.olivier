<?php
	try{
		$bddf = new PDO('mysql:host=localhost;dbname=utilisateurs;charset=utf8','root','');
		$bddf->exec('set names utf8');
		$bddf->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	}catch(Exception $e){
		die('Erreur: '.$e->getMessage());
	}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

