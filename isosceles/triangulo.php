<?php
require_once("../classes/TrianguloIsosceles.class.php");
require_once("../classes/Unidade.class.php");

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";

$forma = null;
$lista = TrianguloIsosceles::listar(1, $id);
if (!empty($lista)) {
    $forma = $lista[0];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0; 
    $lado = isset($_POST['lado']) ? $_POST['lado'] : 0; 
    $lado2 = isset($_POST['lado2']) ? $_POST['lado2'] : 0; 
    $unidade = isset($_POST['unidade']) ? $_POST['unidade'] : 0; 
    $cor = isset($_POST['cor']) ? $_POST['cor'] : ""; 
    $acao = isset($_POST['acao']) ? $_POST['acao'] : ""; 

    try {
        $idunidade = UnidadeMedida::listar(1, $unidade)[0];
        $triangulo = new TrianguloIsosceles($id, $lado, $lado2, $idunidade, $cor);

        $resultado = "";

        switch ($acao) {
            case "salvar":
                $resultado = $triangulo->incluir();
                break;
            case "alterar":
                $resultado = $triangulo->alterar();
                break;
            case "excluir":
                $resultado = $triangulo->excluir();
                break;
        }

        if ($resultado)
            header('location: index.php?MSG=Dados inseridos/alterados com sucesso!');
        else
            header('location: index.php?MSG=Erro ao inserir/alterar registro');
    } catch (Exception $e) {
        header('location: index.php?MSG=Erro: ' . $e->getMessage());
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $busca = isset($_GET['busca']) ? $_GET['busca'] : 0;
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;

    $lista = TrianguloIsosceles::listar($tipo, $busca); 
}
?>
