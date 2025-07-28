
# 🍽️ Cardápio Digital

O **Cardápio Digital** é uma aplicação completa desenvolvida com foco na automação e digitalização de pedidos em estabelecimentos gastronômicos. A solução oferece uma interface moderna e intuitiva para clientes realizarem pedidos online e um painel administrativo eficiente para o gerenciamento interno de produtos, categorias e pedidos. O projeto integra frontend responsivo, backend em PHP e banco de dados MySQL, promovendo uma experiência fluida, prática e escalável.

---

## 🚀 Funcionalidades

### 👨‍🍳 Frontend
- Página inicial com destaques e categorias personalizadas
- Cardápio digital com filtros dinâmicos por categoria
- Carrinho de compras persistente com `localStorage`
- Finalização de pedidos com interface amigável
- Página "Sobre nós" com informações do restaurante
- Página de contato com formulário integrado e mapa interativo

### 🛠️ Backend (Painel Administrativo)
- Cadastro, edição e remoção de produtos
- Visualização e gerenciamento de pedidos em tempo real
- Atualização do status dos pedidos
- Arquitetura baseada em APIs RESTful
- Sistema seguro com tratamento de dados e proteção contra injeção SQL

---

## ⚙️ Tecnologias Utilizadas

| Camada      | Tecnologias                           |
|-------------|----------------------------------------|
| Frontend    | HTML5, CSS3, JavaScript (ES6+), Font Awesome |
| Backend     | PHP 7.4+, API RESTful                  |
| Banco de Dados | MySQL 5.7+                          |
| APIs externas | Google Maps API (opcional)           |

---

## 📦 Pré-requisitos

- Servidor Web (Apache ou Nginx)
- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Extensões PHP habilitadas:
  - `PDO`
  - `PDO_MySQL`
  - `JSON`

---

## 🔧 Instalação e Configuração

1. **Clone o repositório:**
   ```bash
   git clone https://github.com/guiihermerosa/Cardapio-Digital.git
   ```

2. **Configuração do Banco de Dados:**
   - Crie um banco de dados MySQL
   - Execute o script `cardapio.sql` para criar as tabelas
   - Atualize o arquivo de conexão `backend/config/Database.php` com suas credenciais

3. **Servidor Web:**
   - Aponte o `DocumentRoot` para a pasta do projeto
   - Certifique-se de que o módulo `mod_rewrite` está habilitado (em caso de Apache)
   - Ajuste permissões de pastas e arquivos conforme necessário

4. **Personalização:**
   - Atualize as informações institucionais nas páginas do frontend
   - Configure corretamente as URLs de imagens e recursos

---

## 🗂️ Estrutura do Projeto

```plaintext
Cardapio-Digital/
├── DAL/                         # Lógica de acesso a dados
├── VIEW/                        # Interface de usuário e frontend
├── cardapio.sql                 # Script do banco de dados
├── README.md                    # Documentação do projeto
└── .gitignore / .gitattributes  # Arquivos de controle de versão
```

---

## 💻 Como Usar

### Acesso do Cliente (Usuário final)
1. Acesse `index.html` no navegador
2. Navegue pelas categorias e produtos
3. Adicione itens ao carrinho
4. Finalize o pedido via formulário de envio

### Acesso do Administrador
- Acesse: `backend/admin/products.php`
  - Gerencie produtos (criar, editar, excluir)
- Acesse: `backend/admin/orders.php`
  - Visualize e atualize pedidos em tempo real

---

## 🔐 Segurança

- Validação de dados no lado cliente e servidor
- Uso de `PDO` para proteção contra SQL Injection
- CORS configurado corretamente
- Sanitização de entradas de usuário

---

## ✨ Recursos Adicionais

- Design responsivo compatível com dispositivos móveis
- Interface moderna com ícones via Font Awesome
- Integração com Google Maps na página de contato
- Filtros inteligentes por categoria de produto
- Sistema modular preparado para expansão (delivery, autenticação, etc.)

---


## 📝 Licença

Este projeto está licenciado sob a [Licença MIT](LICENSE). Você é livre para usá-lo, modificá-lo e distribuí-lo com os devidos créditos.

---

## 📞 Suporte

Caso precise de suporte, entre em contato:

- 📧 **Email:** GRBTECNOLOGIA.CM@gmail.com
- 🐛 Ou abra uma [issue](https://github.com/guiihermerosa/Cardapio-Digital/issues)

---

## 🙏 Agradecimentos

- [Font Awesome](https://fontawesome.com/) pelos ícones
- Comunidade PHP por todo suporte e materiais
- A todos os colaboradores que contribuíram com o projeto

> Desenvolvido com dedicação por **Guilherme Rosa de Brito** e **Gustavo Oliveira**
