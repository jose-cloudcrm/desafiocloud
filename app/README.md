
## Pre-requisites

- Basic programming logic;
- Knowledge of databases;
- Understanding of REST, HTTP, and APIs;
- Familiarity with Git version control;

## Running the Project - Front End

1. On the homepage, you can immediately view all registered users.
2. To create a new user, navigate to the user creation form, which includes fields for name, email, password, and date of birth.
3. User registration is only possible if the user is over 18 years old, the email is unique, and the password contains more than 6 characters.
4. After creating a user, you can edit any information or delete the user if no transactions are linked to them.
5. After registering users, proceed to product registration.
6. In the product registration form, you can fill in details like product name, quantity, and price.
7. Next, head to the transaction registration.
8. In the transaction area, you can select multiple products, an existing user, and a payment method.
9. You also have the option to mark the transaction as "blocked."
10. The transaction listing page displays all transactions, including user and product details, payment method, and automatically calculated total value.
11. For better data visibility, you can click the "View" button to check detailed user and product information.
12. You can also delete transactions if needed.
13. Transactions can be filtered by payment type.
14. By clicking on the "Totals" button, you can see the total credit and debit amounts, as well as the combined sum.
15. The "CSV" button allows you to download a report of the created transactions. You can choose to export all transactions, monthly reports, or reports for a specific year and date range.

### Command to start the project:
```bash
npm run dev
```

