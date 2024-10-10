<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Triângulos Escalenos</title>
    <?php
        include_once('../escaleno/TrianguloEscaleno.php');
        include_once('../classes/TrianguloEscaleno.class.php');  // Incluindo o Triângulo Escaleno
    ?>
</head>

<body>
<a href="../triangulo/index.php"><input type="button" value="Cadastro de Triângulo"></a>
<a href="../quadrado/index.php"><input type="button" value="Cadastro de Quadrado"></a>
<a href="../circulo/index.php"><input type="button" value="Cadastro de Círculo"></a>
<a href="../unidade/index.php"><input type="button" value="Cadastro de Medida"></a><br><br>

    <form action="index.php" method="post">
        <fieldset>
            <legend>Cadastro de Triângulos Escalenos</legend>

            <label for="id">Id:</label>
            <input type="text" name="id" id="id" value="<?= isset($triangulo) ? $triangulo->getId() : 0 ?>" readonly>

            <label for="lado">Tamanho da base:</label>
            <input type="number" name="lado" id="lado" value="<?php if (isset($triangulo)) echo $triangulo->getLado() ?>">

            <label for="lado2">Tamanho do lado 2:</label>
            <input type="number" name="lado2" id="lado2" value="<?php if (isset($triangulo)) echo $triangulo->getLado2() ?>">

            <label for="lado3">Tamanho do lado 3:</label>
            <input type="number" name="lado3" id="lado3" value="<?php if (isset($triangulo)) echo $triangulo->getLado3() ?>">

            <label for="unidade">Unidade:</label>
            <select name="unidade" id="unidade">
            <?php  
                $unidades = UnidadeMedida::listar();
                foreach ($unidades as $unidade) {
                    $str = "<option value='" . $unidade->getIdUnidade() . "'";
                    if (isset($triangulo))
                        if ($triangulo->getIdUnidade()->getIdUnidade() == $unidade->getIdUnidade())
                            $str .= " selected";
                    $str .= ">" . $unidade->getDescricao() . "</option>";
                    echo $str;
                }
            ?>
            </select>

            <label for="cor">Cor:</label>
            <input type="color" name="cor" id="cor" value="<?php if (isset($triangulo)) echo $triangulo->getCor() ?>"><br><br>

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
    <h1>Triângulos Escalenos Cadastrados:</h1>
    <br>
    <table border="1" style="text-align:center">
        <tr>
            <th>Id</th>
            <th>Forma</th>
            <th>Base</th>
            <th>Lado 2</th>
            <th>Lado 3</th>
            <th>Unidade</th>
            <th>Cor</th>
        </tr>
        
        <?php  
            // Listando apenas triângulos escalenos
            $lista = TrianguloEscaleno::listar(); // Remove as condições de busca

            foreach ($lista as $triangulo) {
                echo "<tr>
                        <td><a href='index.php?id=" . $triangulo->getId() . "'>" . $triangulo->getId() . "</a></td>
                        <td>Triângulo Escaleno</td>
                        <td>" . $triangulo->getLado() . "</td>
                        <td>" . $triangulo->getLado2() . "</td>
                        <td>" . $triangulo->getLado3() . "</td>
                        <td>" . $triangulo->getIdUnidade()->getSigla() . "</td>
                        <td style='background-color: " . $triangulo->getCor() . "'></td>
                      </tr>";
                
                // Desenha o triângulo
                echo $triangulo->desenhar();
            }
        ?>
    </table>
</body> 
</html>
