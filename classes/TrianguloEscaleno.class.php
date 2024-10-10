<?php
require_once("Forma.class.php");

class TrianguloEscaleno extends Forma {

    private $lado2;
    private $lado3;

    public function __construct($id = 0, $lado1 = 0, $lado2 = 0, $lado3 = 0, ?UnidadeMedida $id_unidade = null, $cor = "null") {
        parent::__construct($id, $lado1, $id_unidade, $cor);
        $this->setLado2($lado2);
        $this->setLado3($lado3);
    }

    public function getLado() {
        return $this->lado; // Isso deve retornar o valor do lado
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

    public function getLado3() {
        return $this->lado3;
    }

    public function setLado3($lado3) {
        if ($lado3 <= 0) {
            throw new Exception("Lado 3 deve ser maior que zero.");
        }
        $this->lado3 = $lado3;
        return $this;
    }

    // Calcula a altura usando a fórmula de Herão
    public function getAltura() {
        if ($this->lado <= 0 || $this->lado2 <= 0 || $this->lado3 <= 0) {
            throw new Exception("Os lados do triângulo devem ser maiores que zero.");
        }

        $s = ($this->lado + $this->lado2 + $this->lado3) / 2;
        $area = sqrt($s * ($s - $this->lado) * ($s - $this->lado2) * ($s - $this->lado3));
        
        // Adicionando verificação para evitar divisão por zero
        if ($this->lado == 0) {
            throw new Exception("O lado não pode ser zero para calcular a altura.");
        }

        return (2 * $area) / $this->lado;
    }

    // Método para desenhar o triângulo escaleno
    public function desenhar() {
    $altura = $this->getAltura();  // Usando o método getAltura()

    // Usando lado 1 como base e os outros lados como laterais
    $base = $this->getLado();
    $ladoEsquerdo = $this->getLado2();
    $ladoDireito = $this->getLado3();

    // Gerando o HTML do triângulo escaleno
    return "<a href='triangulo_escaleno.php?id=" . $this->getId() . "'>
                <div class='container' style='
                position: relative; 
                width: " . $base . $this->getIdUnidade()->getSigla() . "; 
                height: " . $altura . $this->getIdUnidade()->getSigla() . ";'>
                    <div style='
                        position: absolute; 
                        width: 0; 
                        height: 0; 
                        border-left: " . ($ladoEsquerdo / 2) . $this->getIdUnidade()->getSigla() . " solid transparent; 
                        border-right: " . ($ladoDireito / 2) . $this->getIdUnidade()->getSigla() . " solid transparent; 
                        border-bottom: " . $altura . $this->getIdUnidade()->getSigla() . " solid " . $this->getCor() . ";
                        left: 50%; 
                        margin-left: -" . ($ladoEsquerdo / 2) . $this->getIdUnidade()->getSigla() . ";'>
                    </div>
                </div>
            </a><br>";
}

    // Incluir o triângulo escaleno no banco de dados
    public function incluir() {
        // Verificar se os lados são válidos
        if ($this->lado <= 0 || $this->lado2 <= 0 || $this->lado3 <= 0) {
            throw new Exception("Os lados do triângulo devem ser maiores que zero para inclusão.");
        }

        $sql = 'INSERT INTO trianguloescaleno (lado1, lado2, lado3, id_unidade, cor)   
                VALUES (:lado, :lado2, :lado3, :id_unidade, :cor)';

        $parametros = array(
            ':lado' => $this->lado,
            ':lado2' => $this->lado2,
            ':lado3' => $this->lado3,
            ':id_unidade' => $this->getIdUnidade() ? $this->getIdUnidade()->getIdUnidade() : null,
            ':cor' => $this->cor
        );

        return Database::executar($sql, $parametros);
    }

    public static function listar($tipo = 0, $busca = "") {
        $sql = "SELECT * FROM trianguloescaleno";
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
            $forma = new TrianguloEscaleno($registro['id'], $registro['lado1'], $registro['lado2'], $registro['lado3'], $id_unidade, $registro['cor']);
            array_push($formas, $forma);
        }

        return $formas;
    }
}
?>
