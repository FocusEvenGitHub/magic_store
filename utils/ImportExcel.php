<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/database.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ClientImporter {

  public function importFromFile($fileTmpPath) {
      try {
          $spreadsheet = IOFactory::load($fileTmpPath);
          $sheet = $spreadsheet->getActiveSheet();
          $data = $sheet->toArray(null, true, true, true); 
          
          foreach ($data as $index => $row) {
            if ($index === 1) {
              continue;
            }

              $nome = $row['A'];  
              $documento = $row['B'];  
              $cep = $row['C'];  
              $endereco = $row['D'];  
              $bairro = $row['E'];  
              $cidade = $row['F']; 
              $uf = $row['G'];  
              $telefone = $row['H'];  
              $email = $row['I'];  
              $ativo = ($row['J'] == 'SIM') ? 1 : 0;  

              $this->insertClient($nome, $documento, $cep, $endereco, $bairro, $cidade, $uf, $telefone, $email, $ativo);
          }

          return "Importação concluída com sucesso!";
      } catch (Exception $e) {
          return "Erro ao importar o arquivo: " . $e->getMessage();
      }
  }

  private function insertClient($nome, $documento, $cep, $endereco, $bairro, $cidade, $uf, $telefone, $email, $ativo) {
      $pdo = Database::getConnection();
    
      $stmt = $pdo->prepare("INSERT INTO clients (nome, documento, cep, endereco, bairro, cidade, uf, telefone, email, ativo) 
                             VALUES (:nome, :documento, :cep, :endereco, :bairro, :cidade, :uf, :telefone, :email, :ativo)");

      $stmt->bindParam(':nome', $nome);
      $stmt->bindParam(':documento', $documento);
      $stmt->bindParam(':cep', $cep);
      $stmt->bindParam(':endereco', $endereco);
      $stmt->bindParam(':bairro', $bairro);
      $stmt->bindParam(':cidade', $cidade);
      $stmt->bindParam(':uf', $uf);
      $stmt->bindParam(':telefone', $telefone);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);

      $stmt->execute();
  }
}

