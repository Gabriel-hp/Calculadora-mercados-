<?php

class CalculadoraController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function adicionarProduto($nome_produto, $obs, $preco, $qtd) {
        $total = $preco * $qtd;
        $stmt = $this->db->prepare("INSERT INTO produtos (nome_produto, obs, preco, qtd, total) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssddd", $nome_produto, $obs, $preco, $qtd, $total);
        $stmt->execute();
    }

    public function listarProdutos() {
        $stmt = $this->db->prepare("SELECT * FROM produtos");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function removerProduto($id) {
        $stmt = $this->db->prepare("DELETE FROM produtos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
    

    public function addQtd($id) {
        $stmt = $this->db->prepare("UPDATE `produtos` SET `qtd` = `qtd` + 1 WHERE `produtos`.`id` = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

           // Atualizar o total
        $stmt = $this->db->prepare("UPDATE produtos SET total = preco * qtd WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
    
    public function dimQtd($id) {
        // Primeiro, obtenha a quantidade atual
        $stmt = $this->db->prepare("SELECT qtd FROM produtos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $produto = $result->fetch_assoc();
        
        // Verifique se a quantidade é maior que 0 antes de diminuir
        if ($produto['qtd'] > 1) {
            $stmt = $this->db->prepare("UPDATE produtos SET qtd = qtd - 1 WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
        }

        // Atualizar o total
        $stmt = $this->db->prepare("UPDATE produtos SET total = preco * qtd WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
     

    public function calcularTotal() {
        $stmt = $this->db->prepare("SELECT SUM(total) as total FROM produtos");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'];
    }
}
?>
