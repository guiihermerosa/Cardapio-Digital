<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre - Cardápio Digital</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .about-container {
            max-width: 1200px;
            margin: 100px auto 0;
            padding: 2rem;
        }

        .about-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .about-header h1 {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 1rem;
        }

        .about-header p {
            color: #666;
            font-size: 1.1rem;
            max-width: 800px;
            margin: 0 auto;
        }

        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .about-image {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .about-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .about-text {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .about-text h2 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 1rem;
        }

        .about-text p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 3rem;
        }

        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: #e74c3c;
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 1rem;
        }

        .feature-card p {
            color: #666;
            line-height: 1.6;
        }

        .team-section {
            margin-top: 4rem;
            text-align: center;
        }

        .team-section h2 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 2rem;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
        }

        .team-member {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .team-member img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .team-member-info {
            padding: 1.5rem;
        }

        .team-member-info h3 {
            font-size: 1.2rem;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .team-member-info p {
            color: #666;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .about-content {
                grid-template-columns: 1fr;
            }

            .features {
                grid-template-columns: 1fr;
            }

            .team-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .team-grid {
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
                <a href="about.php" class="active">Sobre</a>
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

    <main class="about-container">
        <div class="about-header">
            <h1>Nossa História</h1>
            <p>Conheça um pouco mais sobre o Cardápio Digital e nossa paixão pela gastronomia</p>
        </div>

        <div class="about-content">
            <div class="about-image">
                <img src="assets/images/restaurant.jpg" alt="Nosso Restaurante">
            </div>
            <div class="about-text">
                <h2>Uma Jornada de Sabor</h2>
                <p>Fundado em 2020, o Cardápio Digital nasceu da paixão por comida de qualidade e da necessidade de modernizar a experiência gastronômica. Nossa missão é proporcionar uma experiência única, combinando sabores tradicionais com inovação.</p>
                <p>Com uma equipe dedicada de chefs experientes e profissionais apaixonados, nos esforçamos para criar pratos que não apenas alimentam o corpo, mas também a alma.</p>
            </div>
        </div>

        <div class="features">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-utensils"></i>
                </div>
                <h3>Qualidade</h3>
                <p>Utilizamos apenas ingredientes frescos e de alta qualidade em todos os nossos pratos.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>Pontualidade</h3>
                <p>Comprometimento com o tempo de entrega e qualidade do serviço.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <h3>Paixão</h3>
                <p>Cada prato é preparado com amor e dedicação para proporcionar a melhor experiência.</p>
            </div>
        </div>

        <div class="team-section">
            <h2>Nossa Equipe</h2>
            <div class="team-grid">
                <div class="team-member">
                    <img src="assets/images/chef-1.jpg" alt="Chef Principal">
                    <div class="team-member-info">
                        <h3>João Silva</h3>
                        <p>Chef Principal</p>
                    </div>
                </div>
                <div class="team-member">
                    <img src="assets/images/chef-2.jpg" alt="Sous Chef">
                    <div class="team-member-info">
                        <h3>Maria Santos</h3>
                        <p>Sous Chef</p>
                    </div>
                </div>
                <div class="team-member">
                    <img src="assets/images/chef-3.jpg" alt="Pastelaria">
                    <div class="team-member-info">
                        <h3>Pedro Costa</h3>
                        <p>Chef de Pastelaria</p>
                    </div>
                </div>
                <div class="team-member">
                    <img src="assets/images/chef-4.jpg" alt="Sobremesas">
                    <div class="team-member-info">
                        <h3>Ana Oliveira</h3>
                        <p>Chef de Sobremesas</p>
                    </div>
                </div>
            </div>
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
</body>
</html> 