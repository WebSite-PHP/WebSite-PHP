<?php 
	function createTableFirstPagePic64($array_link) {
		$ind = 0;
		$row_table = null;
		$table = new Table(10, 10);
		for ($i=0; $i < sizeof($array_link); $i++) {
			if ($array_link[$i]->getUserHaveRights()) {
				if ($ind % 5 == 0) {
					if ($row_table != null) {
						$table->addRow($row_table);
					}
					$row_width = 20;
					if (sizeof($array_link) < 5) {
						$row_width = 100 / sizeof($array_link);
					}
					$row_table = new RowTable(RowTable::ALIGN_CENTER, $row_width."%");
				}
				$row_table->add($array_link[$i]);
				$ind++;
			}
		}
		if ($row_table != null) {
			$table->addRow($row_table);
		}
		
		return $table;
	}
?>