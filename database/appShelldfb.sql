drop table users;

CREATE TABLE users (
id int(10) unsigned NOT NULL AUTO_INCREMENT,
name varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
username varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
email varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
raw_password varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
password varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
remember_token  varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
created_at  timestamp NULL DEFAULT NULL,
updated_at  timestamp NULL DEFAULT NULL,
PRIMARY KEY (id),
UNIQUE KEY `users_email_unique` (`email`));
