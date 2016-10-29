<?php
include 'src/Set.php';

$set = new MarcoKretz\PHPUtils\Set();
$set2 = new MarcoKretz\PHPUtils\Set();

$set2->addAll(['a', 'b', 'c']);
$set->addAll([1, 2, 3, $set2, 4, 5]);

print($set);
