## Pré-requisitos

- Lógica de programação;
- Conhecimentos sobre Banco de dados;
- Conhecimentos sobre REST, HTTP e API's;
- Conhecimentos sobre Git;


## Como rodar o projeto - Back End

1° Para iniciar o projeto executamos: 
>php artisan serve

2° Nele temos alguns EndPoints para o usuario:
- Cadastro : POST http://127.0.0.1:8000/api/users/
- Listar : GET http://127.0.0.1:8000/api/users/
- Visualizar : GET http://127.0.0.1:8000/api/users/{id}
-  Editar: PUT http://127.0.0.1:8000/api/users/{id}
- Apagar: DELETE http://127.0.0.1:8000/api/users/{id}
- Check Email: GET http://127.0.0.1:8000/api/users/checkemail/

3° Seguindo temos também os EndPoints de Produto:
- Cadastro : POST http://127.0.0.1:8000/api/produtos
- Listagem : GET http://127.0.0.1:8000/api/produtos

4° Seguindo temos os EndPoints de Movimentação:
- Visualizar por tipo de pagamento: GET http://127.0.0.1:8000/api/movements/search
- Deletar : DELETE http://127.0.0.1:8000/api/movements/{id}
- Listar : GET http://127.0.0.1:8000/api/movements
- Cadastro : POST http://127.0.0.1:8000/api/movements


5° End Point de Soma:
- Total Debito: GET http://127.0.0.1:8000/api/movement/debits
- Total Credito: GET http://127.0.0.1:8000/api/movement/credit
- Total Metodos: GET http://127.0.0.1:8000/api/movement/totalmetodos

6° End Point de CSV:
- Export : GET http://127.0.0.1:8000/api/movement/export-csv

7° Nesse projeto foi usado uma biblioteca seu comando para intalação foi :
> composer require league/csv

8° Comando utilizados para criançar de migrations, controller e models:
> php artisan make:controller Api/MovementProductController
> php artisan make:model MovementProduct
> php artisan make:migration create_movement_product_table --create=movement_product
> php artisan make:migration create_movements_table
> php artisan make:model Movements
> php artisan make:controller Api/MovementsController    
> php artisan make:controller Api/ProdutosController --resource
> php artisan make:model Produtos
> php artisan make:migration create_produtos_table
> php artisan make:controller Api/UserController
> php artisan db:seed
> php artisan make:seeder UserSeeder
> php artisan install:api
> composer create-project laravel/laravel api             
