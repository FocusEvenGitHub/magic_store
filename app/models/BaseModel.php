<?php
namespace App\Models;
use Database;

class BaseModel {
    protected $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }
}
?>
