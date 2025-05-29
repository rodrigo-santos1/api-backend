<?php

try {
    // Recuperar informações de formulário vindo do Frontend
    $postfields = json_decode(file_get_contents('php://input'), true);

    // Verificar se existe informações de formulário
    if(!empty($postfields)) {
        $razao_social = $postfields['razao_social'] ?? null;
        $cnpj = $postfields['cnpj'] ?? null;
        $email = $postfields['email'] ?? null;
        $telefone = $postfields['telefone'] ?? null;
        $logradouro = $postfields['endereco']['logradouro'] ?? null;
        $numero = $postfields['endereco']['numero'] ?? null;
        $complemento = $postfields['endereco']['complemento'] ?? null;
        $bairro = $postfields['endereco']['bairro'] ?? null;
        $cidade = $postfields['endereco']['cidade'] ?? null;
        $estado = $postfields['endereco']['estado'] ?? null;
        $cep = $postfields['endereco']['cep'] ?? null;

        // Verifica campos obrigatórios
        if (empty($razao_social) || empty($postfields['endereco'])) {
            http_response_code(400);
            throw new Exception('Razão Social e Endereço são obrigatórios');
        }

        $sql = "
        INSERT INTO clientes (razao_social, cnpj, email, telefone, logradouro, numero, complemento, bairro, cidade, estado, cep) VALUES 
        (
            :razao_social,
            :cnpj,
            :email,
            :telefone,
            :logradouro, 
            :numero, 
            :complemento, 
            :bairro, 
            :cidade,
            :estado,
            :cep
        )";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':razao_social', $razao_social, PDO::PARAM_STR);
        $stmt->bindParam(':cnpj', $cnpj, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);
        $stmt->bindParam(':logradouro', $logradouro);
        $stmt->bindParam(':numero', $numero);
        $stmt->bindParam(':complemento', $complemento, is_null($complemento) ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindParam(':bairro', $bairro);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':cep', $cep);

        $stmt->execute();

        $result = array(
            'status' => 'success',
            'message' => 'Fornecedor cadastrado com sucesso!'
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
