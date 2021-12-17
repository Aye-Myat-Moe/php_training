<?php
$file = fopen("sample.txt", "r");

//Output lines until EOF is reached
while(! feof($file)) {
  $line = fgets($file);
  echo $line. "<br>";
}

fclose($file);
?>
<?php
$file = fopen("sample.doc", "r");

//Output lines until EOF is reached
while(! feof($file)) {
  $line = fgets($file);
  echo $line. "<br>";
}

fclose($file);
?>
<?php
$file = fopen("sample.csv","r");

while(! feof($file))
  {
  print_r(fgetcsv($file));
  }

fclose($file);
?>
<?php
include("library/SimpleXLSX.php");
if ($xlsx = SimpleXLSX::parse('sample.xlsx')) {
  echo '<table border="1" cellpadding="3" style="border-collapse: collapse">';
  foreach ($xlsx->rows() as $r) {
    echo '<tr><td>' . implode('</td><td>', $r) . '</td></tr>';
  }
  echo '</table>';
} else {
  echo SimpleXLSX::parseError();
}
?>

