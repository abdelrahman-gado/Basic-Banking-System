CREATE TABLE customers (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(200) NOT NULL,
  email VARCHAR(200) NOT NULL UNIQUE,
  current_balance NUMERIC(10, 2) NOT NULL CHECK (current_balance >= 0)
);