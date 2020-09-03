SELECT users.email, passwords.password, users.username
FROM users
INNER JOIN passwords ON users.id = passwords.user_id
WHERE users.email=:email;