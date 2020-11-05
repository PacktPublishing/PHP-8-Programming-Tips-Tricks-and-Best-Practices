CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY,
    user_name TEXT,
    user_email TEXT,
    user_pwd TEXT
);
INSERT INTO users (user_name, user_email, user_pwd) VALUES
('fred', 'fred@caveman.com', 'password'),
('wilma', 'wilma@gmail.com', 'password'),
('barney', 'brubble@rock.net', 'password'),
('betty', 'bettyr@new.clothes.biz', 'password');
