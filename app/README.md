
## Pré-requisitos

- Lógica de programação básica;
- Conhecimentos sobre banco de dados;
- Entendimento sobre REST, HTTP e APIs;
- Familiaridade com o controle de versão Git;

## Executando o Projeto - Front End

1. Na página inicial, você pode visualizar imediatamente todos os usuários cadastrados.
2. Para criar um novo usuário, vá para o formulário de criação de usuário, que inclui campos para nome, e-mail, senha e data de nascimento.
3. O cadastro do usuário só será possível se ele tiver mais de 18 anos, o e-mail for único e a senha contiver mais de 6 caracteres.
4. Após criar um usuário, você pode editar qualquer informação ou excluir o usuário, se não houver transações vinculadas a ele.
5. Após cadastrar os usuários, prossiga para o cadastro de produtos.
6. No formulário de cadastro de produto, você pode preencher detalhes como nome do produto, quantidade e preço.
7. Em seguida, vá para o cadastro de movimentações.
8. Na área de movimentações, você pode selecionar vários produtos, um usuário existente e um método de pagamento.
9. Você também tem a opção de marcar a transação como "bloqueada".
10. A página de listagem de movimentações exibe todas as transações, incluindo detalhes de usuários e produtos, método de pagamento e valor total calculado automaticamente.
11. Para melhor visibilidade dos dados, você pode clicar no botão "Visualizar" para verificar informações detalhadas do usuário e produtos.
12. Também é possível excluir transações, se necessário.
13. As transações podem ser filtradas por tipo de pagamento.
14. Ao clicar no botão "Totais", você pode ver o total de créditos, débitos e a soma dos dois.
15. O botão "CSV" permite baixar um relatório das transações criadas. Você pode escolher exportar todas as transações, relatórios mensais ou relatórios de um ano e intervalo de datas específicos.

### Comando para iniciar o projeto:
```bash
npm run dev
```

