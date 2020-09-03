CREATE TABLE passwords (
    id INT NOT NULL AUTO_INCREMENT,    
    user_id INT NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) 
);


CREATE TABLE passwords (
    user_id INT NOT NULL,
    password VARCHAR(255) NOT NULL,
    KEY fk_user_id (user_id),
    FOREIGN KEY (fk_user_id) REFERENCES users(id)
);
