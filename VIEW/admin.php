<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração de Pratos - Cardápio Digital</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .admin-container {
            max-width: 600px;
            margin: 120px auto 0;
            padding: 2rem;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        .admin-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .admin-header h1 {
            font-size: 2rem;
            color: #333;
        }
        .admin-form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .admin-form input, .admin-form select, .admin-form textarea {
            padding: 0.7rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .admin-form button {
            padding: 0.8rem;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .admin-form button:hover {
            background-color: #c0392b;
        }
        .admin-list {
            margin-top: 2rem;
        }
        .admin-list-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            border-bottom: 1px solid #eee;
        }
        .admin-list-item img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 1rem;
        }
        .admin-list-info {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .admin-list-remove {
            background: #e74c3c;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 0.5rem 1rem;
            cursor: pointer;
        }
        .admin-list-remove:hover {
            background: #c0392b;
        }
        .admin-list-actions {
            display: flex;
            gap: 0.5rem;
        }
        .admin-list-edit {
            background: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 0.5rem 1rem;
            cursor: pointer;
        }
        .admin-list-edit:hover {
            background: #2980b9;
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
                <h1>Cardápio Digital - Admin</h1>
            </div>
            <div class="nav-links">
                <a href="index.php">Início</a>
                <a href="menu.php">Cardápio</a>
                <a href="pedidos.php">Pedidos</a>
                <a href="admin.php" class="active">Admin</a>
            </div>
            <div class="nav-user">
                <a href="../../DAL/logout.php" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Sair
                </a>
            </div>
        </nav>
    </header>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Administração de Pratos</h1>
            <p>Adicione ou remova pratos do cardápio</p>
        </div>
        <form class="admin-form" id="addDishForm">
            <input type="hidden" id="editId" value="">
            <input type="text" id="dishName" placeholder="Nome do prato" required>
            <input type="number" id="dishPrice" placeholder="Preço (ex: 29.90)" step="0.01" required>
            <select id="dishCategory" required>
                <option value="">Selecione a categoria</option>
                <option value="pratos-principais">Pratos Principais</option>
                <option value="entradas">Entradas</option>
                <option value="sobremesas">Sobremesas</option>
                <option value="bebidas">Bebidas</option>
            </select>
            <textarea id="dishDescription" placeholder="Descrição" required></textarea>
            <input type="url" id="dishImage" placeholder="URL da imagem" required>
            <button type="submit" id="submitBtn">Adicionar Prato</button>
            <button type="button" id="cancelEditBtn" style="display:none; background-color: #95a5a6;">Cancelar Edição</button>
        </form>
        <div class="admin-list" id="dishList">
            <!-- Lista de pratos adicionados -->
        </div>
    </div>
    <script>
        // Proteção de página: só acessa se estiver logado como admin
        fetch('../../DAL/check_session.php')
            .then(r => r.json())
            .then(data => { 
                if (!data.logged) {
                    window.location.href = '../../DAL/login.php';
                } else if (data.tipo !== 'admin') {
                    // Se não for admin, redireciona para pedidos.php
                    window.location.href = 'pedidos.php';
                }
            });
        // AJAX para produtos
        async function fetchProdutos() {
            const res = await fetch('../../DAL/produtos.php');
            const data = await res.json();
            console.log('Produtos carregados na admin:', data);
            console.log('Array de produtos:', data.produtos);
            console.log('Quantidade de produtos:', data.produtos ? data.produtos.length : 0);
            if (data.produtos && data.produtos.length > 0) {
                console.log('Primeiro produto:', data.produtos[0]);
            }
            return data.produtos || [];
        }
        async function addProduto(produto) {
            const res = await fetch('../../DAL/produtos.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(produto)
            });
            return await res.json();
        }
        async function removeProduto(id) {
            console.log('Tentando remover produto com ID:', id);
            console.log('Tipo do ID:', typeof id);
            
            try {
                const res = await fetch('../../DAL/produtos.php', {
                    method: 'DELETE',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: parseInt(id) })
                });
                
                console.log('Resposta da remoção:', res);
                console.log('Status da resposta:', res.status);
                console.log('Headers da resposta:', res.headers);
                
                if (!res.ok) {
                    const errorText = await res.text();
                    console.error('Resposta de erro:', errorText);
                    throw new Error(`HTTP error! status: ${res.status}, response: ${errorText}`);
                }
                
                const result = await res.json();
                console.log('Resultado JSON da remoção:', result);
                return result;
            } catch (error) {
                console.error('Erro na função removeProduto:', error);
                throw error;
            }
        }
        
        async function editProduto(produto) {
            const res = await fetch('../../DAL/produtos.php', {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(produto)
            });
            
            if (!res.ok) {
                const errorData = await res.json();
                throw new Error(errorData.error || `HTTP error! status: ${res.status}`);
            }
            
            return await res.json();
        }
        
        function fillEditForm(dish) {
            document.getElementById('editId').value = dish.id;
            document.getElementById('dishName').value = dish.name || '';
            document.getElementById('dishPrice').value = dish.price || '';
            document.getElementById('dishCategory').value = dish.category || '';
            document.getElementById('dishDescription').value = dish.description || '';
            document.getElementById('dishImage').value = dish.image || '';
            
            document.getElementById('submitBtn').textContent = 'Atualizar Prato';
            document.getElementById('cancelEditBtn').style.display = 'inline-block';
        }
        
        function clearEditForm() {
            document.getElementById('editId').value = '';
            document.getElementById('dishName').value = '';
            document.getElementById('dishPrice').value = '';
            document.getElementById('dishCategory').value = '';
            document.getElementById('dishDescription').value = '';
            document.getElementById('dishImage').value = '';
            
            document.getElementById('submitBtn').textContent = 'Adicionar Prato';
            document.getElementById('cancelEditBtn').style.display = 'none';
        }
        
        async function renderDishes() {
            const dishList = document.getElementById('dishList');
            dishList.innerHTML = '<p>Carregando...</p>';
            try {
                const produtos = await fetchProdutos();
                console.log('Produtos para renderizar:', produtos);
                console.log('Tipo de produtos:', typeof produtos);
                console.log('É array?', Array.isArray(produtos));
                dishList.innerHTML = '';
                if (!produtos.length) {
                    console.log('Nenhum produto encontrado');
                    dishList.innerHTML = '<p>Nenhum prato cadastrado ainda.</p>';
                    return;
                }
                console.log('Renderizando', produtos.length, 'produtos');
                produtos.forEach((dish, index) => {
                    console.log('Processando prato', index + 1, ':', dish);
                    console.log('Nome do prato:', dish.name);
                    console.log('Categoria do prato:', dish.category);
                    console.log('Preço do prato:', dish.price);
                    const div = document.createElement('div');
                    div.className = 'admin-list-item';
                    div.innerHTML = `
                        <div class="admin-list-info">
                            <img src="${dish.image || ''}" alt="${dish.name || 'Produto'}" style="width:50px;height:50px;object-fit:cover;border-radius:5px;margin-right:1rem;">
                            <div>
                                <strong>${dish.name || 'Nome não disponível'}</strong><br>
                                <small>${dish.category || 'Categoria não definida'} | R$ ${parseFloat(dish.price || 0).toFixed(2)}</small><br>
                                <span>${dish.description || 'Descrição não disponível'}</span>
                            </div>
                        </div>
                        <div class="admin-list-actions">
                            <button class="admin-list-edit" data-id="${dish.id}" data-name="${dish.name || ''}" data-price="${dish.price || ''}" data-category="${dish.category || ''}" data-description="${dish.description || ''}" data-image="${dish.image || ''}">Editar</button>
                            <button class="admin-list-remove" data-id="${dish.id}">Remover</button>
                        </div>
                    `;
                    dishList.appendChild(div);
                });
                document.querySelectorAll('.admin-list-remove').forEach(btn => {
                    btn.addEventListener('click', async function() {
                        console.log('Botão remover clicado');
                        console.log('ID do produto:', this.dataset.id);
                        console.log('Elemento do botão:', this);
                        
                        try {
                            console.log('Tentando remover produto ID:', this.dataset.id);
                            const result = await removeProduto(this.dataset.id);
                            console.log('Resultado da remoção:', result);
                            if (result.success) {
                                console.log('Produto removido com sucesso, recarregando lista');
                                renderDishes();
                            } else {
                                console.error('Erro ao remover:', result.error);
                                alert('Erro ao remover: ' + (result.error || 'Erro desconhecido'));
                            }
                        } catch (error) {
                            console.error('Erro na remoção:', error);
                            console.error('Stack trace:', error.stack);
                            alert('Erro ao remover produto: ' + error.message);
                        }
                    });
                });
                
                // Event listeners para botões de editar
                document.querySelectorAll('.admin-list-edit').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const dish = {
                            id: this.dataset.id,
                            name: this.dataset.name,
                            price: this.dataset.price,
                            category: this.dataset.category,
                            description: this.dataset.description,
                            image: this.dataset.image
                        };
                        fillEditForm(dish);
                    });
                });
            } catch (e) {
                dishList.innerHTML = '<p>Erro ao carregar pratos ou não autorizado.</p>';
            }
        }
        
        // Event listener para cancelar edição
        document.getElementById('cancelEditBtn').addEventListener('click', function() {
            clearEditForm();
        });
        
        document.getElementById('addDishForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const editId = document.getElementById('editId').value;
            const name = document.getElementById('dishName').value.trim();
            const price = parseFloat(document.getElementById('dishPrice').value);
            const category = document.getElementById('dishCategory').value;
            const description = document.getElementById('dishDescription').value.trim();
            const image = document.getElementById('dishImage').value.trim();
            
            if (!name || !price || !category || !description || !image) return;
            
            try {
                let result;
                if (editId) {
                    // Editar produto existente
                    result = await editProduto({ id: editId, name, price, category, description, image });
                } else {
                    // Adicionar novo produto
                    result = await addProduto({ name, price, category, description, image });
                }
                
                if (result.success) {
                    clearEditForm();
                    renderDishes();
                } else {
                    alert(result.error || 'Erro ao processar prato.');
                }
            } catch (error) {
                console.error('Erro:', error);
                alert('Erro ao processar prato: ' + error.message);
            }
        });
        // Carregar pratos ao iniciar
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Página admin carregada, iniciando carregamento de produtos');
            renderDishes();
        });
    </script>
</body>
</html> 