<?php
header('Content-Type: application/json');
include_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    http_response_code(400);
    echo json_encode(['error' => 'Dados inválidos']);
    exit;
}

// Log para debug
error_log('Dados recebidos: ' . print_r($data, true));

$nome = $data['name'] ?? '';
$email = $data['email'] ?? '';
$telefone = $data['phone'] ?? '';
$endereco = $data['address'] ?? '';
$total = $data['total'] ?? 0;
$itens = $data['items'] ?? [];

// Log para debug
error_log('Dados processados - Nome: ' . $nome . ', Email: ' . $email . ', Total: ' . $total . ', Itens: ' . count($itens));

if (!$nome || !$email || !$telefone || !$endereco || !$total || !is_array($itens) || count($itens) == 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Campos obrigatórios ausentes']);
    exit;
}

try {
    $db = new DAL\conexao();
    $pdo = $db->conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->beginTransaction();

    // Inserir pedido (sem user_id para usuários não logados)
    $stmt = $pdo->prepare('INSERT INTO orders (customer_name, customer_email, customer_phone, customer_address, total, status) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$nome, $email, $telefone, $endereco, $total, 'pendente']);
    $orderId = $pdo->lastInsertId();
    error_log('Pedido inserido - ID: ' . $orderId);

    // Inserir itens do pedido
    $stmtItem = $pdo->prepare('INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)');
    foreach ($itens as $item) {
        $stmtItem->execute([$orderId, $item['id'], $item['quantity'], $item['price']]);
        error_log('Item inserido - Order ID: ' . $orderId . ', Product ID: ' . $item['id'] . ', Quantity: ' . $item['quantity'] . ', Price: ' . $item['price']);
    }

    $pdo->commit();
    echo json_encode(['success' => true, 'order_id' => $orderId]);
} catch (Exception $e) {
    if ($pdo && $pdo->inTransaction()) $pdo->rollBack();
    error_log('Erro na inserção do pedido: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao salvar pedido', 'details' => $e->getMessage()]);
} 