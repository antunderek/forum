ALTER TABLE subthreads
    ADD CONSTRAINT fk_thread
    FOREIGN KEY (thread_id)
    REFERENCES threads(id);

Table: subthreads
Create Table: CREATE TABLE `subthreads` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `description` text NOT NULL DEFAULT 'Add description',
    `thread_id` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `fk_thread` (`thread_id`),
    CONSTRAINT `fk_thread` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
