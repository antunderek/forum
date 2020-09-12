CREATE TABLE users
(
    id       INT          NOT NULL AUTO_INCREMENT,
    username VARCHAR(50)  NOT NULL,
    email    VARCHAR(255) NOT NULL,
    image    VARCHAR(255) DEFAULT 'default/default.jpg',
    PRIMARY KEY (id),
    UNIQUE KEY (username),
    UNIQUE KEY (email)
);