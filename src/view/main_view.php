<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de compras</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles.css">
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

            $(".deleteall-btn").click(function() {
                var id = $(this).data("id");
                
                // Exibe uma mensagem de confirmação ao usuário
                var confirmacao = confirm("Você tem certeza que deseja remover todos os produtos? Esta ação não pode ser desfeita.");

                // Se o usuário confirmar, a requisição POST é enviada
                if (confirmacao) {
                    $.post("index.php?action=removerall", { id: id }, function() {
                        location.reload(); // Recarrega a página após a remoção
                    });
                }
            });


            // Ao clicar no botão de adicionar quantidade
            $(".add-btn").click(function() {
                var id = $(this).data("id");
                $.post("index.php?action=adicionarma", { id: id }, function(response) {
                    location.reload(); // Atualiza a página após a ação
                });
            });

            // Ao clicar no botão de diminui quantidade
            $(".dim-btn").click(function() {
                var id = $(this).data("id");
                $.post("index.php?action=dim", { id: id }, function(response) {
                    location.reload(); // Atualiza a página após a ação
                });
            });
            $(document).ready(function(){
    $('#input-produto').on('input', function() {
        var query = $(this).val();

        if (query.length > 2) { // Apenas busca se tiver mais de 2 caracteres
            $.ajax({
                url: 'connect.php',
                method: 'GET',
                data: { query: query },
                success: function(response) {
                    // Aqui você pode manipular a resposta para exibir os resultados
                    $('#resultados').empty();
                    $.each(response, function(index, produto) {
                        $('#resultados').append('<h5 class="card-title">' + produto.nome_produto + '</h5>');
                    });
                }
            });
        }
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
            <button id="addProductBtn" class="btn btn-primary mb-3">Adicionar Produto</button> <br>
            <button class="btn btn-dark deleteall-btn" data-id="<?= htmlspecialchars($produto['id']) ?>">Nova lista</button>
            </script>
        </div>
    </div>

    <div class="container mt-5 pt-5 text-center">
        <div class="row mt-5 pt-3">
            <?php if (!empty($produtos)): ?>
                <?php foreach ($produtos as $produto): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="left">
                                <h5 class="card-title"><?= htmlspecialchars($produto['nome_produto']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($produto['obs']) ?></p>
                                <p class="card-text"><strong>Preço: R$ <?= number_format(htmlspecialchars($produto['preco']), 2, ',', '.') ?></strong></p>
                                <p class="card-total"><strong>Total: R$ <br> <?= number_format(htmlspecialchars($produto['total']), 2, ',', '.') ?></strong></p>
                            </div>
                            <div class="rigth">
                            <p class="card-text"><strong>Quantidade</strong></p>
                            <div class="btn-org">
                        
                                <button type="button" class="btn btn-warning dim-btn" data-id="<?= htmlspecialchars($produto['id']) ?>">-</button>
                                <p class="card-text"><strong><?= htmlspecialchars($produto['qtd']) ?></strong></p>
                                <button type="button" class="btn btn-success add-btn" data-id="<?= htmlspecialchars($produto['id']) ?>">+</button>
                            </div>
                            
                            
                            <button class="btn btn-danger delete-btn" data-id="<?= htmlspecialchars($produto['id']) ?>">Remover</button>
                            </div>
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
                        <input type="text" class="form-control" id="nome_produto" name="nome_produto" required autocomplete="off">
                        <div id="autocomplete-suggestions"></div> <!-- Exibe as sugestões aqui -->
                    </div>

                        <div class="row g-3">
                        <div class="form-group col-6">
                            <label for="preco">Preço:</label>
                            <input type="number" step="0.01" class="form-control" id="preco" name="preco" min="0" required>
                        </div>

                            <div class="form-group col-6">
                                <label for="qtd">Quatidade:</label>
                                <input type="number" value="1" class="form-control" id="qtd" name="qtd" min="1" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="obs">Observação:</label>
                            <textarea class="form-control" id="obs" name="obs"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Adicionar Produto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>



</html>
