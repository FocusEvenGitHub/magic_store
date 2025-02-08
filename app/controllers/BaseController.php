<?php
abstract class BaseController {
    protected function setFlash(string $message, string $type = 'success'): void {
        $_SESSION['flash_message'] = ['message' => $message, 'type' => $type];
    }

    protected function validateId($id) {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            $this->setFlash('ID inválido.', 'error');
            $this->redirectTo('/clients');
        }
        return $id;
    }
}
?>
