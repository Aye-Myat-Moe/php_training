<?php
$tr=6;
for($r=1;$r<=$tr;$r++){
    for ($space=$tr-$r;$space>=1;$space--){
        echo " 	&#160;";
    }
    for ($star=1;$star<=2*$r-1;$star++){
        echo ("*");
    }
    echo "<br>";
}
for($r=$tr-1;$r>=1;$r--){
    for ($space=1;$space<=$tr-$r;$space++){
        echo " 	&#160;";
    }
    for ($star=1;$star<=2*$r-1;$star++){
        echo ("*");
    }
    echo "<br>";
}
?>