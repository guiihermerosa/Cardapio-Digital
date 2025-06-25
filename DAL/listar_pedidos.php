<?php
session_start();
header('Content-Type: application/json');
include_once 'conexao.php';

// Log para debug
error_log('Verificando sessão: ' . print_r($_SESSION, true));

if (!isset($_SESSION['usuario'])) {
    error_log('Usuário não logado');
    http_response_code(401);
    echo json_encode(['error' => 'Não autorizado']);
    exit;
}

try {
    $db = new DAL\conexao();
    $pdo = $db->conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    error_log('Usuário logado - Tipo: ' . $_SESSION['usuario']['tipo']);

    // Buscar pedidos baseado no tipo de usuário
    if ($_SESSION['usuario']['tipo'] === 'admin') {
        // Admin vê todos os pedidos
        $sql = 'SELECT * FROM orders ORDER BY created DESC';
        $pedidos = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        error_log('Admin - Pedidos encontrados: ' . count($pedidos));
    } else {
        // Cliente também vê todos os pedidos
        $sql = 'SELECT * FROM orders ORDER BY created DESC';
        $pedidos = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        error_log('Cliente - Pedidos encontrados: ' . count($pedidos));
    }

    // Buscar itens de cada pedido
    foreach ($pedidos as &$pedido) {
        $stmt = $pdo->prepare('SELECT oi.*, p.name, p.image FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?');
        $stmt->execute([$pedido['id']]);
        $pedido['items'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        error_log('Itens do pedido ' . $pedido['id'] . ': ' . count($pedido['items']));
    }

    echo json_encode(['success' => true, 'pedidos' => $pedidos]);
} catch (Exception $e) {
    error_log('Erro na listagem de pedidos: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao buscar pedidos', 'details' => $e->getMessage()]);
} 