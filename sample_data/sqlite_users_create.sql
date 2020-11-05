CREATE TABLE IF NOT EXISTS users (
    id TEXT PRIMARY KEY,
    user_name TEXT,
    user_email TEXT,
    user_pwd TEXT
);
INSERT INTO users VALUES
('74bc1e4a85ff5b1922017e9c169f147d','fred', 'fred@caveman.com', 'password'),
('8cb4ab0f5537ff04be2f3108ece09012','wilma', 'wilma@gmail.com', 'password'),
('e533cd727b44b7ac9c445ff3b2ca5485','barney', 'brubble@rock.net', 'password'),
('73b629b55547942eeadd7131630055e8','betty', 'bettyr@new.clothes.biz', 'password');
