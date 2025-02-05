<?php
require_once __DIR__ . '/../../config/database.php';

class Client {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll() {
        $stmt = $this->db->prepare('SELECT * FROM clients');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->db->prepare('SELECT * FROM clients WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data) {
        $stmt = $this->db->prepare('INSERT INTO clients (name, email, magical_id) VALUES (?, ?, ?)');
        return $stmt->execute([$data['name'], $data['email'], $data['magical_id']]);
    }

    public function update($id, array $data) {
        $stmt = $this->db->prepare('UPDATE clients SET name = ?, email = ?, magical_id = ? WHERE id = ?');
        return $stmt->execute([$data['name'], $data['email'], $data['magical_id'], $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare('DELETE FROM clients WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare('SELECT * FROM clients WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function countAll() {
        $stmt = $this->db->prepare('SELECT COUNT(*) as total FROM clients');
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}
