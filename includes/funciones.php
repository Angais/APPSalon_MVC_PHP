<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function esUltimo(string $actual, string $proximo) : bool{
    if($actual != $proximo){
        return true;
    }
    else{
        return false;
    }
}

// Revisar si el Usuario está Autenticado
function isAuth() : void {
    if(!isset($_SESSION["login"])){
        header("Location: /");
    }
}

// Revisar si el Usuario es Admin
function isAdmin() : void {
    if(!isset($_SESSION["admin"])){
        header("Location: /");
    }
}