CREATE TABLE sessions
(
    id         INT NOT NULL,
    session_id VARCHAR(40),
    FOREIGN KEY (id) REFERENCES users (id) ON DELETE CASCADE
);