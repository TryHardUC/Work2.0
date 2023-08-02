<?php
class TestTable
{
    private $connection;

    public function __construct($host, $user, $password, $database)
    {
        // Устанавливаем соединение с базой данных
        $this->connection = new mysqli($host, $user, $password, $database);
        if ($this->connection->connect_error) {
            throw new Exception("Failed to connect to database: " . $this->connection->connect_error);
        }
    }

    public function fill()
    {
        // Генерируем случайные данные и заполняем таблицу tests
        $scriptNames = ["Script1", "Script2", "Script3", "Script4", "Script5"];
        $results = ["normal", "illegal", "failed", "success"];

        $query = "INSERT INTO tests (script_name, start_time, end_time, result) VALUES (?, ?, ?, ?)";
        $stmt = $this->connection->prepare($query);

        $currentTime = time();

        // Заполняем таблицу тестов случайными данными
        for ($i = 0; $i < 100; $i++) {
            $scriptName = $scriptNames[array_rand($scriptNames)];
            $startTime = $currentTime - rand(0, 3600);  // случайная дата в пределах часа
            $endTime = $startTime + rand(0, 600);  // случайная дата в пределах 10 минут
            $result = $results[array_rand($results)];

            $stmt->bind_param("ssss", $scriptName, $startTime, $endTime, $result);
            $stmt->execute();
        }
        $stmt->close();
    }

    public function get()
    {
        // Получаем данные из таблицы tests по критерию result равному 'normal' или 'success'
        $query = "SELECT * FROM tests WHERE result IN ('normal', 'success')";
        $result = $this->connection->query($query);

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    public function __destruct()
    {
        // Закрываем соединение с базой данных
        $this->connection->close();
    }
}

// Пример использования класса
$host = "localhost";
$user = "root";
$password = "";
$database = "newbd";

$table = new TestTable($host, $user, $password, $database);
$table->fill();
$data = $table->get();
print_r($data);
