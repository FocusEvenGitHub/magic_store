<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/database.php';

$pdo = Database::getConnection();

$migrations = [
    "CREATE TABLE IF NOT EXISTS clients (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nome_cliente VARCHAR(255) ,
    email VARCHAR(255) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

    "CREATE TABLE IF NOT EXISTS partners (
    id_loja INT AUTO_INCREMENT PRIMARY KEY,
    nome_loja VARCHAR(255) ,
    localizacao VARCHAR(255) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

    "CREATE TABLE IF NOT EXISTS orders (
    id_order INT AUTO_INCREMENT PRIMARY KEY,
    id_loja INT ,
    id_cliente INT ,
    produto VARCHAR(255) ,
    quantidade INT ,
    valor DECIMAL(10, 2) ,
    ultima_atualizacao DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_loja) REFERENCES partners(id_loja) ON DELETE CASCADE,
    FOREIGN KEY (id_cliente) REFERENCES clients(id_cliente) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

    "CREATE TABLE IF NOT EXISTS email_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        id_cliente INT NOT NULL,
        subject VARCHAR(255) ,
        message TEXT ,
        sent_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_cliente) REFERENCES clients(id_cliente)
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
