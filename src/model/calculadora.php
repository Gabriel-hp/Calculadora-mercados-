<?php
class Calculadora {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function adicionarProduto($nome_produto, $obs, $preco, $qtd) {
        $sql = "INSERT INTO produtos (nome_produto, obs, preco, qtd) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssdd", $nome_produto, $obs, $preco, $qtd);
        return $stmt->execute();
    }

    public function listarProdutos() {
        $sql = "SELECT id, nome_produto, obs, preco, qtd FROM produtos";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function removerProduto($id) {
        $sql = "DELETE FROM produtos WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function calcularTotal() {
        $sql = "SELECT SUM(preco) as total FROM produtos";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc()['total'];
    }

    public function calcularQtd() {
        $sql = "SELECT SUM(preco) as total FROM produtos";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc()['total'];
    }

    
}
