<?php

require __DIR__.'/vendor/autoload.php';


use \App\Entity\Vaga;

//Validacao do ID
if(!isset($_GET['id']) or !is_numeric($_GET['id'])) {
    header('location: index.php?status=error');
    exit;
}

//Consulta de vaga
$obVaga = Vaga::getVaga($_GET['id']);


//Validación de la vaga
if(!$obVaga instanceof Vaga) {
    header('location: index.php?status=error');
    exit;
}

// Imprimir los datos a eliminar
//echo "<pre>"; print_r($obVaga); echo "</pre>"; exit;

//Validación del POST
if(isset($_POST['excluir'])) {
    
    $obVaga->excluir();
    
    header('location: index.php?status=success');
    exit;
    
}

include __DIR__.'/includes/header.php';
include __DIR__.'/includes/confirmar-exclusao.php';
include __DIR__.'/includes/footer.php';


?>