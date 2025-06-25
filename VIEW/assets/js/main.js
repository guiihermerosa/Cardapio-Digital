// Gerenciamento do carrinho
class Cart {
    constructor() {
        this.items = JSON.parse(localStorage.getItem('cart')) || [];
        this.updateCartCount();
    }

    addItem(product) {
        const existingItem = this.items.find(item => item.id === product.id);
        
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            this.items.push({
                id: product.id,
                name: product.name,
                price: product.price,
                image: product.image,
                quantity: 1
            });
        }

        this.saveCart();
        this.updateCartCount();
    }

    removeItem(productId) {
        this.items = this.items.filter(item => item.id !== productId);
        this.saveCart();
        this.updateCartCount();
    }

    updateQuantity(productId, quantity) {
        const item = this.items.find(item => item.id === productId);
        if (item) {
            item.quantity = quantity;
            if (item.quantity <= 0) {
                this.removeItem(productId);
            }
        }
        this.saveCart();
        this.updateCartCount();
    }

    getTotal() {
        return this.items.reduce((total, item) => total + (item.price * item.quantity), 0);
    }

    saveCart() {
        localStorage.setItem('cart', JSON.stringify(this.items));
    }

    updateCartCount() {
        const cartCount = document.querySelector('.cart-count');
        if (cartCount) {
            const totalItems = this.items.reduce((total, item) => total + item.quantity, 0);
            cartCount.textContent = totalItems;
        }
    }

    clearCart() {
        this.items = [];
        this.saveCart();
        this.updateCartCount();
    }
}

// Inicialização do carrinho
const cart = new Cart();

// Funções de utilidade
function formatPrice(price) {
    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    }).format(price);
}

// Animação suave para links de navegação
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
});

// Menu mobile
const menuButton = document.querySelector('.menu-button');
const navLinks = document.querySelector('.nav-links');

if (menuButton && navLinks) {
    menuButton.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });
}

// Validação de formulários
function validateForm(form) {
    const inputs = form.querySelectorAll('input[required], textarea[required]');
    let isValid = true;

    inputs.forEach(input => {
        if (!input.value.trim()) {
            isValid = false;
            input.classList.add('error');
        } else {
            input.classList.remove('error');
        }
    });

    return isValid;
}

// Adicionar estilos de erro para inputs inválidos
const style = document.createElement('style');
style.textContent = `
    .error {
        border-color: #e74c3c !important;
    }
    .error-message {
        color: #e74c3c;
        font-size: 0.8rem;
        margin-top: 0.3rem;
    }
`;
document.head.appendChild(style);

// Inicialização de tooltips
document.querySelectorAll('[data-tooltip]').forEach(element => {
    element.addEventListener('mouseenter', (e) => {
        const tooltip = document.createElement('div');
        tooltip.className = 'tooltip';
        tooltip.textContent = e.target.dataset.tooltip;
        document.body.appendChild(tooltip);

        const rect = e.target.getBoundingClientRect();
        tooltip.style.top = `${rect.bottom + 5}px`;
        tooltip.style.left = `${rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2)}px`;
    });

    element.addEventListener('mouseleave', () => {
        const tooltip = document.querySelector('.tooltip');
        if (tooltip) {
            tooltip.remove();
        }
    });
});

// Adicionar estilos para tooltips
const tooltipStyle = document.createElement('style');
tooltipStyle.textContent = `
    .tooltip {
        position: fixed;
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        font-size: 0.9rem;
        z-index: 1000;
        pointer-events: none;
    }
`;
document.head.appendChild(tooltipStyle);

// Função para mostrar mensagens de feedback
function showMessage(message, type = 'success') {
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${type}`;
    messageDiv.textContent = message;
    document.body.appendChild(messageDiv);

    setTimeout(() => {
        messageDiv.remove();
    }, 3000);
}

// Adicionar estilos para mensagens
const messageStyle = document.createElement('style');
messageStyle.textContent = `
    .message {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 2rem;
        border-radius: 4px;
        color: white;
        z-index: 1000;
        animation: slideIn 0.3s ease-out;
    }
    .message.success {
        background-color: #2ecc71;
    }
    .message.error {
        background-color: #e74c3c;
    }
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
`;
document.head.appendChild(messageStyle);

// Exportar funções e classes para uso em outros arquivos
window.cart = cart;
window.formatPrice = formatPrice;
window.validateForm = validateForm;
window.showMessage = showMessage;

// --- INÍCIO: Renderização dinâmica do menu ---
async function fetchProdutosBanco() {
    const res = await fetch('../DAL/produtos.php');
    const data = await res.json();
    console.log('Produtos carregados:', data);
    return data.produtos || [];
}

async function renderMenu() {
    const menuContainer = document.querySelector('.menu-container');
    if (!menuContainer) {
        console.log('Container de menu não encontrado');
        return;
    }

    // Categorias
    const categories = [
        { key: 'pratos-principais', label: 'Pratos Principais' },
        { key: 'entradas', label: 'Entradas' },
        { key: 'sobremesas', label: 'Sobremesas' },
        { key: 'bebidas', label: 'Bebidas' }
    ];
    const dishes = await fetchProdutosBanco();
    console.log('Pratos para renderizar:', dishes);
    
    // Agrupar pratos por categoria
    const grouped = {};
    categories.forEach(cat => grouped[cat.key] = []);
    dishes.forEach(dish => {
        console.log('Processando prato:', dish);
        if (grouped[dish.category]) grouped[dish.category].push(dish);
    });
    
    console.log('Pratos agrupados:', grouped);

    // Renderizar categorias
    let html = `
        <div class="menu-header">
            <h1>Nosso Cardápio</h1>
            <p>Descubra nossas deliciosas opções</p>
        </div>
        <div class="menu-filters">
            <button class="filter-btn active" data-category="all">Todos</button>
            <button class="filter-btn" data-category="pratos-principais">Pratos Principais</button>
            <button class="filter-btn" data-category="entradas">Entradas</button>
            <button class="filter-btn" data-category="sobremesas">Sobremesas</button>
            <button class="filter-btn" data-category="bebidas">Bebidas</button>
        </div>
    `;
    categories.forEach(cat => {
        if (grouped[cat.key].length > 0) {
            html += `<div class="menu-category" data-category-group="${cat.key}">
                <h2>${cat.label}</h2>
                <div class="menu-grid">
            `;
            grouped[cat.key].forEach((dish) => {
                const id = `prod-${dish.id}`;
                html += `
                <div class="menu-item" data-category="${cat.key}" data-dish-id="${id}">
                    <div class="menu-item-image">
                        <img src="${dish.image}" alt="${dish.name}" onerror="this.style.display='none'; this.parentElement.innerHTML='<div style=\\'width:100%;height:200px;background:#f0f0f0;display:flex;align-items:center;justify-content:center;font-size:14px;color:#999;\\'>Imagem não disponível</div>'">
                    </div>
                    <div class="menu-item-info">
                        <div class="menu-item-header">
                            <h3 class="menu-item-title">${dish.name || 'Nome não disponível'}</h3>
                            <p class="menu-item-price">${formatPrice(dish.price || 0)}</p>
                        </div>
                        <p class="menu-item-description">${dish.description || 'Descrição não disponível'}</p>
                        <div class="menu-item-controls">
                            <div class="quantity-control">
                                <button class="quantity-btn minus">-</button>
                                <span class="quantity-display">1</span>
                                <button class="quantity-btn plus">+</button>
                            </div>
                            <button class="btn-add" data-product-id="${dish.id}">Adicionar</button>
                        </div>
                    </div>
                </div>
                `;
            });
            html += '</div></div>';
        }
    });
    // Substituir conteúdo do menu
    menuContainer.innerHTML = html;
    attachMenuEventsBanco(dishes);
}

function attachMenuEventsBanco(dishes) {
    // Filtro de categorias
    const filterButtons = document.querySelectorAll('.filter-btn');
    const menuItems = document.querySelectorAll('.menu-item');
    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            const category = button.dataset.category;
            menuItems.forEach(item => {
                if (category === 'all' || item.dataset.category === category) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
    // Controle de quantidade
    document.querySelectorAll('.quantity-control').forEach(control => {
        const minusBtn = control.querySelector('.minus');
        const plusBtn = control.querySelector('.plus');
        const quantityDisplay = control.querySelector('.quantity-display');
        minusBtn.addEventListener('click', () => {
            let quantity = parseInt(quantityDisplay.textContent);
            if (quantity > 1) {
                quantityDisplay.textContent = quantity - 1;
            }
        });
        plusBtn.addEventListener('click', () => {
            let quantity = parseInt(quantityDisplay.textContent);
            quantityDisplay.textContent = quantity + 1;
        });
    });
    // Adicionar ao carrinho
    document.querySelectorAll('.btn-add').forEach(button => {
        button.addEventListener('click', () => {
            const menuItem = button.closest('.menu-item');
            const quantity = parseInt(menuItem.querySelector('.quantity-display').textContent);
            const id = button.dataset.productId;
            // Buscar prato pelo id
            const found = dishes.find(d => String(d.id) === String(id));
            if (!found) return;
            const product = {
                id: found.id,
                name: found.name,
                price: parseFloat(found.price),
                image: found.image,
                quantity: quantity
            };
            for (let i = 0; i < quantity; i++) {
                cart.addItem(product);
            }
            showMessage('Produto adicionado ao carrinho!');
        });
    });
    // Verificar categoria na URL
    const urlParams = new URLSearchParams(window.location.search);
    const categoryParam = urlParams.get('category');
    if (categoryParam) {
        const button = document.querySelector(`[data-category="${categoryParam.toLowerCase()}"]`);
        if (button) {
            button.click();
        }
    }
}
// Renderizar menu ao carregar a página menu.php ou menu.html
if (window.location.pathname.includes('menu.php') || window.location.pathname.includes('menu.html')) {
    renderMenu();
}
// --- FIM: Renderização dinâmica do menu --- 