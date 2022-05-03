<?php
ob_start();
passthru('/usr/local/bin/python /home1/alexdalg/public_html/finance/API/getStockHistory.py');
$output = ob_get_clean();

echo $output;
?>