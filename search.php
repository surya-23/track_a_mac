<?php
include_once('config.php');

if (empty($_GET)) {
    echo "FALSE";
    }
else {
    $search = htmlspecialchars($_GET["mac"]);
    $sql = <<<EOF
              SELECT * FROM List WHERE MACS LIKE "%$search%" ORDER BY MACS;
EOF;
    $output= $db->query($sql);
    $d= array(); 
    while($row = $output->fetchArray(SQLITE3_ASSOC) ){
         #echo $row[1]. "|" . $row[2] . "|" . $row[3] . "|" . $row[4] . "\n";
         $d[] = $row['IP']. " | " . $row['VLANs'] . " | " . $row['PORT'] . " | " . "$search";
     
    }

$flag = count($d);
if($flag ==0){
    $count = $db->query('SELECT count(*) FROM info');
    while($check = $count->fetchArray(SQLITE3_ASSOC)) {
        $number_of_devices = $check['count(*)'];
        echo "We found no match in $number_of_devices devices"."\n";
     }
}

$result = array_unique($d);
$t = count($result);
for($i = 0; $i < $t; $i++){
    echo $result[$i]. "\n";
    }
}
$db->close();

?>
