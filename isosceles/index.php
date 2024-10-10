<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Triângulos Isósceles</title>
    <?php
        include_once('../triangulo/triangulo.php');
    ?>
</head>

<body>
<a href="../escaleno/index.php"><input type="button" value="Cadastro de Escaleno"></a>
<a href="../quadrado/index.php"><input type="button" value="Cadastro de Quadrado"></a>
<a href="../circulo/index.php"><input type="button" value="Cadastro de Círculo"></a>
<a href="../unidade/index.php"><input type="button" value="Cadastro de Medida"></a><br><br>

    <form action="index.php" method="post">
        <fieldset>
            <legend>Cadastro de Triângulos Isósceles</legend>

            <label for="id">Id:</label>
            <input type="text" name="id" id="id" value="<?= isset($forma) ? $forma->getId() : 0 ?>" readonly>

            <label for="lado">Tamanho da base:</label>
            <input type="number" name="lado" id="lado" value="<?php if (isset($forma)) echo $forma->getLado() ?>" required>

            <label for="lado2">Tamanho do lado igual:</label>
            <input type="number" name="lado2" id="lado2" value="<?php if (isset($forma)) echo $forma->getLado2() ?>" required>

            <label for="unidade">Unidade:</label>
            <select name="unidade" id="unidade">
            <?php  
                $unidades = UnidadeMedida::listar();
                foreach ($unidades as $unidade) {
                    $str = "<option value='" . $unidade->getIdUnidade() . "'";
                    if (isset($forma))
                        if ($forma->getIdUnidade()->getIdUnidade() == $unidade->getIdUnidade())
                            $str .= " selected";
                    $str .= ">" . $unidade->getDescricao() . "</option>";
                    echo $str;
                }
            ?>
            </select>

            <label for="cor">Cor:</label>
            <input type="color" name="cor" id="cor" value="<?php if (isset($forma)) echo $forma->getCor() ?>"><br><br>

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
                        <td>" . $trianguloIsosceles->getLado() . "</td>
                        <td>" . $trianguloIsosceles->getLado2() . "</td>
                        <td>" . $trianguloIsosceles->getIdUnidade()->getSigla() . "</td>
                        <td style='background-color: " . $trianguloIsosceles->getCor() . "'></td>
                      </tr>";
                
                // Desenha o triângulo isósceles
                echo $trianguloIsosceles->desenhar();
            }
        ?>
    </table>
</body> 
</html>
