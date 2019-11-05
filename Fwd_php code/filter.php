<head>
        <title>PHP HTML TABLE DATA SEARCH</title>
        <style>
            table,tr,th,td
            {
                border: 1px solid black;
            }
        </style>
    </head>
<?php
$asin = $_POST['asin'];
    // search in all table columns
    // using concat mysql function
    $query = "SELECT * FROM `scrap_rev_asin` WHERE `asin` LIKE '".$asin."' and url !=''LIMIT 1";
    $con= mysqli_connect("learntest.joomla.com", "qopaqamux", "y5xdSdML", "qopaqamux");
$result1 = $con->query($query);
// please hide the table when this is true, the code needs to be added inside this if loop
if(mysqli_num_rows($result1)==0)
{
	echo "Subscribe for more";
}
?>
   <table>
                <tr>
                 
                    <th>Product Name</th>

					<th>Price</th>
					<th>Actual Price</th>
					<th>Rating</th>
					<th>Review Count</th>

                  
                </tr>
<?php $key=array();?>
      <!-- populate table from mysql database -->
                <?php  while($row1 = mysqli_fetch_array($result1)):?>
                <tr>
                    <td><?php echo $row1['product_name'];?></td>
					
                    <td><?php echo $row1['price'];?></td>
					<td><?php echo $row1['actual_price'];?></td>
					<td><?php echo $row1['rating'];?></td>
                    <td><?php echo $row1['review_count'];?></td>
					
                </tr>
<?php
  endwhile;
 $query2 = "SELECT * FROM `scrap_rev_asin` WHERE `asin` LIKE '".$asin."'";
  
$result2 = $con->query($query2);
 while($row2 = mysqli_fetch_array($result2))
 {
	 $key[]=$row2['key_word'];
 }

//var_dump($key);
//$unique_keys=array();
?>
            </table>
			<?php
			
				$unique_keys=array_unique($key);
			
			//var_dump($unique_keys);
			$array_res = array();
				for($i=0;$i<count($unique_keys);$i++)
				{

// Perform queries
$sql="SELECT * FROM `scrap_rev_asin` WHERE `key_word` LIKE '".$unique_keys[$i]."'" ;
$result = $con->query($sql);



               while($row = mysqli_fetch_array($result)):
				
				$array_res[] = array(
				'keyword'=>$row["key_word"],
				'price'=>$row["price"],
				'actual_price'=>$row["actual_price"],
				'review_count'=>$row["review_count"],
				'position'=>$row["position"],
				'amazon_choice'=>$row["amazon_choice"]

				);

                endwhile;
				}
				//var_dump($array_res);
				$dr=json_encode($array_res);
				$darray=json_decode($dr);
			$array_tt=array();
			$avg_price=array();
			$avg_review=array();
			
				for($k=0;$k<count($unique_keys);$k++)
				{
					$total_price=0;
					$total_review=0;
					$actual_price=0;
					$n=0;
					$sp=0;
					$pp="";
					$acc="";
					$bn=0;
					$dis=0;
					for($l=0;$l<count($darray);$l++)
				{	
					//$k=$darray[$l]->keyword;
					if($darray[$l]->keyword==$unique_keys[$k])
					{	//echo "loop";
						$n++;
						//$pr=number_format(floatval($darray[$l]->price), 2, ',', '');
						$p=$darray[$l]->price;
						if($p!='')
						{
						$b = str_replace(',','',$p);
						$total_price=($total_price+$b);
						}
							$ap=$darray[$l]->actual_price;
						if($p!=''&& $ap!='')
						{
						$b = str_replace(',','',$p);
						$total_price=($total_price+$b);
						$app=str_replace(',','',$ap);
						
						$actual_price=$actual_price+$app;
						$dis=(($actual_price-$total_price)/$actual_price)*100;
						}
						$rc=$darray[$l]->review_count;
						if($rc!='')
						{
							$revc=str_replace(',','',$rc);
							$total_review=($total_review+$revc);
						}
						
						$poss=$darray[$l]->position;
						if($poss=="spon")
						{
							$sp=$sp+1;
						}
						$ac=$darray[$l]->amazon_choice;
						if($ac!="Best seller")
						{
							$acc="yes";
						}
						if($ac=="Best seller")
						{
							$bn=$bn+1;
						}
					}
					
				}
				//echo $n;
				$avg_price[$k]=$total_price/$n;
				$avg_review[$k]=$total_review/$n;
				
				$array_tt[] = array(
				'key'=>$unique_keys[$k],
				'avg_price'=>round($avg_price[$k],2),
				'avg_review'=>round($avg_review[$k],2),
//				'position'=>$pos[$k],
				'sponsered_count'=>$sp,
				'amazon_choice'=>$acc,
				'best_seller'=>$bn,
				'discount'=>round($dis,2)
				);	
				}
				//var_dump($array_tt);
				//var_dump($avg_review);
				//var_dump($avg_price);
				$jtt=json_encode($array_tt);
			//	$ff=var_dump($jtt);
				$arr_table2=json_decode($jtt);
				//var_dump($arr_table2);
				?>
				<table>
                <tr>
                    <th>Keyword</th>
					<th>Average Price</th>
					<th>Average Review</th>
	<!--				<th>position</th>	-->
					<th>Sponsored Count</th>
					<th>Amazon Choice</th>
					<th>Best Seller</th>
					<th>Discount</th>
                </tr>
				
				
				<?php 
			for($g=0;$g<count($arr_table2);$g++)
			{ ?>
			<tr>
			<td><?php echo $arr_table2[$g]->key;?> </td>
			<td><?php echo $arr_table2[$g]->avg_price;?> </td>
			<td><?php echo $arr_table2[$g]->avg_review;?> </td>
			<!--<td> <?php/* echo $arr_table2[$g]->position;*/> </td> -->
			<td><?php echo $arr_table2[$g]->sponsered_count;?> </td>
			<td><?php echo $arr_table2[$g]->amazon_choice;?> </td>
					<td><?php echo $arr_table2[$g]->best_seller;?> </td>
								<td><?php echo $arr_table2[$g]->discount;?> </td>

			
			
			
			
			</tr>
			<?php
			}
			?>
			
			
				
				</table>




             