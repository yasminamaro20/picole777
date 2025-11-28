# 🍦 Picolé Manager

Um sistema completo de gestão para produção e vendas de picolés.  
Inclui módulos de **cadastro**, **estoque**, **ingredientes**, **sabores**, **produção**, **relatórios** e **vendas com carrinho e pagamento via PIX**.

Interface moderna, responsiva e totalmente funcional usando **HTML, CSS, JavaScript e React (via Babel)** — sem backend.

---

## 🚀 Funcionalidades Principais

### 🏠 **Dashboard Inicial**
- Apresentação do sistema  
- Acesso rápido aos módulos  
- Visual moderno e intuitivo  

### 🍧 **Cadastro de Sabores**
- Criar, editar e excluir sabores  
- Descrição, nome e preço unitário  
- Armazenamento em LocalStorage  
- Tabela dinâmica + modal estilizado  

### 🌿 **Cadastro de Ingredientes**
- Controle de estoque e unidade de medida  
- Indicadores de nível de estoque:
  - 🟢 OK
  - 🟡 Baixo
  - 🔴 Crítico  
- Modal moderno + tabela responsiva  

### 🏭 **Gestão de Lotes de Produção**
- Registrar novos lotes  
- Status (Pronto / Em Produção)  
- Quantidade, data e código do lote  
- Visualização completa em tabela  

### 🛒 **Vendas e Carrinho (React)**
- Catálogo com mais de 30 produtos  
- Animação “voar para o carrinho”  
- Carrinho dinâmico:
  - adicionar  
  - aumentar/diminuir quantidade  
  - remover  
- Cálculo automático do total  
- Página de pagamento via **PIX**  
- Geração automática da chave PIX com valor e ID do pedido  

---

## 🛠 Tecnologias Utilizadas

### **Frontend**
- HTML5  
- CSS3 (Gradientes, Glassmorphism, Cards)  
- JavaScript  
- React 18 (via Babel no navegador)  
- Font Awesome  
- Google Fonts – Poppins  

### **Armazenamento**
- `LocalStorage`  
  - Sabores  
  - Ingredientes  
  - Lotes  
  - Carrinho
