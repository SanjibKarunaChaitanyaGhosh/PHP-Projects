<?php

function jsonRes(array $data): void {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function sanitize(string $s): string {
    return htmlspecialchars(trim($s), ENT_QUOTES, 'UTF-8');
}
?>