<pre>
<?php

include_once('include/config.inc.php');
include_once('library/mysql.lib.php');
include_once('library/client.lib.php');
include_once('library/food_source.lib.php');
include_once('library/financial_aid.lib.php');
include_once('library/util.lib.php');
sql_wrap();

$row = 1;
if (($handle = fopen("db.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
		
		// Skip Title Row
		if($data[1] == "Last Name1") continue;
		
		import_family(
		$data[1],
		$data[2],
		$data[3],
		$data[4],
		$data[5],
		$data[6],
		$data[7],
		$data[8],
		$data[9],
		$data[10],
		$data[11],
		$data[12],
		$data[13],
		$data[14],
		$data[15],
		$data[16],
		$data[17],
		$data[18],
		$data[19],
		$data[20],
		$data[21],
		$data[22],
		$data[23],
		$data[24],
		$data[25],
		$data[26],
		$data[27],
		$data[28],
		$data[29],
		$data[30],
		$data[31],
		$data[32],
		$data[33],
		$data[34],
		$data[35],
		$data[36],
		$data[37],
		$data[38],
		$data[39],
		$data[40],
		$data[41],
		$data[42],
		$data[43],
		$data[44],
		$data[45],
		$data[46],
		$data[47],
		$data[48],
		$data[49],
		$data[50],
		$data[51],
		$data[52],
		$data[53]);
        //for ($c=0; $c < $num; $c++) {
        //    echo $data[$c] . "<br />\n";
        //}
    }
    fclose($handle);
}
?>
</pre>