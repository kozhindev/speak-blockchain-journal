<?php

$lines = [
    'Почистил зубы',
    'Купил кофе',
    'Дал в долг Стасу',
    'Переспал с Светой',
    'Поехал домой на такси',
];


function myhash($str) {
    usleep(500);
    return substr(md5($str), 0, 4);
}




// ------------------------------
echo "\n---\n 1. Оригинальный список\n";
$time = microtime(true);

foreach ($lines as $i => $line) {
    echo "\t$i. $line\n";
}

echo "\tTime: " . round((microtime(true) - $time), 4) . "s\n";
echo "\n";




// ------------------------------
echo "\n---\n 2. Стас подменил список\n";
$fakeLines = $lines;
$fakeLines[2] = 'Сходил в магазин';
$time = microtime(true);

foreach ($fakeLines as $i => $line) {
    echo "\t$i. $line\n";
}

echo "\tTime: " . round((microtime(true) - $time), 4) . "s\n";
echo "\n";




// ------------------------------
echo "\n---\n 3. Список с хешем\n";
$time = microtime(true);

$hash = '0000';
foreach ($lines as $i => $line) {
    $hash = myhash("$hash $line");
    echo "\t$i. $hash $line\n";
}

echo "\tTime: " . round((microtime(true) - $time), 4) . "s\n";
echo "\n";




// ------------------------------
echo "\n---\n 4. Стас и таджики подменили список\n";
$fakeLines = $lines;
$fakeLines[2] = 'Переспал с Олей';
$time = microtime(true);

$hash = '0000';
foreach ($fakeLines as $i => $line) {
    $hash = myhash("$hash $line");
    echo "\t$i. $hash $line\n";
}

echo "\tTime: " . round((microtime(true) - $time), 4) . "s\n";
echo "\n";




// ------------------------------
echo "\n---\n 5. Список с усложненным хешем\n";
$time = microtime(true);

$hash = '0000';
$prevHash = $hash;
foreach ($lines as $i => $line) {
    // Подбор "нонса"
    $finedNonce = null;
    for ($nonce = 0; $nonce < 999; $nonce++) {
        $tmpHash = myhash("$hash $nonce $line");
        if (substr($tmpHash, -2, 2) === '00') {
            $finedNonce = $nonce;
            $hash = $tmpHash;
            break;
        }
    }
    if (!$finedNonce) {
        echo "ERROR. Hash not found.\n";
    }

    echo "\t$i. $hash $finedNonce $line\n";

    // Проверка хеша
    echo "\tПроверка: myhash('$prevHash $finedNonce $line') = " . myhash("$prevHash $finedNonce $line") . "\n\n";

    $prevHash = $hash;
}

echo "\tTime: " . round((microtime(true) - $time), 4) . "s\n";
echo "\n";

