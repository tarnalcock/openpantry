<pre>
<?php

include_once('include/config.inc.php');
include_once('library/mysql.lib.php');
include_once('library/inventory.lib.php');
include_once('library/bag.lib.php');
include_once('library/util.lib.php');
sql_wrap();

global $bagid;

// Create Bags for Family Size 1 through 10
$bag_names = array('1' => 'Family of One', '2' => 'Family of Two', '3' => 'Family of Three', '4' => 'Family of Four', '5' => 'Family of Five',
			'6' => 'Family of Six', '7' => 'Family of Seven', '8' => 'Family of Eight', '9' => 'Family of Nine', '10' => 'Family of Ten');
$bag_ids = array();
for($i = 1; $i <= 10; $i++) {
	$bag_id = create_bag($bag_names[$i], 'none'); // Create bag
	if(!$bag_id) {	// if bag alreadt exists get its bag_id
		$bag = get_bag_by_name($bag_names[$i]);  
		$bag_id = $bag['bagid'];
	}
	$bag_ids[$i] = $bag_id;  // Store bagids
}

// Read in Every row from Distribution.csv 
// Create Products in Inventory
// Add their Quantity to Each Family Size Bag
$row = 1;
if (($handle = fopen("distribution.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
		
		// Skip title rows
		if($row < 4) continue;
		
		echo "Create Product: " . $data[0]."<br/>";
		$product_id = create_product($data[0], '0');
		if(!$product_id) {
			$product = get_product_by_name($data[0]);
			$product_id = $product['productid'];
		}
		
		
		for($i = 1; $i <= 10; $i++) {
			$bag_id = $bag_ids[$i];
			$quantity = $data[$i];
			$choice = $data[11] == 'Y' ? '1' : '0';
			if($quantity != '') {
				echo "Bag Name: ".$bag_names[$i]." | BagID: ".$bag_id." | Quantity: " . $quantity . "<br/>";
				create_bag_content($bag_id, $product_id, $quantity, $choice, '');
			}
		}
		/*
		for ($c=0; $c < $num; $c++) {
            echo $data[$c] . "<br />\n";
        }*/
    }
    fclose($handle);
}
?>
</pre>