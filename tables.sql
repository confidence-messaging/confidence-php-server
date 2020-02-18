DROP TABLE IF EXISTS messages;
CREATE TABLE messages(
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    from char(256) NOT NULL,
    to char(256) NOT NULL,
    message longtext NOT NULL,
    updatedAt timestamp NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    createdAt timestamp NOT NULL DEFAULT NOW()
);

DROP TABLE IF EXISTS nodes;
CREATE TABLE nodes(
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name varchar(256) NOT NULL,
    address varchar(256) NOT NULL,
    version varchar(256) NOT NULL,
    fails int NOT NULL DEFAULT 0,
    lastFail timestamp NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    updatedAt timestamp NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    createdAt timestamp NOT NULL DEFAULT NOW()
);