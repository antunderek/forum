INSERT INTO users (username, email)
VALUES (:username, :email);

INSERT INTO passwords (password, user_id)
VALUES (:password, (SELECT id FROM users WHERE username=:username));