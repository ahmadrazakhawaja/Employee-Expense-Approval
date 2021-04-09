# Employee Expense Approval
## Technologies used:
**Backend:**
1. PHP

**Frontend:**
1. JavaScript
2. HTML 
3. CSS
4. Bootstrap

**Database:**
1. MySQL


Live Project: http://157.245.209.225/ahmad_raza_17926/public/

## Project Description:
This is an ERP sub module for employee expense approval process. Employees in various departments incur expenses on the company's behalf. The company later on reimburses this amount to employees. The planning and budgeting department prepares employee designation/position wise expense budgets for a year and it is broken down to months. Expenses are of different categories for example Hotel stay, transport, meal, and airfare etc. Employee submits the expenses for reimbursement via an online form. The department head approves the request and the request is now available in the Accounts Department. The system automatically rejects the request if the request amount exceeds the budget amount. If the amount is within budget, then the amount is reimbursed to the employee and an expense entry is made into the Accounting system.

## Files Description:
**These are some of the files in the project:**

1. **public/index.php**: 
This is the file which faces the public. when a user types the url this page opens first. It displays the login form and process and verifies the data coming through POST request from the login form.

2. **src/**: 
This folder containse files for handling all the different pages on the Web app. So for example the account_check.php handles the verification of the expense after head of department approves the expense amount. It checks whether the expense amount is within budget. Emp_ent.php dispalys the accounting entries after fetching the expense details from the database.


3. **Stylesheets/**: 
Contains static content for frontend. CSS stylesheet, javascript file to handle frontend interactivity and bootstrap file are contained in this folder.

4. **Templates**:
It contains Template file for frontend. Twig is used as a templating engine.
      

## Deployment

I have deployed this web app on a Linux based virtual private server, which uses Apache http server for request handling. 

