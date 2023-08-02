<?php 
// Функция для проверки наличия трех последовательно восходящих цифр
function hasAscendingSequence($number)
{
    $digits = str_split($number);
    for ($i = 0; $i < count($digits) - 2; $i++) {
        if (($digits[$i + 1] - $digits[$i] == 1) && ($digits[$i + 2] - $digits[$i + 1] == 1)) {
            return true;
        }
    }
    return false;
}
$sum = 0;
for ($i = 1; $i <= 10000; $i++) {
    if (!hasAscendingSequence($i)) {
        $sum += $i;
    }
}
echo "Сумма оставшихся чисел: " . $sum;
