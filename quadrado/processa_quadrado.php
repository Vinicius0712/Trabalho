<?php
require_once("../classes/Quadrado.class.php");

$id =  isset($_GET['id']) ? $_GET['id'] : 0;
if ($id > 0){
    $forma = Quadrado::listar(1, $id)[0];                                    
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id =  isset($_POST['id']) ? $_POST['id'] : 0; 
    $lado =  isset($_POST['lado']) ? $_POST['lado'] : 0;
    $unidade =  isset($_POST['unidade']) ? $_POST['unidade'] : 0; 
    $cor =  isset($_POST['cor']) ? $_POST['cor'] : ""; 
    $acao =  isset($_POST['acao']) ? $_POST['acao'] : ""; 

    try {
        $quadrado = new Quadrado($id, $lado, $unidade, $cor);

        $resultado = "";

        switch($acao) {
            case "salvar":
                $resultado = $quadrado->incluir();
                break;
            case "alterar":
                $resultado = $quadrado->alterar();
                break;
            case "excluir":
                $resultado = $quadrado->excluir();
                break;
        }

        if ($resultado)
            header('location: index.php?MSG=Operação realizada com sucesso!');
        else
            header('location: index.php?MSG=Erro ao realizar a operação');
    } catch(Exception $e) {
        header('location: index.php?MSG=Erro: '.$e->getMessage());
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $busca =  isset($_GET['busca']) ? $_GET['busca'] : 0;
    $tipo =  isset($_GET['tipo']) ? $_GET['tipo'] : 0;
    $lista = Quadrado::listar($tipo, $busca); 
}
?>
