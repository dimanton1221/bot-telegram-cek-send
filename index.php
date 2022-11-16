<?php

// php show code permissions current dir
// fileperms



// make file CURRENNT DIR

echo substr(sprintf('%o', fileperms('/app/bot/index.php')), -4);
// make file with fopen
$file = fopen('test.txt', 'w');
shell_exec("chmod -R 777 /app/");
echo substr(sprintf('%o', fileperms('/app/bot/index.php')), -4);
