<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compras de Mercado</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#addProductBtn").click(function() {
                $("#addProductModal").modal('show');
            });

            $(".delete-btn").click(function() {
                var id = $(this).data("id");
                $.post("index.php?action=remover", { id: id }, function() {
                    location.reload();
                });
            });
        });
    </script>
</head>
<body>
    <!-- Barra Superior Fixa -->
    <div class="fixed-top bg-light py-2">
        <div class="container text-center">
            <h1>Compras</h1>
            <button id="addProductBtn" class="btn btn-primary mb-3">Adicionar Produto</button>
        </div>
    </div>

    <div class="container mt-5 pt-5 text-center">
        <div class="row mt-5 pt-3">
            <?php if (!empty($produtos)): ?>
                <?php foreach ($produtos as $produto): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($produto['nome_produto']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($produto['obs']) ?></p>
                            <p class="card-text"><strong>Preço: R$ <?= htmlspecialchars($produto['preco']) ?></strong></p>
                            <p class="card-text"><strong>Quantidade: <?= htmlspecialchars($produto['qtd']) ?></strong></p>
                            <p class="card-text"><strong>Total: R$ <?= htmlspecialchars($produto['total']) ?></strong></p>
                            <button class="btn btn-danger delete-btn" data-id="<?= htmlspecialchars($produto['id']) ?>">Remover</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Total Fixo -->
    <div class="fixed-bottom bg-success py-2">
        <h2 class="text-center text-white">Total: R$ <?= number_format($total, 2, ',', '.') ?></h2>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Adicionar Produto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addProductForm" action="index.php?action=adicionar" method="post">
                        <div class="form-group">
                            <label for="nome_produto">Nome do Produto:</label>
                            <input type="text" class="form-control" id="nome_produto" name="nome_produto" required>
                        </div>
                        <div class="form-group">
                            <label for="obs">Observação:</label>
                            <textarea class="form-control" id="obs" name="obs"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="preco">Preço:</label>
                            <input type="number" step="0.01" class="form-control" id="preco" name="preco" required>
                        </div>
                        <div class="form-group">
                            <label for="qtd">Quatidade:</label>
                            <input type="number" value="1" class="form-control" id="qtd" name="qtd" min="1" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Adicionar Produto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
