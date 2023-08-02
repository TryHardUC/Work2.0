<?php
$users = [
  [
    "id" => 1,
    "name" => "User1",
    "email" => "user1@example.com"
  ],
  [
    "id" => 2,
    "name" => "User2",
    "email" => "user2@example.com"
  ],
  [
    "id" => 3,
    "name" => "User3",
    "email" => "user3@example.com"
  ],
  [
    "id" => 4,
    "name" => "User4",
    "email" => "user4@example.com"
  ],
  [
    "id" => 5,
    "name" => "User5",
    "email" => "user5@example.com"
  ]
];

$name = $_POST["name"];
$surname = $_POST["surname"];
$email = $_POST["email"];
$password = $_POST["password"];
$confirmPassword = $_POST["confirmPassword"];

if ($password !== $confirmPassword) {
  // Логирование результата проверки
  $logMessage = "Пароль у пользователя '$email' не совпал";
  file_put_contents("log.txt", $logMessage, FILE_APPEND);
}
// Проверка на существующего пользователя с таким email
foreach ($users as $user) {
  if ($user["email"] === $email) {
    // Логирование результата проверки
    $logMessage = "Пользователь с email '$email' уже существует";
    file_put_contents("log.txt", $logMessage, FILE_APPEND);
    echo $logMessage;
    exit();
  }
}

// Если пользователь с таким email не существует, добавляем его в массив пользователей
$users[] = [
  "id" => count($users) + 1,
  "name" => $name,
  "email" => $email
];

// Логирование успешной регистрации
$logMessage = "Пользователь с email '$email' успешно зарегистрирован";
file_put_contents("log.txt", $logMessage, FILE_APPEND);

echo "success";
