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
    case 'removerall':
            $id = $_POST['id'];
            $controller->removerall($id);
            break;
    case 'adicionarma':
        $id = $_POST['id'];
        $controller->addQtd($id);
        break;
    case 'dim':
        $id = $_POST['id'];
        $controller->dimQtd($id);
        break;
    case 'buscar':
        // Obtendo o termo de busca da requisição
        $termoBusca = isset($_GET['query']) ? $_GET['query'] : '';

        if (!empty($termoBusca)) {
            // Preparando a consulta SQL para buscar produtos pelo nome
            $sql = "SELECT id, nome_produto FROM produtos WHERE nome_produto LIKE ?";
            $stmt = $conn->prepare($sql);
            $param = "%" . $termoBusca . "%";
            $stmt->bind_param("s", $param);
            $stmt->execute();
            $result = $stmt->get_result();

            // Criando um array para armazenar os produtos encontrados
            $produtos = [];

            while ($row = $result->fetch_assoc()) {
                $produtos[] = [
                    'id' => $row['id'],
                    'nome_produto' => htmlspecialchars($row['nome_produto'])
                ];
            }

            // Retornando os produtos como JSON
            header('Content-Type: application/json');
            echo json_encode($produtos);
        } else {
            echo json_encode([]);
        }
        break;
    default:
        $produtos = $controller->listarProdutos();
        $total = $controller->calcularTotal();
        include 'src/view/main_view.php';
        break;
}
?>
