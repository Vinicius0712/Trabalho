<?php
require_once("Forma.class.php");

class TrianguloIsosceles extends Forma {

    private $lado2; // Lado igual ao lado da base

    public function __construct($id = 0, $lado1 = 0, $lado2 = 0, ?UnidadeMedida $id_unidade = null, $cor = "null") {
        parent::__construct($id, $lado1, $id_unidade, $cor);
        $this->setLado2($lado2);
    }

    public function getLado2() {
        return $this->lado2;
    }

    public function setLado2($lado2) {
        if ($lado2 <= 0) {
            throw new Exception("Lado 2 deve ser maior que zero.");
        }
        $this->lado2 = $lado2;
        return $this;
    }

    // Calcula a altura do triângulo isósceles
    public function getAltura() {
        if ($this->lado <= 0 || $this->lado2 <= 0) {
            throw new Exception("Os lados do triângulo devem ser maiores que zero.");
        }

        // Usando a fórmula da altura de um triângulo isósceles
        return sqrt(pow($this->lado2, 2) - pow($this->lado / 2, 2));
    }

    // Método para desenhar o triângulo isósceles
    public function desenhar() {
        $altura = $this->getAltura();  // Usando o método getAltura()

        // Gerando o HTML do triângulo isósceles
        return "<a href='triangulo_isosceles.php?id=" . $this->getId() . "'>
                    <div class='container' style='
                    width: 0; 
                    height: 0; 
                    border-left:" . ($this->getLado() / 2) . $this->getIdUnidade()->getSigla() . " solid transparent; 
                    border-right:" . ($this->getLado() / 2) . $this->getIdUnidade()->getSigla() . " solid transparent; 
                    border-bottom:" . $altura . $this->getIdUnidade()->getSigla() . " solid " . $this->getCor() . ";'>
                    </div>
                </a><br>";
    }

    // Incluir o triângulo isósceles no banco de dados
    public function incluir() {
        // Verificar se os lados são válidos
        if ($this->lado <= 0 || $this->lado2 <= 0) {
            throw new Exception("Os lados do triângulo devem ser maiores que zero para inclusão.");
        }

        $sql = 'INSERT INTO trianguloisosceles (lado1, lado2, id_unidade, cor)   
                VALUES (:lado, :lado2, :id_unidade, :cor)';

        $parametros = array(
            ':lado' => $this->lado,
            ':lado2' => $this->lado2,
            ':id_unidade' => $this->getIdUnidade() ? $this->getIdUnidade()->getIdUnidade() : null,
            ':cor' => $this->cor
        );

        return Database::executar($sql, $parametros);
    }

    public static function listar($tipo = 0, $busca = "") {
        $sql = "SELECT * FROM trianguloisosceles";
        $parametros = array();

        if ($tipo > 0) {
            switch ($tipo) {
                case 1:
                    $sql .= " WHERE id = :busca";
                    break;
                case 2:
                    $sql .= " WHERE lado1 like :busca";
                    $busca = "%{$busca}%";
                    break;
            }
            $parametros = array(':busca' => $busca);
        }

        $registros = Database::executar($sql, $parametros);
        $formas = array();

        while ($registro = $registros->fetch(PDO::FETCH_ASSOC)) {
            $id_unidade = UnidadeMedida::listar(1, $registro['id_unidade'])[0];
            $forma = new TrianguloIsosceles($registro['id'], $registro['lado1'], $registro['lado2'], $id_unidade, $registro['cor']);
            array_push($formas, $forma);
        }

        return $formas;
    }
}
?>
