# Teste Técnico [Exon](https://www.linkedin.com/company/exon-sistemas-e-consultoria/)

[![Laravel Forge Site Deployment Status](https://img.shields.io/endpoint?url=https%3A%2F%2Fforge.laravel.com%2Fsite-badges%2F9915fec0-937d-41ca-a50e-dc86556f28ff%3Fdate%3D1&style=plastic)](https://forge.laravel.com/servers/790091/sites/2353022)

## 💡 Ideia

Um sistema para gerenciar consultores e seus compromissos, permitindo operações CRUD (Create, Read, Update, Delete) para ambos.

---

## 💻 Funcionalidades

### Gerenciamento de Consultores

- Cadastro
- Listagem (com filtros por nome e valor da hora)
- Edição
- Exclusão (com restrições de negócio)

### Gerenciamento de Compromissos dos Consultores

- Cadastro
- Listagem (com filtros por data de início, data fim e consultor)
- Edição
- Exclusão

---

## 📋 Requisitos

### Funcionais

- **Consultores:**
  - RF01 - Cadastro de consultor
  - RF02 - Listagem de consultores (com filtros)
  - RF03 - Edição de consultor
  - RF04 - Exclusão de consultor
- **Compromissos:**
  - RF05 - Cadastro de compromisso
  - RF06 - Listagem de compromissos (com filtros e totalizadores)
  - RF07 - Edição de compromisso
  - RF08 - Exclusão de compromisso

### Não Funcionais

- RNF01 - Versionamento com Git
- RNF02 - Deploy na nuvem

### Regras de Negócio

- RN01 - Visualização de totalizador geral de compromissos
- RN02 - Restrição para exclusão de consultor vinculado a compromissos

---

## 🗃️ Modelagem dos Dados

### Consultores

- ID (Inteiro, PK, Auto incrementável)
- Nome completo (String, obrigatório)
- Valor hora (Float)

### Compromissos

- ID (Inteiro, PK, Auto incrementável)
- ID do Consultor (Inteiro, FK, obrigatório)
- Data (Date, obrigatório)
- Hora de início (Time, obrigatório)
- Hora fim (Time, obrigatório)
- Intervalo (Time, obrigatório)

---

## 🔧 Tecnologias Utilizadas

- [Laravel 11](https://laravel.com/docs/11.x/installation)
- [PostgreSQL 16](https://www.postgresql.org/)
- [JS (NodeJs)](https://nodejs.org/en)
- [Vite](https://vitejs.dev/)
- [Composer](https://getcomposer.org/)
- [PHP 8.3.7](https://www.php.net/releases/8_3_7.php)
- [NPM](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm)

---

## 🔍 Configuração do Ambiente

1. **Clonar o repositório:**
   ```bash
   git clone https://github.com/lucas0headshot/teste-tecnico_exon_2024.git
   ```

2. **Instalar dependências do Composer:**
   ```bash
   composer install
   ```

3. **Instalar dependências do NPM:**
   ```bash
   npm install
   ```

4. **Copiar arquivo de configuração do ambiente e configurar:**
   ```bash
   cp .env.example .env
   ```
   Configure o arquivo `.env` com as informações do seu banco de dados.

5. **Gerar a chave de aplicativo Laravel:**
   ```bash
   php artisan key:generate
   ```

6. **Executar as migrações do banco de dados:**
   ```bash
   php artisan migrate
   ```

## ▶️ Executando o Projeto

Para iniciar o servidor embutido do Laravel e o servidor de desenvolvimento do Vite, utilize os seguintes comandos em duas janelas de terminal separadas:

1. **Iniciar o servidor Laravel:**
   ```bash
   php artisan serve
   ```

2. **Iniciar o servidor Vite:**
   ```bash
   npm run dev
   ```

Acesse o projeto no seu navegador: [http://localhost:8000](http://localhost:8000/)
