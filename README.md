
# Guia de Configuração do DesafioCloud

## Configuração do Banco de Dados:

- **Nome do Aplicativo**: DesafioCloud
- **Ambiente**: Local
- **Modo de Depuração**: Ativado (true)
- **Fuso Horário**: America/Sao_Paulo
- **URL Base**: http://127.0.0.1:8000

### Configurações do Banco de Dados MySQL:
- **Tipo de Conexão**: MySQL
- **Host**: 127.0.0.1
- **Porta**: 3306
- **Nome do Banco de Dados**: desafiocloud
- **Usuário**: root
- **Senha**: (Deixe em branco ou defina sua senha preferida)

## Iniciando o Frontend:
```bash
npm run serve
```

## Iniciando o Backend:
```bash
php artisan serve
```

Certifique-se de configurar corretamente as variáveis de ambiente e garantir que o banco de dados MySQL e o servidor web estejam funcionando para evitar problemas ao iniciar o projeto.
