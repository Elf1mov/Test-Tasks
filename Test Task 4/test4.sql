CREATE TABLE city (
    id INT PRIMARY KEY,
    city VARCHAR(255)
);


INSERT INTO city (id, city) VALUES
(1, 'Калининград'),
(2, 'Москва'),
(3, 'Казань');


CREATE TABLE user (
    id INT PRIMARY KEY,
    firstName VARCHAR(255),
    lastName VARCHAR(255),
    city INT
);

INSERT INTO user (id, firstName, lastName, city) VALUES
(1, 'Мария', 'Ладоньковна', 1),
(2, 'Никита', 'Ефёлкин', 1),
(3, 'Иван', 'Ладовский', 2);


SELECT 
    user.firstName, 
    user.lastName, 
    city.city
FROM 
    user
INNER JOIN 
    city 
ON 
    user.city = city.id;
