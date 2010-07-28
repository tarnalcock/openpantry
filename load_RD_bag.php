<pre>
<?php

include_once('include/config.inc.php');
include_once('library/mysql.lib.php');
include_once('library/inventory.lib.php');
include_once('library/bag.lib.php');
include_once('library/util.lib.php');
sql_wrap();

global $bagid;


if(!isset($_GET['bagfile'])) {
	$handle = opendir("bags/");
	while(false != ($file = readdir($handle))){
		if($file != "." && $file != "..")
			echo "<a href='load_RD_bag.php?bagfile=".$file."'>".$file."</a><br/>";
	}
	exit();
	return;

} 

echo "Import bagfile: ".$_GET['bagfile']."<br/>";
echo "Bag Name: ".substr($_GET['bagfile'],0,-4)."<br/>";

$path = 'bags/';
$filename = $_GET['bagfile'];
//$filename = "Ristricted Diet Request family of three.csv";

// Get title from CSV filename and Create Bag
$bagid = create_bag(substr($filename,0,-4), 'none');
if(!$bagid) {
	$bag = get_bag_by_name($name);
	$bagid = $bag['bagid'];
}

$row = 1;
if (($handle = fopen($path.$filename, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
		
		// Skip Heads Rows
		if($row < 4) continue;
		
		// Skip blank Product rows
		if($data[0] == '') continue;
		
		$product_name = $data[1];
		$quantity = $data[0];
		$notes = $data[2];
		$choice = $data[3] == "Y" ? '1' : '0';
		
		// Add Product to Bag (Create or Find Existing Product from inventory)
		import_bag_content(
		$bagid,
		$product_name,
		$quantity,
		$notes,
		$choice);
		
		
		echo "Product: " . $product_name . " | Quantity: " . $quantity . " | Notes: " . $notes . "<br/>";
		/*
		for ($c=0; $c < $num; $c++) {
            echo $data[$c] . "<br />\n";
        }*/
    }
    fclose($handle);
}
?>
</pre>