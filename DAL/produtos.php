<?php
session_start();
header('Content-Type: application/json');
include_once 'conexao.php';

$method = $_SERVER['REQUEST_METHOD'];
error_log('=== PRODUTOS.PHP DEBUG ===');
error_log('Método HTTP: ' . $method);
error_log('Sessão atual: ' . print_r($_SESSION, true));
error_log('Dados de entrada: ' . file_get_contents('php://input'));

try {
    $db = new DAL\conexao();
    $pdo = $db->conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    error_log('Conexão com banco estabelecida');

    if ($method === 'GET') {
        // Listar produtos
        error_log('Executando query para listar produtos');
        $produtos = $pdo->query('SELECT * FROM products ORDER BY created DESC')->fetchAll(PDO::FETCH_ASSOC);
        error_log('Produtos encontrados no banco: ' . print_r($produtos, true));
        echo json_encode(['success' => true, 'produtos' => $produtos]);
        exit;
    }

    error_log('Verificando autorização - Sessão: ' . print_r($_SESSION, true));
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
        error_log('Usuário não autorizado - Sessão: ' . print_r($_SESSION, true));
        http_response_code(401);
        echo json_encode(['error' => 'Não autorizado', 'session' => $_SESSION]);
        exit;
    }
    error_log('Usuário autorizado: ' . $_SESSION['usuario']['nome']);

    if ($method === 'POST') {
        // Adicionar produto
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data || !isset($data['name'], $data['price'], $data['category'], $data['description'], $data['image'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Dados incompletos']);
            exit;
        }
        $stmt = $pdo->prepare('INSERT INTO products (name, description, price, category, image) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([
            $data['name'],
            $data['description'],
            $data['price'],
            $data['category'],
            $data['image']
        ]);
        echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
        exit;
    }

    if ($method === 'DELETE') {
        // Remover produto
        $data = json_decode(file_get_contents('php://input'), true);
        error_log('Dados recebidos para DELETE: ' . print_r($data, true));
        
        if (!$data || !isset($data['id'])) {
            error_log('ID não informado para DELETE');
            http_response_code(400);
            echo json_encode(['error' => 'ID não informado']);
            exit;
        }
        
        error_log('Tentando remover produto ID: ' . $data['id']);
        
        // Verificar se o produto existe
        $stmt = $pdo->prepare('SELECT id FROM products WHERE id = ?');
        $stmt->execute([$data['id']]);
        if (!$stmt->fetch()) {
            error_log('Produto não encontrado para remoção - ID: ' . $data['id']);
            http_response_code(404);
            echo json_encode(['error' => 'Produto não encontrado']);
            exit;
        }
        
        error_log('Produto encontrado, verificando se está em uso');
        
        // Verificar se há pedidos usando este produto
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM order_items WHERE product_id = ?');
        $stmt->execute([$data['id']]);
        $count = $stmt->fetchColumn();
        error_log('Produto usado em ' . $count . ' pedidos');
        
        // Iniciar transação para garantir consistência
        $pdo->beginTransaction();
        
        try {
            if ($count > 0) {
                error_log('Removendo itens de pedidos relacionados primeiro');
                // Remover todos os itens de pedidos que usam este produto
                $stmt = $pdo->prepare('DELETE FROM order_items WHERE product_id = ?');
                $stmt->execute([$data['id']]);
                error_log('Itens de pedidos removidos com sucesso');
            }
            
            error_log('Executando DELETE do produto');
            $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
            $stmt->execute([$data['id']]);
            
            // Confirmar transação
            $pdo->commit();
            
            error_log('Produto removido com sucesso - ID: ' . $data['id']);
            echo json_encode(['success' => true, 'message' => 'Produto removido com sucesso']);
            exit;
            
        } catch (Exception $e) {
            // Reverter transação em caso de erro
            $pdo->rollBack();
            error_log('Erro durante remoção: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Erro ao remover produto: ' . $e->getMessage()]);
            exit;
        }
    }

    if ($method === 'PUT') {
        // Editar produto
        $data = json_decode(file_get_contents('php://input'), true);
        error_log('Dados recebidos para PUT: ' . print_r($data, true));
        
        if (!$data || !isset($data['id'], $data['name'], $data['price'], $data['category'], $data['description'], $data['image'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Dados incompletos']);
            exit;
        }
        
        // Verificar se o produto existe
        $stmt = $pdo->prepare('SELECT id FROM products WHERE id = ?');
        $stmt->execute([$data['id']]);
        if (!$stmt->fetch()) {
            http_response_code(404);
            echo json_encode(['error' => 'Produto não encontrado']);
            exit;
        }
        
        $stmt = $pdo->prepare('UPDATE products SET name = ?, description = ?, price = ?, category = ?, image = ? WHERE id = ?');
        $stmt->execute([
            $data['name'],
            $data['description'],
            $data['price'],
            $data['category'],
            $data['image'],
            $data['id']
        ]);
        error_log('Produto atualizado com sucesso - ID: ' . $data['id']);
        echo json_encode(['success' => true]);
        exit;
    }

    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
} catch (Exception $e) {
    error_log('Erro no produtos.php: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Erro no servidor', 'details' => $e->getMessage()]);
} 