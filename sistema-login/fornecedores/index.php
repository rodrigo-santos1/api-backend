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
            <div class="col-md-6">
                <!-- Formulário de cadastro de clientes -->
                <h2>
                    Cadastrar Fornecedor
                    <a href="./" class="btn btn-primary btn-sm">Novo Fornecedor</a>
                </h2>
                <form id="clientForm" action="/clientes/cadastrar.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="fornecedorId" class="form-label">Código do Fornecedor</label>
                        <input type="text" class="form-control" id="fornecedorId" name="fornecedorId" readonly value="<?php echo isset($fornecedor) ? $fornecedor["id_fornfornecedor"] : ""; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="fornecedorRazaoSocial" class="form-label">Razão Social</label>
                        <input type="text" class="form-control" id="fornecedorRazaoSocial" name="fornecedorRazaoSocial" required value="<?php echo isset($fornecedor) ? $fornecedor["razao_social"] : ""; ?>">
                    <div class="mb-3">

                    <div class="mb-3">
                        <label for="fornecedorCNPJ" class="form-label">CNPJ</label>
                        <input type="text" maxlength="18" data-mask="00.000.000/0000-00" class="form-control" id="fornecedorCNPJ" name="fornecedorCNPJ" required value="<?php echo isset($fornecedor) ? $fornecedor["cnpj"] : ""; ?>">
                    <div class="mb-3">    

                        <label for="fornecedorEmail" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="fornecedorEmail" name="fornecedorEmail" required value="<?php echo isset($fornecedor) ? $fornecedor["email"] : ""; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="fornecedorTelefone" class="form-label">Telefone</label>
                        <input data-mask="(00) 0000-0000" type="text" class="form-control" id="fornecedorTelefone" name="fornecedorTelefone" required value="<?php echo isset($fornecedor) ? $fornecedor["telefone"] : ""; ?>">
                    <div class="mb-3">
                        <label for="clientCEP" class="form-label">CEP</label>
                        <input data-mask="00000-000" type="text" class="form-control" id="clientCEP" name="clientCEP" required value="<?php echo isset($client) ? $client["endereco"]["cep"] : ""; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="clientStreet" class="form-label">Logradouro</label>
                        <input type="text" class="form-control" id="clientStreet" name="clientStreet" required value="<?php echo isset($client) ? $client["endereco"]["logradouro"] : ""; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="clientNumber" class="form-label">Número</label>
                        <input type="text" class="form-control" id="clientNumber" name="clientNumber" required value="<?php echo isset($client) ? $client["endereco"]["numero"] : ""; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="clientComplement" class="form-label">Complemento</label>
                        <input type="text" class="form-control" id="clientComplement" name="clientComplement" value="<?php echo isset($client) ? $client["endereco"]["complemento"] : ""; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="clientNeighborhood" class="form-label">Bairro</label>
                        <input type="text" class="form-control" id="clientNeighborhood" name="clientNeighborhood" required value="<?php echo isset($client) ? $client["endereco"]["bairro"] : ""; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="clientCity" class="form-label">Cidade</label>
                        <input readonly type="text" class="form-control" id="clientCity" name="clientCity" required value="<?php echo isset($client) ? $client["endereco"]["cidade"] : ""; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="clientState" class="form-label">Estado (UF)</label>
                        <input readonly type="text" maxlength="2" class="form-control" id="clientState" name="clientState" required value="<?php echo isset($client) ? $client["endereco"]["estado"] : ""; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
            <div class="col-md-6">
                <!-- Tabela de clientes cadastrados -->
                <h2>
                    Fornecedor Cadastrados
                    <a href="exportar.php" class="btn btn-success btn-sm float-left">Excel</a>
                    <a href="exportar_pdf.php" class="btn btn-danger btn-sm float-left">PDF</a>
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
                        require("../requests/fornecedor/get.php");
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
                                        <a href="/fornecedores/?key='.$fornecedor["id_fornecedor"].'" class="btn btn-warning">Editar</a>
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

    <script> 
    $('#fornecedorCEP').on('blur', function() {
        var cep = $(this).val().replace(/\D/g, '');
        // Verifica se o CEP tem 8 dígitos
        if (cep.length === 8) {
            // Faz a requisição para a API ViaCEP
            $.getJSON('https://viacep.com.br/ws/' + cep + '/json/?callback=?', function(data) {
                if (!data.erro) {
                    $('#fornecedorStreet').val(data.logradouro);
                    $('#fornecedorNeighborhood').val(data.bairro);
                    $('#fornecedorCity').val(data.localidade);
                    $('#fornecedorState').val(data.uf);
                } else {
                    alert('CEP não encontrado.');
                    $("#fornecedorCEP").val("");
                    $("#fornecedorStreet").val("");
                    $("#fornecedorNeighborhood").val("");
                    $("#fornecedorCity").val("");
                    $("#fornecedorState").val("");
                }
            });
        } else {
            alert('Formato de CEP inválido.');
            // Limpa os campos de endereço
            $("#fornecedorCEP").val("");
            $("#fornecedorStreet").val("");
            $("#fornecedorNeighborhood").val("");
            $("#fornecedorCity").val("");
            $("#fornecedorState").val("");
        }
    });
    </script>

</body>
</html>