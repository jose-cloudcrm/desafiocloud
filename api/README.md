
# Projeto API - Backend com Laravel

## Pré-requisitos

- **Lógica de programação**: Conhecimento básico sobre fluxos de controle, funções e manipulação de dados.
- **Banco de dados**: Familiaridade com bancos de dados relacionais, SQL, e operações de CRUD.
- **REST, HTTP e API's**: Compreensão dos padrões RESTful e operações HTTP (GET, POST, PUT, DELETE).
- **Git**: Experiência com controle de versão, commits e branches.

## Como rodar o projeto - Back End

1. **Iniciar o servidor**:
   Para rodar o servidor de desenvolvimento, execute o comando abaixo:
   ```bash
   php artisan serve
   ```
   Isso inicia o servidor na URL padrão `http://127.0.0.1:8000`.

2. **Endpoints de Usuários**:
   - **Cadastrar Usuário**: `POST http://127.0.0.1:8000/api/users/`
   - **Listar Usuários**: `GET http://127.0.0.1:8000/api/users/`
   - **Visualizar Usuário**: `GET http://127.0.0.1:8000/api/users/{id}`
   - **Editar Usuário**: `PUT http://127.0.0.1:8000/api/users/{id}`
   - **Apagar Usuário**: `DELETE http://127.0.0.1:8000/api/users/{id}`
   - **Verificar Email**: `GET http://127.0.0.1:8000/api/users/checkemail/`

3. **Endpoints de Produtos**:
   - **Cadastrar Produto**: `POST http://127.0.0.1:8000/api/produtos`
   - **Listar Produtos**: `GET http://127.0.0.1:8000/api/produtos`

4. **Endpoints de Movimentações**:
   - **Visualizar por Tipo de Pagamento**: `GET http://127.0.0.1:8000/api/movements/search`
   - **Deletar Movimentação**: `DELETE http://127.0.0.1:8000/api/movements/{id}`
   - **Listar Movimentações**: `GET http://127.0.0.1:8000/api/movements`
   - **Cadastrar Movimentação**: `POST http://127.0.0.1:8000/api/movements`

5. **Endpoints de Soma**:
   - **Total Débito**: `GET http://127.0.0.1:8000/api/movement/debits`
   - **Total Crédito**: `GET http://127.0.0.1:8000/api/movement/credit`
   - **Total por Método de Pagamento**: `GET http://127.0.0.1:8000/api/movement/totalmetodos`

6. **Endpoint de Exportação CSV**:
   - **Exportar Movimentações**: `GET http://127.0.0.1:8000/api/movement/export-csv`

7. **Bibliotecas Utilizadas**:
   - A biblioteca `league/csv` foi utilizada para exportação de CSV:
   ```bash
   composer require league/csv
   ```

8. **Comandos Úteis**:
   - Criar Controllers, Models e Migrations:
     ```bash
     php artisan make:controller Api/MovementProductController
     php artisan make:model MovementProduct
     php artisan make:migration create_movement_product_table --create=movement_product
     php artisan make:migration create_movements_table
     php artisan make:model Movements
     php artisan make:controller Api/MovementsController
     php artisan make:controller Api/ProdutosController --resource
     php artisan make:model Produtos
     php artisan make:migration create_produtos_table
     php artisan make:controller Api/UserController
     php artisan db:seed
     php artisan make:seeder UserSeeder
     php artisan install:api
     composer create-project laravel/laravel api
     ```
