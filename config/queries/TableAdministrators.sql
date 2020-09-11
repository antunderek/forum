CREATE TABLE administrators
(
    user_id int(11),
    CONSTRAINT fk_id FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);