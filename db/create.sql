CREATE TABLE Cart (
    cartId varchar(32),
    updated timestamp,
    primary key(cartId)
);

CREATE TABLE PRODUCT (
    productId int,
    title varchar(100),
    description text,
    price int,
    primary key (productId)
);

CREATE TABLE CartProduct (
    cartProductId int
    cartId varchar(32),
    productId int,
    quantity int,
    primary key (cartProductId)
);
