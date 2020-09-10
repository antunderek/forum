DELIMITER $$
CREATE TRIGGER user_deleted
    BEFORE DELETE ON users
    FOR EACH ROW
    BEGIN
        UPDATE posts SET user_id = 1 WHERE user_id = OLD.id;
        UPDATE topics SET user_id = 1 WHERE user_id = OLD.id;
    END $$
DELIMITER ;