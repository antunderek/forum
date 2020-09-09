CREATE TABLE topics (
                        id INT NOT NULL AUTO_INCREMENT,
                        thread_id INT,
                        name VARCHAR(255) NOT NULL,
                        description VARCHAR(255) DEFAULT "",
                        user_id INT,
                        created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        PRIMARY KEY (id),
                        CONSTRAINT fk_thread FOREIGN KEY (thread_id) REFERENCES threads(id),
                        CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(id)
);
