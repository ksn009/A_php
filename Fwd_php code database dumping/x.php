<?php
//ini_set('max_execution_time',3000);

function dump_to_db($fromfile,$table_name,$n)
{
require 'vendor\autoload.php';
$inputFileType = 'Csv';

$inputFileName = "$fromfile";

/**  Create a new Reader of the type defined in $inputFileType  **/
$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
/**  Load $inputFileName to a Spreadsheet Object  **/
$spreadsheet = $reader->load($inputFileName);
//var_dump($spreadsheet);
$data = array(1,$spreadsheet->getActiveSheet() 
            ->toArray(null,true,true,true)); 
  
// Display the sheet content 
//var_dump($data); 
$highestColumm = $spreadsheet->setActiveSheetIndex(0)->getHighestColumn();
$highestRow = $spreadsheet->setActiveSheetIndex(0)->getHighestRow();

$highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumm); // e.g. 5


//echo $highestColumm."<br>";
//echo $highestRow;
$a=array();
for($i=$n;$i<=$highestRow;$i++)
{
	for($j=1;$j<=$highestColumnIndex;$j++){
		//$p="'".$v.$i."'";
		//echo $p."<br/>";
		
   $a[$i][]=$spreadsheet->setActiveSheetIndex(0)->getCellByColumnAndRow($j,$i)->getValue();
   
}

}
$column_names =$a[$n];
//include 'cl.php';


// Create connection

//$t=$spreadsheet->setActiveSheetIndex(0)->getCell('A11')->getValue();
//var_dump($a);


   
	    $base_query = "INSERT INTO $table_name";
	
$type="varchar(150)";
	$create_base="create table IF NOT EXISTS $table_name(";
    // Include column headings if required
	//$gcn=array();
     $ctn=array();
        $base_query .= " (";
        $first      = true;
		
        foreach ($column_names as $column_name) {
			/*if($column_name==$cname)
			{
				continue;
			}*/
            if ($first === false) {
                $base_query .= ", ";
				$create_base.=",";
            }
				$column_name=str_replace('(','',$column_name);
				$column_name=str_replace(')','',$column_name);
				$column_name=str_replace('?','',$column_name);
				$column_name=str_replace('-','_',$column_name);
				$column_name=str_replace('#','',$column_name);
				$column_name=str_replace('/','_',$column_name);
				$column_name=str_replace('\\','_',$column_name);
				$column_name=str_replace(',','_',$column_name);
				$column_name=str_replace('\'','_',$column_name);
				$column_name = strtolower($column_name);
                $column_name = str_replace(' ', '_', $column_name);
                $column_name = trim($column_name);
			$ctn[]=$column_name;
$create_base.="$column_name $type";
	
            $base_query .= "$column_name";
            $first = false;
			
        }
        $base_query .= ")";
		$create_base.=');';
	
	
   
   //echo $base_query;
   //echo "<br>";
   //echo $create_base;
   

// Check connection
$servername = "learntest.joomla.com";
$username = "qopaqamux";
$password = "y5xdSdML";
$dbname = "qopaqamux";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->query($create_base) === TRUE) {
 //  echo "table created</br>";
} else {
    echo "Error: " . $create_base . "<br>" . $conn->error;
}

$sql="";
	$in="insert into $table_name values(";
$query='';
    // Loop through all CSV data rows and generate separate
    // INSERT queries based on base_query + the row information
    $last_data_row = count($a);
	$sql="";
    for ($counter = $n+1; $counter < $last_data_row; $counter++) {
        $value_query = "VALUES ('";
        $first = true;
        $data_row = $a[$counter];
        $value_counter = 0;
        foreach ($data_row as $data_value) {
            if ($first === false) {
                $value_query .= "', '";
            }
				$data_value=str_replace('?','',$data_value);
				$data_value=str_replace('//','',$data_value);
				$data_value=str_replace('\'','',$data_value);
				$data_value = trim($data_value);
				//$data_value=str_replace(',','',$data_value);
				//$data_value=str_replace('|','',$data_value);
				//$data_value=str_replace(' ','',$data_value);
            $value_query .= "$data_value";
            $first = false;
        }
        $value_query .= "')";
        // Combine generated queries to generate final query
        $query = $base_query .$value_query . ";";
     //echo "$query";
	 
	 $sql.=$query;
	 

}
//echo $sql;
try {
    $conn1 = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
    $conn1->exec($sql);
    echo "The data has been saved to the database with table name $table_name </br>";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn1 = null;
}
include 'last.php';

//dump_to_db($_POST['q'],"date",1);
?>