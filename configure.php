<?php

include 'dbService.php';

$databaseService = new DatabaseService();
$conn = $databaseService->getConnection();

$stmt = $conn->prepare("DROP TABLE IF EXISTS messages");
$stmt->execute();

$stmt = $conn->prepare("CREATE TABLE messages(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    emitter VARCHAR(1024) NOT NULL,
    receiving VARCHAR(1024) NOT NULL,
    message longtext NOT NULL,
    visibleAt timestamp NOT NULL DEFAULT NOW(),
    createdAt timestamp NOT NULL DEFAULT NOW()
)");
$stmt->execute();

$stmt = $conn->prepare("DROP TABLE IF EXISTS nodes");
$stmt->execute();

$stmt = $conn->prepare("CREATE TABLE nodes(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(256) NOT NULL,
    address VARCHAR(256) NOT NULL,
    version VARCHAR(256) NOT NULL,
    fails INT NOT NULL DEFAULT 0,
    lastFail timestamp NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    updatedAt timestamp NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    createdAt timestamp NOT NULL DEFAULT NOW()
)");
$stmt->execute();
