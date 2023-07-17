<?php 
include("user_interface/cabecalho.php");

// .'isset' - função php em que neste contexto confere se a variável 'p' é nula ou não. 
// .Retorna 'true' se a variável 'p' existe, caso contrário retorna 'false'.
if(isset($_GET['p'])){
    $pag = $_GET['p'];
    
    if($pag == 'polaridade')
        include ("content/polaridade.php");
    else if($pag == 'estatisticas')
        include ("content/estatisticas.php");
    else
        include ("content/paginainicial.php");
}else{
    include ("content/paginainicial.php");
}

include("user_interface/rodape.php");
?>