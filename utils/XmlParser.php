<?php

require_once __DIR__ . '/ImportValidator.php';
class XmlParser {
  public static function parseOrders(string $xmlContent): array {
      try {
          $xml = simplexml_load_string($xmlContent);
          $parsed = [];
          
          foreach ($xml->pedido as $pedido) {
              $parsed[] = [
                  'id_loja' => (string)$pedido->id_loja,
                  'nome_loja' => (string)$pedido->nome_loja,
                  'localizacao' => (string)$pedido->localizacao,
                  'produto' => (string)$pedido->produto,
                  'quantidade' => (int)$pedido->quantidade
              ];
          }
          
          return $parsed;
      } catch (Exception $e) {
          throw new Exception("XML parsing failed: " . $e->getMessage());
      }
  }
}