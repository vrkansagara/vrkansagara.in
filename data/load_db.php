<?php

$db = new PDO('sqlite:' . realpath(__DIR__) . '/vrkansagara.sqlite3');
$fh = fopen(__DIR__ . '/vrkansagara.sql', 'r');
while ($line = fread($fh, 4096)) {
    $db->exec($line);
}
fclose($fh);


