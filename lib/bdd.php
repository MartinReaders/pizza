<?php

//fichers de la connexion a la base de donnes
//Ouverture, type de requette query ,select



function BDDopen(){
    //ouverture la base de donnes
    
    global $bdd;
    
    if(!isset($bdd)){
        include 'lib/bdd_connect.inc';
        $bdd = new PDO("mysql:host=$db_host; dbname=$db_name;charset=UTF8", $db_user, $db_pass);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
    return $bdd;
}

function BDDselect($sql, $param){
    //requette de type select
    $bdd = BDDopen();
    $req = $bdd->prepare($sql);
    if($req->execute($param) === FALSE){
        echo 'Errore de la requette';
        print_r($param);
    }
    return $req;
}


function BDDquery($sql, $param){
    //Requette de type query
    $bdd = BDDopen();
    $req = $bdd->prepare($sql);
    if($req->execute($param) == false){
        echo 'Error de la requette ';
        print_r($param);
        return -1;
    }
    return $req->rowCount();
}


function BDDlastId(){
    $bdd = BDDopen();
    return $bdd->lastInsertId();
}