<pre>
<?php

include_once('include/config.inc.php');
include_once('library/mysql.lib.php');
include_once('library/inventory.lib.php');
include_once('library/bag.lib.php');
include_once('library/util.lib.php');
sql_wrap();

global $bagid;

$row = 1;
if (($handle = fopen("bagdb.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
		
		// Skip blank rows
		if($data[0] == '') continue;
		
		// Get title from CSV and Create Bag
		if($row == 3) { 
			$name = $data[0];
			echo "Create Bag: " . $name."<br/>";
			$bagid = create_bag($name);
			if(!$bagid) {
				$bag = get_bag_by_name($name);
				$bagid = $bag['bagid'];
			}			
		}
		
		// Skip Title Row
		if($row < 4) continue;
		
		// Add Product to Bag (Create or Find Existing Product from inventory)
		import_bag_content(
		$bagid,
		$data[0],
		$data[2],
		$data[3]);
		
		
		echo "Product: " . $data[0] . " | Quantity: " . $data[2] . " | Notes: " . $data[3] . "<br/>";
		/*
		for ($c=0; $c < $num; $c++) {
            echo $data[$c] . "<br />\n";
        }*/
    }
    fclose($handle);
}
?>
</pre>