<?php

// php show code permissions current dir
// fileperms



// make file CURRENNT DIR

echo substr(sprintf('%o', fileperms('/app/bot')), -4);
// make file with fopen
$file = fopen('test.txt', 'w');