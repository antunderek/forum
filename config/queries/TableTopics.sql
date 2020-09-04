CREATE TABLE topics (
    id INT NOT NULL AUTO_INCREMENT,
    subthread_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(255) DEFAULT "",
    user_id INT,
    created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    CONSTRAINT fk_subthread_id FOREIGN KEY (subthread_id) REFERENCES subthreads(id),
    CONSTRAINT fk_owner_id FOREIGN KEY (user_id) REFERENCES users(id)
);