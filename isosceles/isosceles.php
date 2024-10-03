<?php
require_once("../classes/Isosceles.class.php");
require_once("../classes/Unidade.class.php");

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";

$forma = null;
$lista = Isosceles::listar(1, $id);
if (!empty($lista)) {
    $forma = $lista[0];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0; 
    $lado = isset($_POST['lado']) ? $_POST['lado'] : 0; 
    $ladoIgual = isset($_POST['ladoIgual']) ? $_POST['ladoIgual'] : 0; 
    $unidade = isset($_POST['unidade']) ? $_POST['unidade'] : 0; 
    $cor = isset($_POST['cor']) ? $_POST['cor'] : ""; 
    $acao = isset($_POST['acao']) ? $_POST['acao'] : ""; 

    try {
        $idunidade = UnidadeMedida::listar(1, $unidade)[0];
        $isosceles = new Isosceles($id, $lado, $ladoIgual, $idunidade, $cor);

        $resultado = "";

        switch ($acao) {
            case "salvar":
                $resultado = $isosceles->incluir();
                break;
            case "alterar":
                $resultado = $isosceles->alterar();
                break;
            case "excluir":
                $resultado = $isosceles->excluir();
                break;
        }

        if ($resultado)
            header('location: isosceles.php?MSG=Dados inseridos/alterados com sucesso!');
        else
            header('location: isosceles.php?MSG=Erro ao inserir/alterar registro');
    } catch (Exception $e) {
        header('location: isosceles.php?MSG=Erro: ' . $e->getMessage());
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $busca = isset($_GET['busca']) ? $_GET['busca'] : 0;
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;

    $lista = Isosceles::listar($tipo, $busca); 
}
?>
