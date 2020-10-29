<?php

require __DIR__.'/vendor/autoload.php';

define('TITLE', 'Editar vaga');

use \App\Entity\Vaga;

//Validacao do ID
if(!isset($_GET['id']) or !is_numeric($_GET['id'])) {
    header('location: index.php?status=error');
    exit;
}

//Consulta de vaga
$obVaga = Vaga::getVaga($_GET['id']);
//Probar si carga l avaga con el id seleccionado
//echo "<pre>"; print_r($obVaga); echo "</pre>"; exit;

//Validar si la vaga con el id existe
if(!$obVaga instanceof Vaga) {
    header('location: index.php?status=error');
    exit;
}


//Validacion del POST
if(isset($_POST['titulo'],$_POST['descricao'],$_POST['ativo'])) {
    //$obVaga = new Vaga;
    $obVaga->titulo    = $_POST['titulo'];
    $obVaga->descricao = $_POST['descricao'];
    $obVaga->ativo     = $_POST['ativo'];
    //echo "<pre>"; print_r($obVaga); echo "</pre>"; exit;
    $obVaga->atualizar();
    
    

    header('location: index.php?status=success');
    exit;
    
}

include __DIR__.'/includes/header.php';
include __DIR__.'/includes/formulario.php';
include __DIR__.'/includes/footer.php';


?>