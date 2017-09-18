CREATE DATABASE yeticave;
USE yeticave;

CREATE TABLE categories (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title CHAR(32) NOT NULL
);

CREATE TABLE lots (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  created_at DATETIME,
  title CHAR(128) NOT NULL,
  description TEXT(500) NOT NULL,
  image_url CHAR(128) NOT NULL,
  price FLOAT NOT NULL,
  finished_at DATETIME NOT NULL,
  bet_step INT UNSIGNED NOT NULL,
  likes INT UNSIGNED DEFAULT 0,
  author_id INT UNSIGNED,
  winner_id INT UNSIGNED,
  category_id INT UNSIGNED
);

CREATE TABLE bets (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  created_at DATETIME,
  cost INT UNSIGNED NOT NULL,
  user_id INT UNSIGNED,
  lot_id INT UNSIGNED
);

CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  created_at DATETIME,
  email CHAR(128) NOT NULL,
  name CHAR(32) NOT NULL,
  password CHAR(128) NOT NULL,
  image_url CHAR(128),
  contacts CHAR(128) NOT NULL
);

CREATE UNIQUE INDEX title ON categories(title);

CREATE UNIQUE INDEX email ON users(email);

CREATE INDEX title on lots(title);

CREATE INDEX created_at on bets(created_at);