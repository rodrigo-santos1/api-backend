<?php
// CHAMA O ARQUIVO ABAIXO NESTA TELA
include "../verificar-autenticacao.php";


try{
    if(!$_POST){
        throw new Exception("Acesso indevído! Tente novamente.");
    }

    $msg = '';

    if ($_POST["fornecedorId"] == "") {

        $postfields = array(
        "razao_social" => $_POST["fornecedorRazaoSocial"],
        "cnpj" => $_POST["fornecedorCNPJ"],
        "email" => $_POST["fornecedorEmail"],
        "telefone" => $_POST["fornecedorTelefone"],
        "endereco" => array(
            "cep" => $_POST["fornecedorCEP"],
            "logradouro" => $_POST["fornecedorStreet"],
            "numero" => $_POST["fornecedorNumber"],
            "complemento" => $_POST["fornecedorComplement"],
            "bairro" => $_POST["fornecedorNeighborhood"],
            "cidade" => $_POST["fornecedorCity"],
            "estado" => $_POST["fornecedorState"]
        )
    );
    
        require("../requests/fornecedores/post.php");
    } else {

         $postfields = array(
        "id_fornecedor" => $_POST["fornecedorId"],
        "razao_social" => $_POST["fornecedorRazaoSocial"],
        "cnpj" => $_POST["fornecedorCNPJ"],
        "email" => $_POST["fornecedorEmail"],
        "telefone" => $_POST["fornecedorTelefone"],
        "endereco" => array(
            "cep" => $_POST["fornecedorCEP"],
            "logradouro" => $_POST["fornecedorStreet"],
            "numero" => $_POST["fornecedorNumber"],
            "complemento" => $_POST["fornecedorComplement"],
            "bairro" => $_POST["fornecedorNeighborhood"],
            "cidade" => $_POST["fornecedorCity"],
            "estado" => $_POST["fornecedorState"]
        )
    );
        // SENÃO, SIGNIFICA QUE É UM PRODUTO JÁ CADASTRADO
        require("../requests/fornecedores/put.php");
    }
    $_SESSION["msg"] = $response["message"]; 

}catch(Exception $e){
    $_SESSION["msg"] = $e->getMessage();
}finally{
    header("Location: ./");
}