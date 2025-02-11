<?
require_once __DIR__ . '/../../utils/XmlParser.php';
require_once __DIR__ . '/../../utils/ImportValidator.php';
require_once __DIR__ . '/PartnerService.php';
require_once __DIR__ . '/OrderService.php';

class PartnerImportService {
    private PartnerService $partnerService;
    private OrderService $orderService;

    public function __construct() {
        $this->partnerService = new PartnerService();
        $this->orderService = new OrderService();
    }

    public function prepareImport(string $xmlContent): array {
        try {
            $xml = simplexml_load_string($xmlContent);
            if ($xml === false) {
                throw new Exception("Erro ao processar o XML.");
            }

            $pedidos = [];
            foreach ($xml->pedido as $pedido) {
                $pedidos[] = [
                    'id_loja'    => (string)$pedido->id_loja,
                    'nome_loja'  => (string)$pedido->nome_loja,
                    'localizacao' => (string)$pedido->localizacao,
                    'produto'    => (string)$pedido->produto,
                    'quantidade' => (int)$pedido->quantidade
                ];
            }

            return ['pedidos' => $pedidos];
        } catch (Exception $e) {
            throw new Exception("Erro ao preparar importação: " . $e->getMessage());
        }
    }

    public function processImport(array $importData, array $values) {
        $result = ['success' => 0, 'errors' => 0];
        
        foreach ($importData['pedidos'] as $key => $pedido) {
            try {
                $this->validateValue($values[$key]);
                $this->createPartnerIfNeeded($pedido);
                $this->createOrder($pedido, $values[$key]);
                $result['success']++;
            } catch (Exception $e) {
                error_log("Erro no pedido {$key}: " . $e->getMessage());
                $result['errors']++;
            }
        }
        
        return $result;
    }

    private function validateValue(float $value) {
        if ($value <= 0) {
            throw new Exception("Valor inválido: " . $value);
        }
    }

    private function createPartnerIfNeeded(array $pedido) {
        try {
            $result = $this->partnerService->createPartner([
                'id_loja' => (int)$pedido['id_loja'],
                'nome_loja' => $pedido['nome_loja'],
                'localizacao' => $pedido['localizacao']
            ]);
    
            if (!$result['success']) {
                throw new Exception("Falha ao criar parceiro: " . $result['message']);
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw $e;
        }
    }

    private function createOrder(array $pedido, float $valor) {
        $this->orderService->createOrderFromImport([
            'id_loja' => $pedido['id_loja'],
            'produto' => $pedido['produto'],
            'quantidade' => $pedido['quantidade'],
            'valor' => $valor
        ]);
    }
}
?>