<?php
include "../verificar-autenticacao.php";
require_once '../mpdf/vendor/autoload.php';

$lista = "";
if (!empty($_SESSION["produtos"])) {
    foreach ($_SESSION["produtos"] as $key => $produto) {
        $lista .= '
        <tr>
            <th scope="row">'.($key + 1).'</th>
            <td><img src="http://localhost:8080/produtos/imagens/' . $produto["imagem"] . '" width="100"></td>
            <td>'.$produto["produto"].'</td>
            <td>'.$produto["descricao"].'</td>
            <td>'.$produto["id_marca"].'</td>
            <td>'.$produto["quantidade"].'</td>
            <td>'.$produto["preco"].'</td>
        </tr>
        ';
    }
} else {
    $lista = '
    <tr>
        <td colspan="7">Nenhum produto cadastrado</td>
    </tr>
    ';
}

$html = '
<html>
<head>
    <meta charset="utf-8">
    <style>
    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 8px;
        text-align: left;
        border: 1px solid black;
    }
    </style>
</head>
<body>
    <h1 style="text-align:center">Lista de Produtos</h1>
    <p style="text-align:center">Data: '.date('d/m/Y').'</p>
    <p style="text-align:center">Total de Produtos: '.count($_SESSION["produtos"]).'</p>
    <table>
        <thead>
            <tr>
                <th style="background:gray;font-weight:bold;" scope="col">#</th>
                <th style="background:gray;font-weight:bold;" scope="col">Imagem</th>
                <th style="background:gray;font-weight:bold;width:300px" scope="col">Produto</th>
                <th style="background:gray;font-weight:bold;width:300px" scope="col">Descrição</th>
                <th style="background:gray;font-weight:bold;width:300px" scope="col">ID_Marca</th>
                <th style="background:gray;font-weight:bold;width:300px" scope="col">Quantidade</th>
                <th style="background:gray;font-weight:bold;width:300px" scope="col">Preco</th>
            </tr>
        </thead>
        <tbody>
            '.$lista.'
        </tbody>
    </table>
</body>
</html>
';

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$nomeArquivo = 'produtos_'.date('YmdHis').'.pdf';
$mpdf->Output($nomeArquivo, \Mpdf\Output\Destination::DOWNLOAD);
?>
