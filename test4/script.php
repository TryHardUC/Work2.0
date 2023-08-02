<?php
// Установить подключение к MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Функция для рекурсивного вывода меню групп товаров
function printMenu($parentId = 0) {
    global $conn;
    
    // Получить группы товаров по указанному parentId
    $sql = "SELECT * FROM `groups` WHERE `id_parent` = $parentId";
    $result = mysqli_query($conn, $sql);

    // Вывести список групп
    if (mysqli_num_rows($result) > 0) {
        echo "<ul>";
        while ($row = mysqli_fetch_assoc($result)) {
            $groupId = $row['id'];
            $groupName = $row['name'];
            echo "<li>";
            echo "<a href='?group=$groupId'>$groupName</a>";
            echo "(" . getProductCount($groupId) . ")";
            printMenu($groupId); // Рекурсивный вызов для вывода подгрупп
            echo "</li>";
        }
        echo "</ul>";
    }
}

// Функция для получения количества товаров в группе и ее подгруппах
function getProductCount($groupId) {
    global $conn;
    
    // Получить количество товаров в указанной группе и ее подгруппах
    $sql = "SELECT COUNT(*) AS count FROM `products` WHERE `id_group` IN (SELECT `id` FROM `groups` WHERE `id` = $groupId OR `id_parent` = $groupId)";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    
    return $row['count'];
}

// Получить значение GET-параметра 'group'
$groupParam = $_GET['group'] ?? 0;

// Вывести меню групп товаров
printMenu();

// Вывести все товары из таблицы при нажатии на кнопку 'Все товары'
echo "<a href='?group=0'>Все товары</a>";
if ($groupParam == 0) {
    // Получить все товары из таблицы
    $sql = "SELECT * FROM `products`";
} else {
    // Получить товары по указанной группе
    $sql = "SELECT * FROM `products` WHERE `id_group` = $groupParam";
}

$result = mysqli_query($conn, $sql);

// Вывести список товаров
echo "<ul>";
while ($row = mysqli_fetch_assoc($result)) {
    $productName = $row['name'];
    echo "<li>$productName</li>";
}
echo "</ul>";

// Закрыть подключение к MySQL
mysqli_close($conn);
?>