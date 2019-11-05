<?php

if(isset($_POST['fromfile']))
{
$f=$_POST['fromfile'];
dump_to_db($f,"all_orders",1);
}

if(isset($_POST['fromfile1']))
{
$f=$_POST['fromfile1'];
dump_to_db($f,"date_range_report",11);
}

if(isset($_POST['fromfile2']))
{
$f=$_POST['fromfile2'];
dump_to_db($f,"transaction_view_report",4);
}

if(isset($_POST['fromfile12']))
{
$f=$_POST['fromfile12'];
dump_to_db($f,"transaction_view_report",4);
}

if(isset($_POST['fromfile3']))
{
$f=$_POST['fromfile3'];
dump_to_db($f,"search_time_report",1);
}

if(isset($_POST['fromfile4']))
{
$f=$_POST['fromfile4'];
dump_to_db($f,"advertise_product_report",1);
}

if(isset($_POST['fromfile5']))
{
$f=$_POST['fromfile5'];
dump_to_db($f,"purchased_product_report",1);
}

if(isset($_POST['fromfile6']))
{
$f=$_POST['fromfile6'];
dump_to_db($f,"targeting_report",1);
}

if(isset($_POST['fromfile7']))
{
$f=$_POST['fromfile7'];
dump_to_db($f,"placement_report",1);
}

if(isset($_POST['fromfile8']))
{
$f=$_POST['fromfile8'];
dump_to_db($f,"campaign_report",1);
}

if(isset($_POST['fromfile9']))
{
$f=$_POST['fromfile9'];
dump_to_db($f,"performance_overtime_report",1);
}

if(isset($_POST['fromfile10']))
{
$f=$_POST['fromfile10'];
dump_to_db($f,"return_report",1);
}

if(isset($_POST['fromfile11']))
{
$f=$_POST['fromfile11'];
dump_to_db($f,"mt_report_b2b",1);
}

if(isset($_POST['fromfile13']))
{
$f=$_POST['fromfile13'];
dump_to_db($f,"mt_report_b2c",1);
}

if(isset($_POST['fromfile14']))
{
$f=$_POST['fromfile14'];
dump_to_db($f,"date_range_report",11);
}


?>