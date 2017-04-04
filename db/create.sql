CREATE TABLE Cart (
    cartId varchar(32),
    updated timestamp,
    primary key(cartId)
);

CREATE TABLE Product (
    productId integer primary key autoincrement,
    title varchar(100),
    description text,
    price int
);

CREATE TABLE CartProduct (
    cartProductId integer primary key autoincrement,
    cartId varchar(32),
    productId int,
    quantity int
);

INSERT INTO Product (title, description, price) VALUES
("Computer", "The best computer - In the world", 12999);
INSERT INTO Product (title, description, price) VALUES
("Laptop", "The best laptop - In the world", 22999);
INSERT INTO Product (title, description, price) VALUES
("Phone", "The best phone - In the world", 32999);
INSERT INTO Product (title, description, price) VALUES
("Memory Stick", "The best memory stick - In the world", 99);
