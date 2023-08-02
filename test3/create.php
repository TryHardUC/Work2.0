<?php
// Параметры подключения
$mysqli = new mysqli("localhost", "root", "", "newBD");

// Проверка подключения
if ($mysqli === false) {
    die("ERROR: Ошибка подключения. " . $mysqli->connect_error);
}

// Запрос на создание таблицы
$sql = "CREATE TABLE IF NOT EXISTS tests(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    script_name CHAR(25) NOT NULL,
    start_time INT NOT NULL,
    end_time INT NOT NULL,
    result ENUM('normal', 'illegal', 'failed', 'success') NOT NULL
)";

// Проверка запроса
if ($mysqli->query($sql) === true) {
    echo "Таблица успешно создана.";
} else {
    echo "ERROR: Не удалось выполнить $sql. " . $mysqli->error;
}

echo $sql;

$mysqli->close();
