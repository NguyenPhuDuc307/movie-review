-- Cập nhật poster cho các phim
USE movie_review;

UPDATE movies SET poster = 'uploads/posters/avengers-endgame.jpg' WHERE slug = 'avengers-endgame';
UPDATE movies SET poster = 'uploads/posters/parasite.jpg' WHERE slug = 'parasite';
UPDATE movies SET poster = 'uploads/posters/spirited-away.jpg' WHERE slug = 'spirited-away';
UPDATE movies SET poster = 'uploads/posters/the-dark-knight.jpg' WHERE slug = 'the-dark-knight';
UPDATE movies SET poster = 'uploads/posters/your-name.jpg' WHERE slug = 'your-name';
