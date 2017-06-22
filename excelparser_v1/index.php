<html>
	<head>
		<link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
	</head>
	<body>
	<style>
		.wrapper {margin: 0 auto; max-width: 800px; min-height: 100%;}
		td,th {padding:15px;}
	</style>
<?php
	// If you need to parse XLS files, include php-excel-reader
	require('script/spreadsheet-reader/php-excel-reader/excel_reader2.php');
	require('script/spreadsheet-reader/SpreadsheetReader.php');
	
	$sheet_names = array();
	
	try {
		$reader = new SpreadsheetReader('files/FachprogrammMaster.xlsx');
		$baseMem = memory_get_usage();
		$sheets = $reader->Sheets();
		
		foreach ($sheets as $sheet_index => $sheet_name) {
			$sheet_names[$sheet_index] = $sheet_name;
		}
	}
	catch (Exception $E){
		echo $E -> getMessage();
	}
	
?>
		<div class="wrapper">
			<div>php Excel-Parser</div>
			<div>
				<p>Ihre Exceldatei besteht aus folgenden Sheets</p>
				<ul>
					<?php 
						foreach( $sheet_names as $k_index => $k_name) {
							echo "<li>" . $k_name . "</li>";
						}
					?>
				</ul>
			</div>
			<div>
				<?php
				foreach ($sheets as $sheet_index => $sheet_name) {
					$reader->ChangeSheet($sheet_index);
					$shown_index = $sheet_index;
					echo "<h3>Sheet Nr.: " . ++$shown_index . " (" . $sheet_name . ")</h3>";
					echo "<table class='table table-striped'>";
					echo "<thead>";
					echo "<tr>";
					echo "<tbody>";
					foreach ($reader as $key => $row) {
						if($key == 0) { 							
							echo "<tr>";
							foreach($row as $column_head_index => $head_column) {
								echo "<th><b>" . $head_column . "</b></th>";
							}
							echo "</tr>"; 			
						}
					}		
					echo "</tr>";
					echo "</thead>";
					echo "<tbody>";
					foreach ($reader as $key => $row) {
						if($key > 0) { 							
							echo "<tr>";
							foreach($row as $column_index => $column) {
								echo "<td>" . $column . "</td>";
							}
							echo "</tr>"; 			
						}
						
					}			
				
					echo "</tbody>";
					echo "</table>";	
				}
				?>
			</div>
		</div>
	</body>
</html>