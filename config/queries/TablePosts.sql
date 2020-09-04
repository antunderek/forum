CREATE TABLE posts (
    id INT NOT NULL AUTO_INCREMENT,
    topic_id INT NOT NULL,
    user_id INT NOT NULL,
    dateposted DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    post TEXT NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_topic_id FOREIGN KEY (topic_id) REFERENCES topics(id),
    CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES users(id)
);