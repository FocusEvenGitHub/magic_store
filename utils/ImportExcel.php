<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/database.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

class ClientImporter {

    public function importFromFile($fileTmpPath) {
        try {
            $spreadsheet = IOFactory::load($fileTmpPath);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, true, true, true); 

            array_shift($data);

            foreach ($data as $row) {
                $idCliente = $row['A'];
                $nome = $row['B'];     
                $email = $row['C'];    
                $historicoPedidos = $row['D']; 
                $data = $row['E'];     
                $ultimoPedido = $row['F']; 
                $valorUltimoPedido = $row['G']; 

                $this->insertClient($idCliente, $nome, $email);
            }

            return "Importação concluída com sucesso!";
        } catch (Exception $e) {
            return "Erro ao importar o arquivo: " . $e->getMessage();
        }
    }

    private function insertClient($idCliente, $nome, $email) {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("INSERT INTO clients (nome_cliente, email) 
                               VALUES (:nome_cliente, :email)");

        $stmt->bindParam(':nome_cliente', $nome);
        $stmt->bindParam(':email', $email);

        $stmt->execute();
    }
}