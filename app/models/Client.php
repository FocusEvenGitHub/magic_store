<?php

class Client {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll() {
        $stmt = $this->db->query('SELECT * FROM clients');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->db->prepare('SELECT * FROM clients WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data) {
        $stmt = $this->db->prepare('
            INSERT INTO clients (nome, documento, cep, endereco, bairro, cidade, uf, telefone, email, ativo) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ');

        return $stmt->execute([
            $data['nome'],       
            $data['documento'], 
            $data['cep'], 
            $data['endereco'], 
            $data['bairro'], 
            $data['cidade'], 
            $data['uf'], 
            $data['telefone'], 
            $data['email'], 
            $data['ativo']
        ]);
    }

    public function update($id, array $data) {
        $stmt = $this->db->prepare('
            UPDATE clients 
            SET nome = ?,
                documento = ?,
                cep = ?, 
                endereco = ?, 
                bairro = ?, 
                cidade = ?, 
                uf = ?, 
                telefone = ?, 
                email = ?, 
                ativo = ?
            WHERE id = ?
        ');

        return $stmt->execute([
            $data['nome'],       
            $data['documento'], 
            $data['cep'], 
            $data['endereco'], 
            $data['bairro'], 
            $data['cidade'], 
            $data['uf'], 
            $data['telefone'], 
            $data['email'], 
            $data['ativo'], 
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare('DELETE FROM email_logs WHERE client_id = ?');
        $stmt->execute([$id]);
    
        $stmt = $this->db->prepare('DELETE FROM clients WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
?>
