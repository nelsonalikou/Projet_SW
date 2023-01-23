-- create a table
CREATE TABLE agents (
  id INTEGER NOT NULL AUTO_INCREMENT,
  name TEXT NOT NULL UNIQUE,
  gender TEXT CHECK (gender='F' OR gender='M'),
  class INTEGER NOT NULL,
  position INTEGER NOT NULL,
  PRIMARY KEY (id)
);
-- create a table
CREATE TABLE classes (
  id INTEGER NOT NULL AUTO_INCREMENT,
  name TEXT NOT NULL UNIQUE,
  description TEXT NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE localisation (
  id INTEGER NOT NULL AUTO_INCREMENT,
  cp char(5) NULL UNIQUE,
  PRIMARY KEY (id)
);
-- insert some values
INSERT INTO classes VALUES (1, 'Sentinel', 'sorts de couverture');
INSERT INTO classes VALUES (2, 'Controller', 'sorts de controlle');
INSERT INTO agents VALUES (1, 'Killjoy', 'F', 1, 1);
INSERT INTO agents VALUES (2, 'Omen', 'M', 2, 3);
INSERT INTO agents VALUES (3, 'Sage', 'F', 1, 5);
INSERT INTO localisation VALUES (1, '92360');
INSERT INTO localisation VALUES (2, '92220');
INSERT INTO localisation VALUES (3, '94310');
INSERT INTO localisation VALUES (4, '51100');
INSERT INTO localisation VALUES (5, '75000');


-- fetch some values
SELECT * FROM agents WHERE gender = 'F';