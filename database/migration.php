<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/database.php';

$pdo = Database::getConnection();

$migrations = [
    "CREATE TABLE IF NOT EXISTS clients (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(255) NOT NULL,
        documento VARCHAR(50) NOT NULL,
        cep VARCHAR(50),
        endereco VARCHAR(255),
        bairro VARCHAR(100),
        cidade VARCHAR(100),
        uf VARCHAR(5),
        telefone VARCHAR(30) NULL,
        email VARCHAR(255) NOT NULL,
        ativo TINYINT(1) DEFAULT 1
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    "CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        client_id INT NOT NULL,
        product_details TEXT NOT NULL,
        status ENUM('pending','processing','shipped','delivered') DEFAULT 'pending',
        order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    "CREATE TABLE IF NOT EXISTS email_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        client_id INT NOT NULL,
        subject VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        sent_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (client_id) REFERENCES clients(id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
];

echo "<pre>";
foreach ($migrations as $sql) {
    try {
        $pdo->exec($sql);
        echo "Migration executada com sucesso: " . substr($sql, 0, 50) . "...\n";
    } catch (PDOException $e) {
        echo "Erro ao executar migration: " . $e->getMessage() . "\n";
    }
}
echo "</pre>";
