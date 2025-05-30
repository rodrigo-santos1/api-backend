<?php
include "../verificar-autenticacao.php";

// DEFINE TIMEZONE PARA BRASIL
date_default_timezone_set('America/Sao_Paulo');
$filename = "produtos_" . date('YmdHis') . ".xls";

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
            <th style="background:gray;font-weight:bold;border:1px solid black">#</th>
            <th style="background:gray;font-weight:bold;border:1px solid black">Produto</th>
            <th style="background:gray;font-weight:bold;border:1px solid black">Descrição</th>
            <th style="background:gray;font-weight:bold;border:1px solid black">ID Marca</th>
            <th style="background:gray;font-weight:bold;border:1px solid black">Quantidade</th>
            <th style="background:gray;font-weight:bold;border:1px solid black">Preco</th>
        </tr>
    </thead>
    <tbody id="produtoTableBody">
        <?php
        if (!empty($_SESSION["produtos"])) {
            foreach ($_SESSION["produtos"] as $key => $produto) {
                echo '
                <tr>
                    <th style="border:1px solid black" scope="row">' . ($key + 1) . '</th>
                    <td style="border:1px solid black">' . $produto["produtoProduto"] . '</td>
                    <td style="border:1px solid black">' . $produto["produtoDescricao"] . '</td>
                    <td style="border:1px solid black">' . $produto["produtoId_marca"] . '</td>
                    <td style="border:1px solid black">' . $produto["produtoQuantidade"] . '</td>
                    <td style="border:1px solid black">' . $produto["produtoPreco"] . '</td>
                </tr>';
            }
        } else {
            echo '
            <tr>
                <td colspan="6">Nenhum produto cadastrado</td>
            </tr>';
        }
        ?>
    </tbody>
</table>
