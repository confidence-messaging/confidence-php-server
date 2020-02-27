DROP TABLE IF EXISTS messages;
CREATE TABLE messages(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    from CHAR(1024) NOT NULL,
    to CHAR(1024) NOT NULL,
    message longtext NOT NULL,
    visibleAt timestamp NOT NULL DEFAULT NOW(),
    createdAt timestamp NOT NULL DEFAULT NOW()
);

DROP TABLE IF EXISTS nodes;
CREATE TABLE nodes(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(256) NOT NULL,
    address VARCHAR(256) NOT NULL,
    version VARCHAR(256) NOT NULL,
    fails INT NOT NULL DEFAULT 0,
    lastFail timestamp NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    updatedAt timestamp NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    createdAt timestamp NOT NULL DEFAULT NOW()
);