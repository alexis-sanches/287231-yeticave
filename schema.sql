CREATE DATABASE yeticave;
USE yeticave;

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title CHAR(32)
);

CREATE TABLE lots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  created_at DATETIME,
  title CHAR(128),
  description TEXT(500),
  image_url CHAR(128),
  price INT,
  finished_at DATETIME,
  bet_step INT,
  likes INT,
  author_id INT,
  winner_id INT,
  category_id TINYINT
);

CREATE TABLE bets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  created_at DATETIME,
  cost INT,
  user_id INT,
  lot_id INT
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  created_at DATETIME,
  email CHAR(128),
  name CHAR(32),
  password CHAR(32),
  image_url CHAR(128),
  contacts CHAR(128)
);

CREATE UNIQUE INDEX title ON categories(title);

CREATE UNIQUE INDEX email ON users(email);

CREATE INDEX title on lots(title);

CREATE INDEX created_at on bets(created_at);