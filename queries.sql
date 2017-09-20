/* Заполнить таблицу категорий */
INSERT INTO categories
  (title)
VALUES
  ('Доски и лыжи'),
  ('Крепления'),
  ('Ботинки'),
  ('Одежда'),
  ('Инструменты'),
  ('Разное');

/* Заполнить таблицу пользователей */
INSERT INTO users
(created_at, email, name, password, image_url, contacts)
VALUES
  ('2017-07-14 10:00:00', 'ignat.v@gmail.com', 'Игнат', '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka', 'img/user.jpg', '+79554245458'),
  ('2017-07-21 10:00:00', 'kitty_93@li.ru', 'Леночка', '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa', 'img/user.jpg', '+75215452145'),
  ('2017-08-01 10:00:00', 'warrior07@mail.ru', 'Руслан', '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW', 'img/user.jpg', '+74541215456');

/* Заполнить таблицу объявлений */
INSERT INTO lots
  (created_at, title, description, image_url, price, finished_at, bet_step, likes, author_id, winner_id, category_id)
VALUES
  ('2017-08-11 10:00:00', '2014 Rossignol District Snowboard', 'description', 'img/lot-1.jpg', 10999, '2017-10-11 00:00:00', 500, 10, 1, 3, 1),
  ('2017-09-12 11:10:00', 'DC Ply Mens 2016/2017 Snowboard', 'description', 'img/lot-2.jpg', 159999, '2017-10-01 00:00:00', 6000, 120, 2, 2, 1),
  ('2017-07-29 12:20:00', 'Крепления Union Contact Pro 2015 года размер L/XL', 'description', 'img/lot-3.jpg', 8000, '2017-10-05 00:00:00', 250, 14, 3, NULL , 2),
  ('2017-09-14 13:30:00', 'Ботинки для сноуборда DC Mutiny Charocal', 'description', 'img/lot-4.jpg', 10999, '2017-10-22 00:00:00', 450, 10, 1, NULL, 3),
  ('2017-09-01 14:40:00', 'Куртка для сноуборда DC Mutiny Charocal', 'description', 'img/lot-5.jpg', 7500, '2017-10-30 00:00:00', 100, 10, 2, 2, 4),
  ('2017-09-17 15:50:00', 'Маска Oakley Canopy', 'description', 'img/lot-6.jpg', 5400, '2017-10-30 00:00:00', 50, 10, 3, 1, 6);

/* Заполнить таблицу ставок */
INSERT INTO bets
  (created_at, cost, user_id, lot_id)
VALUES
  ('2017-09-11 20:19:44', 11999, 3, 4),
  ('2017-08-29 11:22:33', 11499, 2, 4);

/* Получить список из всех категорий */
SELECT * FROM categories;

/* Получить самые новые, открытые лоты */
SELECT l.id, l.title, price, image_url, COALESCE(MAX(cost), price) AS current_price, COUNT(cost) AS bet_cnt, c.title AS cat_title
FROM lots l
  JOIN categories c ON l.category_id = c.id
  LEFT JOIN bets b ON l.id = b.lot_id
WHERE winner_id IS NULL
GROUP BY l.id ORDER BY l.created_at DESC;

/* Найти лот по его названию или описанию */
SELECT * FROM lots WHERE title LIKE '%Rossignol%' OR description LIKE '%Rossignol%';

/* Обновить название лота по его идентификатору */
UPDATE lots SET title ='New Title' WHERE id = 1;

/* Получить список самых свежих ставок для лота по его идентификатору */
SELECT id, created_at, cost, user_id FROM bets WHERE lot_id = 1 ORDER BY created_at DESC;