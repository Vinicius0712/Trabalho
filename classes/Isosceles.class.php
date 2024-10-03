<?php
require_once("Triangulo.class.php");

class Isosceles extends Triangulo {
    protected $ladoIgual; // Lado igual do triângulo isósceles

    public function __construct($id = 0, $base = 0, $ladoIgual = 0, ?UnidadeMedida $id_unidade = null, $cor = "#000000") {
        parent::__construct($id, $base, $id_unidade, $cor);
        $this->ladoIgual = $ladoIgual;
    }

    public function getLadoIgual() {
        return $this->ladoIgual;
    }

    // Método para calcular a altura do triângulo isósceles
    public function getAltura() {
        return sqrt($this->ladoIgual ** 2 - ($this->getBase() / 2) ** 2); // Altura do triângulo isósceles
    }

    // Método para desenhar o triângulo isósceles
    public function desenhar() {
        $altura = $this->getAltura();  // Usando o método getAltura()

        // Gerando o HTML do triângulo com a altura e lado calculados
        return "<a href='isosceles.php?id=" . $this->getId() . "'>
                    <div class='container' style='
                    width: 0; 
                    height: 0; 
                    border-left:" . ($this->getBase() / 2) . $this->getIdUnidade()->getSigla() . " solid transparent; 
                    border-right:" . ($this->getBase() / 2) . $this->getIdUnidade()->getSigla() . " solid transparent; 
                    border-bottom:" . $altura . $this->getIdUnidade()->getSigla() . " solid " . $this->getCor() . ";'>
                    </div>
                </a><br>";
    }

    public function incluir() {
        // Lógica para incluir no banco de dados
    }

    public function alterar() {
        // Lógica para alterar no banco de dados
    }

    public function excluir() {
        // Lógica para excluir do banco de dados
    }
}
