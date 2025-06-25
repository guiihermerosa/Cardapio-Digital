<?php
  session_start();
  include_once 'conexao.php';
  $erro = '';
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    if ($email && $senha) {
      $db = new DAL\conexao();
      $pdo = $db->conectar();
      $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
      $stmt->execute([$email]);
      $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($usuario && $senha === $usuario['senha']) {
        $_SESSION['usuario'] = [
          'id' => $usuario['id'],
          'nome' => $usuario['nome'],
          'email' => $usuario['email'],
          'tipo' => $usuario['tipo']
        ];
        
        // Redirecionar baseado no tipo de usuário
        if ($usuario['tipo'] === 'admin') {
          header('Location: ../VIEW/admin.php');
        } else {
          header('Location: ../VIEW/pedidos.php');
        }
        exit;
      } else {
        $erro = 'E-mail ou senha inválidos!';
      }
    } else {
      $erro = 'Preencha todos os campos!';
    }
  }
?>
<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="d-flex justify-content-center align-items-center min-vh-100 bg-body-tertiary">
    <main class="w-100" style="max-width: 330px;">
        <form method="POST">
            <img src="#" alt="Logo" class="mb-4" height="57" width="72">
            <h1 class="h3 mb-3 fw-normal text-center">Faça o Login</h1>
            <?php if ($erro): ?>
                <div class="alert alert-danger"><?= $erro ?></div>
            <?php endif; ?>
            <div class="form-floating mb-2">
                <input type="email" class="form-control" id="floatingInput" name="email" placeholder="seu-email@gmail.com" required>
                <label for="floatingInput">E-mail</label>
            </div>
            <div class="form-floating mb-2">
                <input type="password" class="form-control" id="floatingPassword" name="senha" placeholder="Senha" required>
                <label for="floatingPassword">Senha</label>
            </div>
            <div class="form-check text-start my-3">
                <input type="checkbox" class="form-check-input" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">Lembre-me</label>
            </div>
            <button class="btn btn-primary w-100 py-2" type="submit">Entrar</button>
        </form>
    </main>
</body>
</html>
