<?php
require_once 'src/controller/CalculadoraController.php';

$conn = new mysqli("localhost", "root", "", "mercado");

$controller = new CalculadoraController($conn);

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'adicionar':
        $nome_produto = $_POST['nome_produto'];
        $obs = $_POST['obs'];
        $preco = isset($_POST['preco']) ? floatval($_POST['preco']) : 0.00;
        $qtd= $_POST['qtd'];
        $controller->adicionarProduto($nome_produto, $obs, $preco, $qtd);
        header('Location: index.php');
        break;
    case 'remover':
        $id = $_POST['id'];
        $controller->removerProduto($id);
        break;
    case 'adicionarma':
        $id = $_POST['id'];
        $controller->addQtd($id);
        break;
    case 'dim':
            $id = $_POST['id'];
            $controller->dimQtd($id);
            break;    
    default:
        $produtos = $controller->listarProdutos();
        $total = $controller->calcularTotal();
        include 'src/view/main_view.php';
        break;
}
