<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/database.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

class ClientImporter {
    const PRODUTO_PADRAO = "Produto Não Especificado";
    const QUANTIDADE_PADRAO = 1;

    public function importFromFile($fileTmpPath) {
        try {
            $spreadsheet = IOFactory::load($fileTmpPath);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, true, true, true);

            $header = array_shift($data);
            $results = [
                'clientes' => 0,
                'pedidos' => 0,
                'erros' => []
            ];

            foreach ($data as $row) {
                try {
                    $clientId = $this->processClient($row);
                    $results['clientes']++;

                    if ($this->processOrder($row, $clientId)) {
                        $results['pedidos']++;
                    }
                } catch (Exception $e) {
                    $results['erros'][] = "Linha {$row['A']}: " . $e->getMessage();
                }
            }

            return $this->formatResult($results);
            
        } catch (Exception $e) {
            return "Erro fatal: " . $e->getMessage();
        }
    }

    private function processClient($row) {
        $pdo = Database::getConnection();
        
        $stmt = $pdo->prepare("INSERT INTO clients (nome_cliente, email) 
                               VALUES (:nome, :email)");
        
        $stmt->execute([
            ':nome' => $row['B'],
            ':email' => $row['C']
        ]);

        return $pdo->lastInsertId();
    }

    private function processOrder($row, $clientId) {
        // Extração correta das colunas (F = valor, E = data)
        $valor = $this->parseValor($row['F'] ?? 0);
        $data = $this->parseData($row['E'] ?? null);
    
        // Permite valor 0 ou positivo
        if ($valor < 0) {
            throw new Exception("Valor negativo - Cliente: {$row['B']}");
        }
    
        $pdo = Database::getConnection();
        
        $stmt = $pdo->prepare("
            INSERT INTO orders (
                id_cliente,
                produto,
                quantidade,
                valor,
                ultima_atualizacao,
                id_loja
            ) VALUES (
                :id_cliente,
                :produto,
                :quantidade,
                :valor,
                :data,
                NULL
            )
        ");
    
        return $stmt->execute([
            ':id_cliente' => $clientId,
            ':produto' => $this->getProduto($row['D'] ?? ''),
            ':quantidade' => self::QUANTIDADE_PADRAO,
            ':valor' => $valor,
            ':data' => $data
        ]);
    }
    
    private function parseValor($valor) {
        $textNumbers = [
            'cinquenta' => 50,    'cem' => 100,
            'mil' => 1000,        'zero' => 0,
            'um' => 1,            'dois' => 2,
            'três' => 3,          'quatro' => 4,
            'cinco' => 5,         'dez' => 10,
            'vinte' => 20,        'trinta' => 30,
            'quarenta' => 40,     'sessenta' => 60,
            'oitenta' => 80,      'noventa' => 90
        ];
        
        $cleanValor = strtolower(trim(str_replace(['$', 'R$'], '', $valor)));
        
        if (isset($textNumbers[$cleanValor])) {
            return $textNumbers[$cleanValor];
        }
        
        if (preg_match('/(\d+[\.,]?\d*)/', $cleanValor, $matches)) {
            return (float) str_replace(',', '.', $matches[1]);
        }
        
        return (float) $cleanValor;
    }

    private function getProduto($historico) {
        return !empty($historico) ? $historico : self::PRODUTO_PADRAO;
    }
    private function parseData($data) {
        try {
            if (empty($data)) return date('Y-m-d H:i:s');
            
            if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $data)) {
                return DateTime::createFromFormat('d/m/Y', $data)->format('Y-m-d H:i:s');
            }
            
            return (new DateTime($data))->format('Y-m-d H:i:s');
        } catch (Exception $e) {
            return date('Y-m-d H:i:s');
        }
    }

    private function formatResult($results) {
        $message = "Clientes importados: {$results['clientes']}\n";
        $message .= "Pedidos criados: {$results['pedidos']}\n";
        
        if (!empty($results['erros'])) {
            $message .= "\nErros:\n- " . implode("\n- ", $results['erros']);
        }

        return $message;
    }
}