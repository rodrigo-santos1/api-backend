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
    <link href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css" rel="stylesheet">
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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <!-- Tabela de clientes cadastrados -->
                        <h2> Produtos Cadastrados </h2>
                        <div>
                            <a href="exportar.php" class="btn btn-success btn-sm float-left">Excel</a>
                            <a href="exportar_pdf.php" class="btn btn-danger btn-sm float-left">PDF</a>
                            <a href="/produtos/formulario.php" class="btn btn-primary btn-sm">Novo Produto</a>
                            <a href="../index.php" class="btn btn-primary btn-sm">Voltar</a>
                        </div>
                    </div>
                    <div class="card-body">
                    </div>
                    <table id="myTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Produto</th>
                                <th scope="col">Imagem</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Marca</th>
                                <th scope="col">Quantidade</th>
                                <th scope="col">Preço</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="produtoTableBody">
                            <!-- Os clientes serão carregados aqui via PHP -->
                            <?php
                        // SE HOUVER CLIENTES NA SESSÃO, EXIBIR
                        $key = null; //limpa a variável key para não interferir em outras requisições
                        require("../requests/produtos/get.php");
                        if(!empty($response)) {
                            foreach($response["data"] as $key => $produto) {
                                echo '
                                <tr>
                                    <th scope="row">'.$produto["id_produto"].'</th>
                                    <td>'.$produto["produto"].'</td>
                                    <td>
                                        <img src="/produtos/imagens/' .$produto["imagem"] .'" alt="Imagem do produto" class="img-thumbnail" style="max-width: 100px;">
                                    </td>
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
        <!-- Datatables -->
        <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
        <script>
        let table = new DataTable('#myTable', {
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.3.2/i18n/pt-BR.json',
            },
        });
        </script>

</body>

</html>