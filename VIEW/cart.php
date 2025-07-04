<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho - Cardápio Digital</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .cart-container {
            max-width: 1200px;
            margin: 100px auto 0;
            padding: 2rem;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }

        .cart-items {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .cart-item {
            display: grid;
            grid-template-columns: 100px 1fr auto;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid #eee;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }

        .cart-item-details {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .cart-item-title {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        .cart-item-price {
            color: #e74c3c;
            font-weight: bold;
        }

        .cart-item-quantity {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .quantity-btn {
            background: #f0f0f0;
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quantity-btn:hover {
            background: #e0e0e0;
        }

        .cart-item-remove {
            color: #e74c3c;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.2rem;
        }

        .cart-summary {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            height: fit-content;
        }

        .summary-title {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .summary-total {
            font-size: 1.2rem;
            font-weight: bold;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #eee;
        }

        .checkout-form {
            margin-top: 2rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .btn-checkout {
            width: 100%;
            padding: 1rem;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1rem;
            margin-top: 1rem;
        }

        .btn-checkout:hover {
            background-color: #c0392b;
        }

        .empty-cart {
            text-align: center;
            padding: 3rem;
        }

        .empty-cart i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 1rem;
        }

        .empty-cart p {
            color: #666;
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .cart-container {
                grid-template-columns: 1fr;
            }
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
            </div>
            <div class="cart-icon">
                <a href="cart.php" class="active">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count">2</span>
                </a>
            </div>
        </nav>
    </header>

    <main class="cart-container">
        <div class="cart-items">
            <h2>Seu Carrinho</h2>
            <div id="cartItemsContainer"></div>
        </div>
        <div class="cart-summary">
            <h2 class="summary-title">Resumo do Pedido</h2>
            <div class="summary-row">
                <span>Subtotal</span>
                <span class="Subtotal"></span>
            </div>
            <div class="summary-row">
                <span>Taxa de Entrega</span>
                <span>R$ 5,00</span>
            </div>
            <div class="summary-row summary-total">
                <span>Total</span>
                <span class="value-total"></span>
            </div>
            <form class="checkout-form">
                <div class="form-group">
                    <label for="name">Nome Completo</label>
                    <input type="text" id="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Telefone</label>
                    <input type="tel" id="phone" required>
                </div>
                <div class="form-group">
                    <label for="address">Endereço de Entrega</label>
                    <input type="text" id="address" required>
                </div>
                <button type="submit" class="btn-checkout">Finalizar Pedido</button>
            </form>
        </div>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Horário de Funcionamento</h3>
                <p>Segunda a Sexta: 11h às 22h</p>
                <p>Sábado e Domingo: 11h às 23h</p>
            </div>
            <div class="footer-section">
                <h3>Contato</h3>
                <p><i class="fas fa-phone"></i> (11) 9999-9999</p>
                <p><i class="fas fa-envelope"></i> contato@cardapiodigital.com</p>
            </div>
            <div class="footer-section">
                <h3>Redes Sociais</h3>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Cardápio Digital. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="assets/js/main.js"></script>
    <script>
    // --- Carrinho dinâmico ---
    function getCart() {
        return JSON.parse(localStorage.getItem('cart') || '[]');
    }
    function saveCart(cart) {
        localStorage.setItem('cart', JSON.stringify(cart));
        if (window.cart) window.cart.updateCartCount();
    }
    function formatPrice(price) {
        return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(price);
    }
    function renderCart() {
        const cart = getCart();
        const container = document.getElementById('cartItemsContainer');
        container.innerHTML = '';
        if (!cart.length) {
            container.innerHTML = `<div class='empty-cart'><i class='fas fa-shopping-cart'></i><p>Seu carrinho está vazio.</p></div>`;
            document.querySelector('.Subtotal').textContent = formatPrice(0);
            document.querySelector('.value-total').textContent = formatPrice(5);
            return;
        }
        cart.forEach((item, idx) => {
            const div = document.createElement('div');
            div.className = 'cart-item';
            div.innerHTML = `
                <img src="${item.image}" alt="${item.name}">
                <div class="cart-item-details">
                    <div>
                        <h3 class="cart-item-title">${item.name}</h3>
                        <p class="cart-item-price">${formatPrice(item.price)}</p>
                    </div>
                    <div class="cart-item-quantity">
                        <button class="quantity-btn minus">-</button>
                        <span>${item.quantity}</span>
                        <button class="quantity-btn plus">+</button>
                    </div>
                </div>
                <button class="cart-item-remove"><i class="fas fa-trash"></i></button>
            `;
            // Eventos de quantidade
            div.querySelector('.quantity-btn.minus').addEventListener('click', () => {
                if (item.quantity > 1) {
                    item.quantity--;
                    saveCart(cart);
                    renderCart();
                }
            });
            div.querySelector('.quantity-btn.plus').addEventListener('click', () => {
                item.quantity++;
                saveCart(cart);
                renderCart();
            });
            // Evento de remover
            div.querySelector('.cart-item-remove').addEventListener('click', () => {
                cart.splice(idx, 1);
                saveCart(cart);
                renderCart();
            });
            container.appendChild(div);
        });
        updateSummary();
    }
    function updateSummary() {
        const cart = getCart();
        let subtotal = 0;
        cart.forEach(item => {
            subtotal += item.price * item.quantity;
        });
        const deliveryFee = 5.00;
        const total = subtotal + deliveryFee;
        document.querySelector('.Subtotal').textContent = formatPrice(subtotal);
        document.querySelector('.value-total').textContent = formatPrice(total);
    }
    document.addEventListener('DOMContentLoaded', () => {
        renderCart();
        // Checkout
        const checkoutForm = document.querySelector('.checkout-form');
        if (checkoutForm) {
            checkoutForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                
                const cart = getCart();
                if (cart.length === 0) {
                    alert('Carrinho vazio!');
                    return;
                }

                const formData = {
                    name: document.getElementById('name').value,
                    email: document.getElementById('email').value,
                    phone: document.getElementById('phone').value,
                    address: document.getElementById('address').value,
                    total: parseFloat(document.querySelector('.value-total').textContent.replace('R$', '').replace(',', '.').trim()),
                    items: cart
                };

                try {
                    const response = await fetch('../DAL/pedidos.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(formData)
                    });

                    const result = await response.json();
                    
                    if (result.success) {
                        alert('Pedido realizado com sucesso! Número do pedido: ' + result.order_id);
                        localStorage.removeItem('cart');
                        if (window.cart) window.cart.clearCart();
                        renderCart();
                        checkoutForm.reset();
                    } else {
                        alert('Erro ao realizar pedido: ' + (result.error || 'Erro desconhecido'));
                    }
                } catch (error) {
                    console.error('Erro:', error);
                    alert('Erro ao conectar com o servidor. Tente novamente.');
                }
            });
        }
    });
    // --- Fim carrinho dinâmico ---
    </script>
</body>
</html> 