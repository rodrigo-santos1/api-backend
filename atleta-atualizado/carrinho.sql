CREATE TABLE CARRINHO (
    CAR_IDCARRINHO INT NOT NULL AUTO_INCREMENT,
    CLI_IDCLIENTE INT NOT NULL,
    PRO_IDPRODUTO INT NOT NULL,
    CAR_QUANTIDADE INT NOT NULL,
    PRIMARY KEY (CAR_IDCARRINHO),
    FOREIGN KEY (CLI_IDCLIENTE) REFERENCES CLIENTE(CLI_IDCLIENTE),
    FOREIGN KEY (PRO_IDPRODUTO) REFERENCES PRODUTO(PRO_IDPRODUTO)
);