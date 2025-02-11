<?php
abstract class BaseController {
    protected function setFlash(string $message, string $type = 'success'): void {
        $_SESSION['flash_message'] = ['message' => $message, 'type' => $type];
    }

}
?>
