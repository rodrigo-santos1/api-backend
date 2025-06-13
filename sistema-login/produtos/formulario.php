<?php
// CHAMA O ARQUIVO ABAIXO NESTA TELA
include "../verificar-autenticacao.php";

// INDICA QUAL PÁGINA ESTOU NAVEGANDO
$pagina = "produtos";

if (isset($_GET["key"])) {
    $key = $_GET["key"];  //atribui o valor da chave GET à variável $key
    require("../requests/produtos/get.php");
    $key = null; //limpa a variável key para não interferir em outras requisições
    if (isset($response["data"]) && !empty($response["data"])) {
        $produto = $response["data"][0]; 
    } else {
        $produto = null; // Se não encontrar, define como nulo
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Cadastro de Produtos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php
    include "../mensagens.php";
    include "../navbar.php";
    ?>

    <!-- Conteúdo principal -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md">
                <div class="card">
                    <div class="card-header">
                        <!-- Formulário de cadastro de clientes -->
                        <h2>
                            Cadastrar Produtos
                        </h2>
                    </div>
                    <div class="card-body">
                        <form id="produtoForm" action="/produtos/cadastrar.php" method="POST"
                            enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="produtoId" class="form-label">Código do Produto</label>
                                    <input type="text" class="form-control" id="produtoId" name="produtoId" readonly
                                        value="<?php echo isset($produto) ? $produto["id_produto"] : ""; ?>">
                                </div>
                                <div class="col-md-9">
                                    <label for="produto" class="form-label">Produto</label>
                                    <input type="text" class="form-control" id="produto" name="produto"
                                        value="<?php echo isset($produto) ? $produto["produto"] : ""; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="produtoBrand" class="form-label">Marca</label>
                                    <select class="form-select" id="produtoBrand" name="produtoBrand">
                                        <option value="">Selecione uma marca</option>
                                        <?php
                            // BUSCA AS MARCAS CADASTRADAS
                            require("../requests/marcas/get.php");
                            if (!empty($response["data"])) {
                                foreach ($response["data"] as $brand) {
                                    $selected = (isset($produto) && $produto["id_marca"] == $brand["id_marca"]) ? "selected" : "";
                                    echo '<option value="' . $brand["id_marca"] . '" ' . $selected . '>' . $brand["marca"] . '</option>';
                                }
                            }
                            ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="produtoQuantity" class="form-label">Quantidade</label>
                                    <input type="number" class="form-control" id="produtoQuantity"
                                        name="produtoQuantity"
                                        value="<?php echo isset($produto) ? $produto["quantidade"] : ""; ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="produtoPrice" class="form-label">Preco</label>
                                    <input type="number" class="form-control" id="produtoPrice" name="produtoPrice"
                                        value="<?php echo isset($produto) ? $produto["preco"] : ""; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="clientImage" class="form-label">Imagem</label>
                                    <input type="file" class="form-control" id="clientImage" name="clientImage"
                                        accept="image/*" value="<?php echo isset($client) ? $client["imagem"] : ""; ?>">
                                </div>

                                <?php
                            // SE HOUVER IMAGEM NO CLIENTE, EXIBIR MINIATURA
                                if (isset($produto["imagem"])) {
                                    echo '
                                    <div class="mb-3">
                                    <input type="hidden" name="currentProdutoImage" value="' . $produto["imagem"] . '">
                                    <img width="100" src="imagens/' . $produto["imagem"] . '">
                                    </div>
                                    ';
                                }
                            ?>
                            </div>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <label for="produtoDescription" class="form-label">Descrição</label>
                                    <input type="text" class="form-control" id="produtoDescription"
                                        name="produtoDescription"
                                        value="<?php echo isset($produto) ? $produto["descricao"] : ""; ?>">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer ">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <a href="./" class="btn btn-primary ">Voltar</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS (opcional, para funcionalidades como o menu hamburguer) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jQuery Mask Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

</body>

</html>