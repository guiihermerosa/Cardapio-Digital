<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio Digital - Início</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="header">
        <nav class="nav-container">
            <div class="logo">
                <h1>Cardápio Digital</h1>
            </div>
            <div class="nav-links">
                <a href="index.php" class="active">Início</a>
                <a href="menu.php">Cardápio</a>
                <a href="about.php">Sobre</a>
                <a href="contact.php">Contato</a>
            </div>
            <div class="cart-icon">
                <a href="cart.php">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count">0</span>
                </a>
            </div>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>Bem-vindo ao Cardápio Digital</h1>
            <p>Descubra os melhores sabores da cidade com apenas um clique</p>
            <a href="menu.php" class="btn">Ver Cardápio</a>
        </div>
    </section>

    <section class="categories">
        <h2>Categorias</h2>
        <div class="category-grid">
            <div class="category-card">
                <img src="assets/images/category-1.jpg" alt="Pratos Principais">
                <div class="category-overlay">Pratos Principais</div>
            </div>
            <div class="category-card">
                <img src="assets/images/category-2.jpg" alt="Entradas">
                <div class="category-overlay">Entradas</div>
            </div>
            <div class="category-card">
                <img src="assets/images/category-3.jpg" alt="Sobremesas">
                <div class="category-overlay">Sobremesas</div>
            </div>
            <div class="category-card">
                <img src="assets/images/category-4.jpg" alt="Bebidas">
                <div class="category-overlay">Bebidas</div>
            </div>
        </div>
    </section>

    <section class="featured">
        <h2>Produtos em Destaque</h2>
        <div class="product-grid">
            <div class="product-card">
                <div class="product-image">
                    <img src="assets/images/menu-item-1.jpg" alt="Salada Caesar">
                </div>
                <div class="product-info">
                    <h3>Salada Caesar</h3>
                    <p class="product-price">R$ 25,90</p>
                    <p class="product-description">Alface romana, croutons, parmesão e molho caesar.</p>
                    <button class="btn-add" data-product-id="1">Adicionar ao Carrinho</button>
                </div>
            </div>

            <div class="product-card">
                <div class="product-image">
                    <img src="assets/images/menu-item-2.jpg" alt="Filé ao Molho Madeira">
                </div>
                <div class="product-info">
                    <h3>Filé ao Molho Madeira</h3>
                    <p class="product-price">R$ 45,90</p>
                    <p class="product-description">Filé mignon grelhado com molho madeira e arroz.</p>
                    <button class="btn-add" data-product-id="2">Adicionar ao Carrinho</button>
                </div>
            </div>

            <div class="product-card">
                <div class="product-image">
                    <img src="assets/images/menu-item-3.jpg" alt="Risoto de Cogumelos">
                </div>
                <div class="product-info">
                    <h3>Risoto de Cogumelos</h3>
                    <p class="product-price">R$ 35,90</p>
                    <p class="product-description">Arroz arbóreo com mix de cogumelos e parmesão.</p>
                    <button class="btn-add" data-product-id="3">Adicionar ao Carrinho</button>
                </div>
            </div>

            <div class="product-card">
                <div class="product-image">
                    <img src="assets/images/menu-item-4.jpg" alt="Tiramisù">
                </div>
                <div class="product-info">
                    <h3>Tiramisù</h3>
                    <p class="product-price">R$ 18,90</p>
                    <p class="product-description">Sobremesa italiana com café, mascarpone e cacau.</p>
                    <button class="btn-add" data-product-id="4">Adicionar ao Carrinho</button>
                </div>
            </div>
        </div>
    </section>

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
        // Adicionar produtos ao carrinho
        document.querySelectorAll('.btn-add').forEach(button => {
            button.addEventListener('click', () => {
                const productId = button.dataset.productId;
                const productCard = button.closest('.product-card');
                const product = {
                    id: productId,
                    name: productCard.querySelector('h3').textContent,
                    price: parseFloat(productCard.querySelector('.product-price').textContent.replace('R$ ', '').replace(',', '.')),
                    image: productCard.querySelector('img').src
                };

                cart.addItem(product);
                showMessage('Produto adicionado ao carrinho!');
            });
        });

        // Navegação por categorias
        document.querySelectorAll('.category-card').forEach(card => {
            card.addEventListener('click', () => {
                const category = card.querySelector('.category-overlay').textContent;
                window.location.href = `menu.php?category=${encodeURIComponent(category)}`;
            });
        });
    </script>
</body>
</html> 