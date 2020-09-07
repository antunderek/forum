CREATE TABLE threads (
   id int(11) NOT NULL AUTO_INCREMENT,
   name varchar(255) NOT NULL,
   description text NOT NULL DEFAULT 'Add description',
   PRIMARY KEY (id)
);