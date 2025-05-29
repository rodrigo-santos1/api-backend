<?php
// CHAMA O ARQUIVO ABAIXO NESTA TELA
include "../verificar-autenticacao.php";

// DEFINE TIMEZONE PARA BRASIL
date_default_timezone_set('America/Sao_Paulo');
$filename = "fornecedores_".date('YmdHis').".xls";

// CABEÇALHO PARA EXPORTAR O ARQUIVO EM EXCEL
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");

?>
<head>
    <meta charset="utf-8">
</head>
<table>
    <thead>
        <tr>
            <th style="background:gray;font-weight:bold;border:1px solid black" scope="col">#</th>
            <th style="background:gray;font-weight:bold;border:1px solid black;width:250px" scope="col">Razão Social</th>
            <th style="background:gray;font-weight:bold;border:1px solid black;width:150px" scope="col">CNPJ</th>
            <th style="background:gray;font-weight:bold;border:1px solid black;width:250px" scope="col">E-mail</th>
            <th style="background:gray;font-weight:bold;border:1px solid black;width:150px" scope="col">Telefone</th> 
        </tr>
    </thead>
    <tbody id="fornecedoresTableBody">
        <!-- Os clientes serão carregados aqui via PHP -->
        <?php
        // SE HOUVER CLIENTES NA SESSÃO, EXIBIR
        if(!empty($_SESSION["fornecedores"])) {
            foreach($_SESSION["fornecedores"] as $key => $fornecedor) {
                echo '
                <tr>
                    <th style="border:1px solid black" scope="row">'.($key + 1).'</th>
                    <td style="border:1px solid black">'.$fornecedor["fornecedorRazao_social"].'</td>
                    <td style="border:1px solid black">'.$fornecedor["fornecedorCNPJ"].'</td>
                    <td style="border:1px solid black">'.$fornecedor["fornecedorEmail"].'</td>
                    <td style="border:1px solid black">'.$fornecedor["fornecedorTelefone"].'</td>
                </tr>
                ';
            }
        } else {
            echo '
            <tr>
                <td colspan="4">Nenhum fornecedor cadastrado</td>
            </tr>
            ';
        }
        ?>
    </tbody>
</table>