<?php

try {
    // Recuperar informações de formulário vindo do Frontend
    $postfields = json_decode(file_get_contents('php://input'), true);

    // Verificar se existe informações de formulário
    if(!empty($postfields)) {
        $produto = $postfields['produto'] ?? null;
        $descricao = $postfields['descricao'] ?? null;
        $id_marca = $postfields['id_marca'] ?? null;
        $imagem = $postfields['imagem'] ?? null;
        $quantidade = $postfields['quantidade'] ?? 0;
        $preco = $postfields['preco'] ?? 0.0;

        // Verifica campos obrigatórios
        if (empty($produto)) {
        http_response_code(400);
        throw new Exception('Produto é obrigatório');
        }


        $sql = "
        INSERT INTO produtos (produto, descricao, id_marca, imagem, quantidade, preco) VALUES 
        (
            :produto,
            :descricao,
            :id_marca,
            :imagem,
            :quantidade,
            :preco
        )";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':produto', $produto, PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':id_marca', $id_marca, PDO::PARAM_INT);
        $stmt->bindParam(':imagem', $imagem, PDO::PARAM_STR);
        $stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
        $stmt->bindParam(':preco', $preco, PDO::PARAM_STR);

        $stmt->execute();

        $result = array(
            'status' => 'success',
            'message' => 'Produto cadastrado com sucesso!'
        );


    } else {
        http_response_code(400);
        // Se não existir dados, retornar erro
        throw new Exception('Nenhum dado foi enviado!');
    }

} catch (Exception $e) {
    // Se houver erro, retorna o erro
    $result = array(
        'status' => 'error',
        'message' => $e->getMessage(),
    );
} finally {
    // Retorna os dados em formato JSON
    echo json_encode($result);
    // Fecha a conexão com o banco de dados
    $conn = null;
}
