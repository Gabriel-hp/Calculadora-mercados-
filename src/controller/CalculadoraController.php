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

    if (isset($_POST['id']) && isset($_GET['action'])) {
        $id = $_POST['id'];
        $action = $_GET['action'];
    
        if ($action === 'adicionar') {
            $controller->addQtd($id);
        } elseif ($action === 'remover') {
            $controller->removeQtd($id);
        }
    
        // Responder ao AJAX
        echo json_encode(['success' => true]);
    }
    

    public function addQtd($id) {
        $stmt = $this->db->prepare("UPDATE `produtos` SET `qtd` = `qtd` + 1 WHERE `produtos`.`id` = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
    
    public function removeQtd($id) {
        $stmt = $this->db->prepare("UPDATE `produtos` SET `qtd` = `qtd` - 1 WHERE `produtos`.`id` = ?");
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
