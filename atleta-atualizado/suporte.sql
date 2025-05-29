CREATE TABLE suporte (
    sup_idsuporte INT NOT NULL AUTO_INCREMENT,
    sup_nome VARCHAR(100) NOT NULL,
    sup_email VARCHAR(100) NOT NULL,
    sup_whatsapp CHAR(11) NULL,
    sup_mensagem TEXT NOT NULL,
    cli_idcliente INT NOT NULL,
    for_idfornecedor INT NOT NULL,
    sup_data TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    sup_descricao TEXT NOT NULL,
    PRIMARY KEY (sup_idsuporte),
    FOREIGN KEY (cli_idcliente) REFERENCES cliente(cli_idcliente),
    FOREIGN KEY (for_idfornecedor) REFERENCES fornecedor(for_idfornecedor)
);