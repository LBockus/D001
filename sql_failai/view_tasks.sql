use eshop;

#Task 1

CREATE VIEW workplace AS
SELECT concat(employees.first_name, ' ', employees.last_name) AS full_name, departments.title
FROM employees
         LEFT JOIN departments on departments.id = employees.departments_id
ORDER BY departments.id;

#Task 2

CREATE VIEW order_info AS
SELECT concat(customers.first_name, ' ', customers.last_name) AS full_name, orders.order_price
FROM customers
         LEFT JOIN orders on orders.id = customers.order_id
WHERE orders.order_price > 50
order by customers.id;

#Task 3

CREATE VIEW reorder_info AS
SELECT products.title, inventory.quantity, inventory.reorder_level
FROM products
         LEFT JOIN inventory
                   ON products.id = inventory.product_id
WHERE inventory.quantity < inventory.reorder_level
ORDER BY product_id;

#Task 4

use akademija;

CREATE VIEW enrolled_students AS
SELECT concat(students.first_name, ' ', students.last_name) AS full_name,
       classes.title AS class_name,
       enrollments.enroll_date
FROM students
         LEFT JOIN enrollments
                   ON students.id = enrollments.student_id
         LEFT JOIN classes
                   ON enrollments.class_id = classes.id
order by enrollments.enroll_date;