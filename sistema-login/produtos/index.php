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
                <!-- Tabela de clientes cadastrados -->
                <h2>
                    Produtos Cadastrados
                    <a href="exportar.php" class="btn btn-success btn-sm float-left">Excel</a>
                    <a href="exportar_pdf.php" class="btn btn-danger btn-sm float-left">PDF</a>
                    <a href="/produtos/formulario.php" class="btn btn-primary btn-sm">Novo Produto</a>
                </h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Produto</th>
                            <th scope="col">Imagem</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Quantidade</th>
                            <th scope="col">Preço</th>  
                        </tr>
                    </thead>
                    <tbody id="prdutoTableBody">
                        <!-- Os clientes serão carregados aqui via PHP -->
                        <?php
                        // SE HOUVER CLIENTES NA SESSÃO, EXIBIR
                        require("../requests/produtos/get.php");
                        if(!empty($response)) {
                            foreach($response["data"] as $key => $produto) {
                                echo '
                                <tr>
                                    <th scope="row">'.$produto["id_produto"].'</th>
                                    <td>'.$produto["produto"].'</td>
                                    <td><img width="60" src="imagens/'.$produto["imagem"].'"></td>
                                    <td>'.$produto["descricao"].'</td>
                                    <td>'.$produto["marca"].'</td>
                                    <td>'.$produto["quantidade"].'</td>
                                    <td>'.$produto["preco"].'</td>
                                    <td>
                                        <a href="/produtos/formulario.php?key='.$produto["id_produto"].'" class="btn btn-warning">Editar</a>
                                        <a href="/produtos/remover.php?key='.$produto["id_produto"].'" class="btn btn-danger">Excluir</a>
                                    </td>
                                </tr>
                                ';
                            }
                        } else {
                            echo '
                            <tr>
                                <td colspan="7">Nenhum produto cadastrado</td>
                            </tr>
                            ';
                        }
                        ?>
                    </tbody>
                </table>
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