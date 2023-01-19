use akademija;

# Task 1
# Creating Employees table for task 1 and 2

CREATE TABLE employees (
    id int NOT NULL AUTO_INCREMENT,
    first_name varchar(50),
    last_name varchar(50),
    salary float,
    PRIMARY KEY (id)
);

# Adding some employees for testing purposes

INSERT INTO employees (first_name, last_name, salary)
VALUES ('Jonas', 'Jonauskas', 912.23),
       ('Tomas', 'Tomauskas', 1120.6),
       ('Linas', 'Linelis', 863.3),
       ('Matas', 'Matauskas', 2163.36),
       ('Ieva', 'Ievaite', 1648);

# Getting all employees names and lastnames

SELECT first_name, last_name FROM employees;

# Task 2
# Raising the salary of 123rd employee by 10%

UPDATE employees
SET salary = salary * 1.1
WHERE id = 123;

# Task 3
# Creating Orders table

CREATE TABLE orders (
    id int NOT NULL AUTO_INCREMENT,
    order_date DATE,
    order_name varchar(50),
    order_price float,
    PRIMARY KEY (id)
);

# Adding orders for testing purposes

INSERT INTO orders (order_date, order_name, order_price)
VALUES ('2023-01-05', 'Pencils', 15.69),
       ('2021-12-16', 'Table', 351.89),
       ('2022-3-15', 'Chair', 69.99);

# Removing orders older than 1 year

DELETE FROM orders
WHERE DATEDIFF(CURDATE(), order_date) > 365;

# Task 4
# Creating customers table

CREATE TABLE customers (
    id int NOT NULL AUTO_INCREMENT,
    first_name varchar(50),
    last_name varchar(50),
    email varchar(100),
    PRIMARY KEY (id)
);

# Inserting John Doe into the table

INSERT INTO customers (first_name, last_name, email)
VALUES ('John', 'Doe', 'john.doe@email.com');