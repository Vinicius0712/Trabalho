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
    $base = isset($_POST['base']) ? $_POST['base'] : 0; 
    $ladoIgual = isset($_POST['ladoIgual']) ? $_POST['ladoIgual'] : 0; 
    $unidade = isset($_POST['unidade']) ? $_POST['unidade'] : 0; 
    $cor = isset($_POST['cor']) ? $_POST['cor'] : ""; 
    $acao = isset($_POST['acao']) ? $_POST['acao'] : ""; 

    try {
        $idunidade = UnidadeMedida::listar(1, $unidade)[0];
        $isosceles = new Isosceles($id, $base, $ladoIgual, $idunidade, $cor);

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
            header('location: index.php?MSG=Dados inseridos/alterados com sucesso!');
        else
            header('location: index.php?MSG=Erro ao inserir/alterar registro');
    } catch (Exception $e) {
        header('location: index.php?MSG=Erro: ' . $e->getMessage());
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $busca = isset($_GET['busca']) ? $_GET['busca'] : 0;
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;

    $lista = Isosceles::listar($tipo, $busca); 
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Triângulos Isósceles</title>
</head>

<body>
<a href="../triangulo/index.php"><input type="button" value="Cadastro de Triângulo Equilátero"></a>
<a href="../quadrado/index.php"><input type="button" value="Cadastro de Quadrado"></a>
<a href="../circulo/index.php"><input type="button" value="Cadastro de Círculo"></a><br><br>

    <form action="index.php" method="post">
        <fieldset>
            <legend>Cadastro de Triângulos Isósceles</legend>

            <label for="id">Id:</label>
            <input type="text" name="id" id="id" value="<?= isset($forma) ? $forma->getId() : 0 ?>" readonly>

            <label for="base">Tamanho da base:</label>
            <input type="number" name="base" id="base" value="<?= isset($forma) ? $forma->getBase() : '' ?>">

            <label for="ladoIgual">Tamanho dos lados iguais:</label>
            <input type="number" name="ladoIgual" id="ladoIgual" value="<?= isset($forma) ? $forma->getLadoIgual() : '' ?>">

            <label for="unidade">Unidade:</label>
            <select name="unidade" id="unidade">
            <?php  
                $unidades = UnidadeMedida::listar();
                foreach ($unidades as $unidade) {
                    $str = "<option value='" . $unidade->getIdUnidade() . "'";
                    if (isset($forma) && $forma->getIdUnidade()->getIdUnidade() == $unidade->getIdUnidade())
                        $str .= " selected";
                    $str .= ">" . $unidade->getDescricao() . "</option>";
                    echo $str;
                }
            ?>
            </select>

            <label for="cor">Cor:</label>
            <input type="color" name="cor" id="cor" value="<?= isset($forma) ? $forma->getCor() : '#000000' ?>"><br><br>

            <button type='submit' name='acao' value='salvar'>Salvar</button>
            <button type='submit' name='acao' value='excluir'>Excluir</button>
            <button type='submit' name='acao' value='alterar'>Alterar</button>

        </fieldset>
    </form>

    <form action="" method="get">
        <fieldset>
            <legend>Pesquisar</legend>

            <label for="busca">Busca:</label>
            <input type="text" name="busca" id="busca" value="" placeholder="Pesquisar"><br><br>

            <label for="tipo">Tipo:</label>
            <select name="tipo" id="tipo">
                <option value="0">Selecione</option>
                <option value="1">Id</option>
                <option value="2">Base</option>
            </select>

            <button type='submit'>Buscar</button>
        </fieldset>
    </form>

    <br>
    <h1>Triângulos Isósceles Cadastrados:</h1>
    <br>
    <table border="1" style="text-align:center">
        <tr>
            <th>Id</th>
            <th>Forma</th>
            <th>Base</th>
            <th>Lado Igual</th>
            <th>Unidade</th>
            <th>Cor</th>
        </tr>
        
        <?php  
            foreach ($lista as $trianguloIsosceles) {
                echo "<tr>
                        <td><a href='index.php?id=" . $trianguloIsosceles->getId() . "'>" . $trianguloIsosceles->getId() . "</a></td>
                        <td>Triângulo Isósceles</td>
                        <td>" . $trianguloIsosceles->getBase() . "</td>
                        <td>" . $trianguloIsosceles->getLadoIgual() . "</td>
                        <td>" . $trianguloIsosceles->getIdUnidade()->getSigla() . "</td>
                        <td style='background-color: " . $trianguloIsosceles->getCor() . "'></td>
                      </tr>";
                
                // Desenha o triângulo
                echo $trianguloIsosceles->desenhar();
            }
        ?>
    </table>
</body> 
</html>
