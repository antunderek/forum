CREATE TABLE `threads` (
                           `id` int(11) NOT NULL AUTO_INCREMENT,
                           `name` varchar(255) NOT NULL,
                           `description` text NOT NULL DEFAULT '',
                           PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 |