<?php
class ImportValidator {
    public static function validateImportData(array $rawData): array {
        $validated = ['orders' => []];
        
        foreach ($rawData as $index => $order) {
            try {
                self::validateOrder($order, $index);
                $validated['orders'][] = $order;
            } catch (Exception $e) {
                error_log("Validation error on item $index: " . $e->getMessage());
            }
        }
        
        if (empty($validated['orders'])) {
            throw new Exception("Nenhum pedido válido encontrado no arquivo");
        }
        
        return $validated;
    }

    private static function validateOrder(array $order, int $index): void {
        $requiredFields = [
            'id_loja' => 'string',
            'nome_loja' => 'string',
            'produto' => 'string',
            'quantidade' => 'integer'
        ];
        
        foreach ($requiredFields as $field => $type) {
            if (!isset($order[$field])) { 
                throw new Exception("Campo obrigatório ausente: $field no item $index");
            }
            if (gettype($order[$field]) !== $type) {
                throw new Exception("Tipo inválido para o campo $field no item $index. Esperado: $type");
            }
        }
    }
}
?>