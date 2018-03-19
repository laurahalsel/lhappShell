use appshell;

drop table users;

CREATE TABLE users (
id int(10) unsigned NOT NULL AUTO_INCREMENT,
name varchar(191)  NOT NULL,
username varchar(191) NOT NULL,
email varchar(191) NOT NULL,
raw_password varchar(191)   NOT NULL,
password varchar(191)   NOT NULL,
remember_token  varchar(100)   DEFAULT NULL,
created_at  timestamp NULL DEFAULT NULL,
updated_at  timestamp NULL DEFAULT NULL,
PRIMARY KEY (id),
UNIQUE KEY `users_email_unique` (`email`));
