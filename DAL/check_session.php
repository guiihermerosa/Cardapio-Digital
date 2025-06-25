<?php
session_start();
header('Content-Type: application/json');
if (isset($_SESSION['usuario'])) {
    echo json_encode([
        'logged' => true,
        'nome' => $_SESSION['usuario']['nome'],
        'email' => $_SESSION['usuario']['email'],
        'tipo' => $_SESSION['usuario']['tipo']
    ]);
} else {
    echo json_encode(['logged' => false]);
} 