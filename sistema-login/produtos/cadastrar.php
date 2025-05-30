<?php
// CHAMA O ARQUIVO ABAIXO NESTA TELA
include "../verificar-autenticacao.php";


try{
    if(!$_POST){
        throw new Exception("Acesso indevído! Tente novamente.");
    }

    // VERIFICAR SE O ARQUIVO FOI ENVIADO
    if ($_FILES["produtoImage"]["name"] != "") {
        // PEGAR A EXTENSÃO DO ARQUIVO
        $extensao = pathinfo($_FILES["produtoImage"]["name"], PATHINFO_EXTENSION);
        // GERAR UM NOVO NOME PARA O ARQUIVO
        $novo_nome = md5(uniqid() . microtime()) . ".$extensao";
        // MOVER O ARQUIVO PARA A PASTA DE IMAGENS
        move_uploaded_file($_FILES["produtoImage"]["tmp_name"], "imagens/$novo_nome");
        // ADICIONAR O NOME DO ARQUIVO NO POST
        $_POST["produtoImage"] = $novo_nome;

        // SE JÁ EXISTIR UMA IMAGEM, DELETAR A IMAGEM
        if ($_POST["currentProdutoImage"] != "") {
            // UNLINK = DELETAR ARQUIVOS
            unlink("imagens/" . $_POST["currentClientImage"]);
        }

    } else {
        // SE NÃO FOI ENVIADO ARQUIVO, PEGAR O NOME DO ARQUIVO ATUAL
        $_POST["produtoImage"] = $_POST["currentProdutoImage"];
    }

    $msg = '';

    if ($_POST["produtoId"] == "") {

        $postfields = array(
        "produto" => $_POST["produtoName"],
        "descricao" => $_POST["produtoDescription"],
        "id_marca" => $_POST["produtoBrand"],
        "imagem" => $_POST["produtoImage"],
        "quantidade" => $_POST["produtoQuantity"],
        "preco" => $_POST["produtoPrice"]
    );
    
        require("../requests/produtos/post.php");
    } else {

        $postfields = array(
        "id_produto" => $_POST["produtoId"],
        "produto" => $_POST["produtoName"],
        "descricao" => $_POST["produtoDescription"],
        "id_marca" => $_POST["produtoBrand"],
        "imagem" => $_POST["produtoImage"],
        "quantidade" => $_POST["produtoQuantity"],
        "preco" => $_POST["produtoPrice"]
    );
        // SENÃO, SIGNIFICA QUE É UM PRODUTO JÁ CADASTRADO
        require("../requests/produtos/put.php");
    }
    $_SESSION["msg"] = $response["message"]; 

}catch(Exception $e){
    $_SESSION["msg"] = $e->getMessage();
}finally{
    header("Location: ./");
}