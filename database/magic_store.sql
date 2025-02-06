
CREATE TABLE IF NOT EXISTS `clients` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(255) ,
    `documento` VARCHAR(50) ,
    `cep` VARCHAR(50) ,
    `endereco` VARCHAR(255) ,
    `bairro` VARCHAR(100) ,
    `cidade` VARCHAR(100) ,
    `uf` VARCHAR(5) ,
    `telefone` VARCHAR(30) NULL,
    `email` VARCHAR(255) ,
    `ativo` TINYINT(1)  DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    client_id INT NOT NULL,
    product_details TEXT NOT NULL,
    status ENUM('pending','processing','shipped','delivered') DEFAULT 'pending',
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE
);

CREATE TABLE email_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    client_id INT NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    sent_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id)
);
