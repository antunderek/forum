CREATE TABLE passwords (
    user_id INT NOT NULL,
    password VARCHAR(255) NOT NULL,
    KEY fk_user_id (user_id),
    CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);