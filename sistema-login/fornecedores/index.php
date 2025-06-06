<?php
// CHAMA O ARQUIVO ABAIXO NESTA TELA
include "../verificar-autenticacao.php";

// INDICA QUAL PÁGINA ESTOU NAVEGANDO
$pagina = "fornecedores";

if (isset($_GET["key"])) {
    $key = $_GET["key"];  //atribui o valor da chave GET à variável $key
    require("../requests/fornecedores/get.php");
    if (isset($response["data"]) && !empty($response["data"])) {
        $fornecedor = $response["data"][0]; 
    } else {
        $fornecedor = null; // Se não encontrar, define como nulo
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Cadastro de Fornecedores</title>
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
                <!-- Tabela de fornecedores cadastrados -->
                <h2>
                    Fornecedor Cadastrados
                    <a href="exportar.php" class="btn btn-success btn-sm float-left">Excel</a>
                    <a href="exportar_pdf.php" class="btn btn-danger btn-sm float-left">PDF</a>
                    <a href="/fornecedores/formulario.php" class="btn btn-primary btn-sm">Novo Fornecedor</a>
                </h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Razão Social</th>
                            <th scope="col">CNPJ</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Telefone</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody id="clientTableBody">
                        <!-- Os clientes serão carregados aqui via PHP -->
                        <?php
                        // SE HOUVER CLIENTES NA SESSÃO, EXIBIR
                        $key = null;  //limpa a variável key para trazer todos os clientes
                        require("../requests/fornecedores/get.php");
                        if(!empty($response)) {
                            foreach($response["data"] as $key => $fornecedor) {
                                echo '
                                <tr>
                                    <th scope="row">'.$fornecedor["id_fornecedor"].'</th>
                                    <td>'.$fornecedor["razao_social"].'</td>
                                    <td>'.$fornecedor["cnpj"].'</td>
                                    <td>'.$fornecedor["email"].'</td>
                                    <td>'.$fornecedor["telefone"].'</td>
                                    <td>
                                        <a href="/fornecedores/formulario.php?key='.$fornecedor["id_fornecedor"].'" class="btn btn-warning">Editar</a>
                                        <a href="/fornecedores/remover.php?key='.$fornecedor["id_fornecedor"].'" class="btn btn-danger">Excluir</a>
                                    </td>
                                </tr>
                                ';
                            }
                        } else {
                            echo '
                            <tr>
                                <td colspan="7">Nenhum fornecedor cadastrado</td>
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

   <<script> 
    $('#fornecedorCEP').on('blur', function() {
        var cep = $(this).val().replace(/\D/g, '');
        if (cep.length === 8) {
            $.getJSON('https://viacep.com.br/ws/' + cep + '/json/?callback=?', function(data) {
                if (!data.erro) {
                    $('#fornecedorStreet').val(data.logradouro);
                    $('#fornecedorNeighborhood').val(data.bairro);
                    $('#fornecedorCity').val(data.localidade);
                    $('#fornecedorState').val(data.uf);
                } else {
                    alert('CEP não encontrado.');
                    $("#fornecedorCEP, #fornecedorStreet, #fornecedorNeighborhood, #fornecedorCity, #fornecedorState").val("");
                }
            });
        } else {
            alert('Formato de CEP inválido.');
            $("#fornecedorCEP, #fornecedorStreet, #fornecedorNeighborhood, #fornecedorCity, #fornecedorState").val("");
        }
    });
</script>


</body>
</html>