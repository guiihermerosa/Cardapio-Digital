<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos - Cardápio Digital</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .orders-container {
            max-width: 1000px;
            margin: 100px auto 0;
            padding: 2rem;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        .order {
            border-bottom: 1px solid #eee;
            padding: 1.5rem 0;
        }
        .order:last-child {
            border-bottom: none;
        }
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        .order-id {
            font-weight: bold;
            color: #e74c3c;
        }
        .order-status {
            padding: 0.3rem 1rem;
            border-radius: 20px;
            background: #eee;
            font-size: 0.9rem;
        }
        .order-status.pendente { background: #f9e79f; color: #b7950b; }
        .order-status.finalizado { background: #d4efdf; color: #229954; }
        .order-status.cancelado { background: #fadbd8; color: #c0392b; }
        .order-customer {
            margin-bottom: 0.5rem;
        }
        .order-items {
            margin-top: 1rem;
        }
        .order-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.7rem;
        }
        .order-item img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
        .order-total {
            font-weight: bold;
            color: #e74c3c;
            margin-top: 1rem;
        }
        .nav-user {
            margin-left: auto;
        }
        .btn-logout {
            background-color: #e74c3c;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .btn-logout:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <header class="header">
        <nav class="nav-container">
            <div class="logo">
                <h1>Cardápio Digital</h1>
            </div>
            <div class="nav-links">
                <a href="index.php">Início</a>
                <a href="menu.php">Cardápio</a>
                <a href="about.php">Sobre</a>
                <a href="contact.php">Contato</a>
                <a href="pedidos.php" class="active">Pedidos</a>
            </div>
            <div class="nav-user">
                <a href="../DAL/logout.php" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Sair
                </a>
            </div>
        </nav>
    </header>
    <main class="orders-container">
        <h1>Pedidos do Sistema</h1>
        <p>Visualize todos os pedidos realizados</p>
        <div id="ordersList">Carregando pedidos...</div>
    </main>
    <script>
    // Proteção de página: só acessa se estiver logado
    fetch('../DAL/check_session.php')
        .then(r => r.json())
        .then(data => { 
            if (!data.logged) {
                window.location.href = '../DAL/login.php';
            } else if (data.tipo === 'admin') {
                // Se for admin, redireciona para admin.php
                window.location.href = 'admin.php';
            }
        });

    fetch('../DAL/listar_pedidos.php')
        .then(r => {
            if (!r.ok) {
                throw new Error(`HTTP error! status: ${r.status}`);
            }
            return r.json();
        })
        .then(data => {
            console.log('Dados recebidos:', data);
            const container = document.getElementById('ordersList');
            if (!data.success || !data.pedidos.length) {
                container.innerHTML = '<p>Nenhum pedido encontrado.</p>';
                return;
            }
            container.innerHTML = '';
            data.pedidos.forEach(pedido => {
                const div = document.createElement('div');
                div.className = 'order';
                div.innerHTML = `
                    <div class="order-header">
                        <span class="order-id">Pedido #${pedido.id}</span>
                        <span class="order-status ${pedido.status}">${pedido.status}</span>
                        <span>${new Date(pedido.created).toLocaleString('pt-BR')}</span>
                    </div>
                    <div class="order-customer">
                        <strong>Cliente:</strong> ${pedido.customer_name} <br>
                        <strong>Email:</strong> ${pedido.customer_email} <br>
                        <strong>Telefone:</strong> ${pedido.customer_phone}
                    </div>
                    <div class="order-items">
                        <strong>Itens:</strong>
                        <ul style="margin:0; padding-left:1.2em;">
                            ${pedido.items.map(item => `
                                <li class="order-item">
                                    <img src="${item.image}" alt="${item.name}">
                                    <span>${item.name} (x${item.quantity}) - R$ ${parseFloat(item.price).toFixed(2).replace('.', ',')}</span>
                                </li>
                            `).join('')}
                        </ul>
                    </div>
                    <div class="order-total">Total: R$ ${parseFloat(pedido.total).toFixed(2).replace('.', ',')}</div>
                `;
                container.appendChild(div);
            });
        })
        .catch((error) => {
            console.error('Erro:', error);
            document.getElementById('ordersList').innerHTML = '<p>Erro ao carregar pedidos: ' + error.message + '</p>';
        });
    </script>
</body>
</html> 