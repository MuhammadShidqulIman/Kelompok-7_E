-- Perintah untuk membuat tabel users
CREATE TABLE users (
  id int(11) NOT NULL AUTO_INCREMENT,
  username varchar(50) NOT NULL,
  password varchar(255) NOT NULL,
  role varchar(50) NOT NULL DEFAULT 'visitor',
  PRIMARY KEY (id),
  UNIQUE KEY username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Perintah untuk membuat tabel projects
CREATE TABLE projects (
  id INT NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  image_url TEXT NOT NULL,
  description TEXT NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;