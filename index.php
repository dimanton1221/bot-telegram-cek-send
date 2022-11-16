<?php

// php show code permissions current dir
// fileperms



// make file CURRENNT DIR

echo substr(sprintf('%o', fileperms('/app/bot')), -4);
