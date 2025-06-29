# 🚀 Onfly Test - Sistema de Gestão de Viagens Corporativas

> **Aplicação Full Stack** desenvolvida em Laravel (API REST) + Vue.js (Frontend) para gerenciamento de pedidos de viagem corporativa.

---

## 📋 Índice

- [🚀 Execução Rápida](#-execução-rápida)
- [📖 Descrição do Projeto](#-descrição-do-projeto)
- [🏗️ Arquitetura](#️-arquitetura)
- [⚙️ Configuração e Instalação](#️-configuração-e-instalação)
- [🧪 Testes](#-testes)
- [📚 Documentação da API](#-documentação-da-api)
- [🎯 Funcionalidades](#-funcionalidades)
- [📁 Estrutura do Projeto](#-estrutura-do-projeto)
- [🤝 Contribuição](#-contribuição)

---

## 🚀 Execução Rápida

### Pré-requisitos
- Docker e Docker Compose instalados
- Git

### Passos para Execução
```bash
# 1. Clone o repositório
git clone <url-do-repositorio>
cd onfly-test

# 2. Execute com Docker Compose
docker compose up
```

**Acesso:**
- **Frontend:** http://localhost:3000
- **Backend API:** http://localhost:8000

---

## 📖 Descrição do Projeto

Sistema completo para **gestão de pedidos de viagem corporativa** que permite aos usuários:

- ✅ Criar e gerenciar pedidos de viagem
- ✅ Consultar histórico de pedidos
- ✅ Aprovar/rejeitar pedidos (administradores)
- ✅ Receber notificações de status
- ✅ Autenticação segura

---

## 🏗️ Arquitetura

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Frontend      │    │   Backend       │    │   Database      │
│   (Vue.js)      │◄──►│   (Laravel)     │◄──►│   (MySQL)       │
│   Port: 3000    │    │   Port: 8000    │    │   Port: 3306    │
└─────────────────┘    └─────────────────┘    └─────────────────┘
```

---

## ⚙️ Configuração e Instalação

### 1. Variáveis de Ambiente

#### Backend (Laravel)
```env
# .env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=onfly_test
DB_USERNAME=root
DB_PASSWORD=password
```

#### Frontend (Vue.js)
```env
# .env
NUXT_PUBLIC_API_BASE_URL=http://localhost:8000/api
```

### 2. Configuração do Banco de Dados
```bash
# Execute as migrações
docker compose exec api php artisan migrate

# Execute os seeders (opcional)
docker compose exec api php artisan db:seed
```

---

## 🧪 Testes

### Executar Testes do Backend
```bash
# Todos os testes
docker compose exec api php artisan test

# Testes específicos
docker compose exec api php artisan test --filter=AuthTest
```

### Cobertura de Testes
- ✅ Testes de Autenticação
- ✅ Testes de Sistema
- ✅ Testes de Funcionalidades

---

## 📚 Documentação da API

### Endpoints Principais

#### 🔐 Autenticação
```http
POST /api/auth/login
POST /api/auth/logout
GET  /api/auth/user
```

#### 👥 Usuários
```http
GET    /api/users
POST   /api/users
GET    /api/users/{id}
PUT    /api/users/{id}
DELETE /api/users/{id}
```

#### 🏢 Sistemas
```http
GET /api/systems
GET /api/systems/{id}
```

---

## 🎯 Funcionalidades

### 🔐 Sistema de Autenticação
- **Login/Logout** com JWT
- **Proteção de rotas** por middleware
- **Diferentes níveis** de acesso (usuário, admin, super admin)

### 👥 Gestão de Usuários
- **CRUD completo** de usuários
- **Busca e filtros** avançados
- **Validação** de dados
- **Upload de fotos** de perfil

### 🏢 Gestão de Sistemas
- **Múltiplos sistemas** por usuário
- **Escopo de sistema** automático
- **Seleção de sistema** ativo

### 🎨 Interface Moderna
- **Design responsivo** com Vuetify
- **Temas claro/escuro**
- **Notificações toast**
- **Modais interativos**

---

## 📁 Estrutura do Projeto

```
onfly-test/
├── 📁 api/                    # Backend Laravel
│   ├── 📁 app/
│   │   ├── 📁 Controllers/    # Controladores da API
│   │   ├── 📁 Models/         # Modelos Eloquent
│   │   ├── 📁 Services/       # Serviços de negócio
│   │   └── 📁 Middleware/     # Middlewares customizados
│   ├── 📁 database/
│   │   ├── 📁 migrations/     # Migrações do banco
│   │   └── 📁 seeders/        # Dados iniciais
│   └── 📁 tests/              # Testes automatizados
├── 📁 front/                  # Frontend Nuxt.js
│   ├── 📁 components/         # Componentes Vue
│   ├── 📁 pages/              # Páginas da aplicação
│   ├── 📁 stores/             # Gerenciamento de estado
│   └── 📁 composables/        # Composables reutilizáveis
└── 📄 docker-compose.yml      # Configuração Docker
```

---

## 🤝 Contribuição

### Como Contribuir

1. **Fork** o projeto
2. **Crie** uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. **Commit** suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. **Push** para a branch (`git push origin feature/AmazingFeature`)
5. **Abra** um Pull Request

### Padrões de Código

- **PSR-12** para PHP
- **ESLint + Prettier** para JavaScript/TypeScript
- **Commits** seguindo Conventional Commits
- **Testes** para novas funcionalidades


<div align="center">

**Desenvolvido para o desafio Onfly Test**

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Vue.js](https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vue.js&logoColor=4FC08D)](https://vuejs.org)
[![Docker](https://img.shields.io/badge/Docker-2CA5E0?style=for-the-badge&logo=docker&logoColor=white)](https://docker.com)

</div>