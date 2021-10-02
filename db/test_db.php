<?php

 public function invUpdateForNewData(){
           $sql="SELECT * FROM inventory";
           $result=$this->connect()->query($sql);
           if ($result->num_rows>0) {
            $arr_inv_all=array();
            while($row=$result->fetch_assoc()){
              $arr_inv_all[]=$row;
            }
            $result_ins_count=0;
            foreach ($arr_inv_all as $key => $arr_inv_single) {
              if ($key==0) {
                $arr=array(
                  "code"=>$arr_inv_single['code'],
                  "item_name"=>$arr_inv_single['item_name'],
                  "batch_no"=>$arr_inv_single['batch_no'],
                  "expire_date"=>$arr_inv_single['expire_date'],
                  "mrp"=>$arr_inv_single['mrp'],
                  "qyt"=>$arr_inv_single['qyt'],
                  "qyt_purch"=>$arr_inv_single['qyt_purch']
                );
                $result_ins=$this->insertData('inventory_new',$arr);
                if ($result_ins) {
                  $item_name=$arr_inv_single['item_name'];
                  $batch_no=$arr_inv_single['batch_no'];
                  $sql_inv="SELECT id FROM inventory_new WHERE item_name='$item_name' AND batch_no ='$batch_no' ";
                  $result=$this->connect()->query($sql_inv);
                  if ($result->num_rows>0) {
                    while($row=$result->fetch_assoc()){
                      $inv_id=$row['id'];
                    }
                    $arr_ph=array();
                    $arr_ph['inv_id'] = $inv_id;
                    $arr_ph['date'] = $arr_inv_single['date'];
                    $arr_ph['qyt_purch'] = $arr_inv_single['qyt_purch']; 
                    $arr_ph['qyt'] = $arr_inv_single['qyt']; 
                    $arr_ph['bill_no'] = $arr_inv_single['bill_no'];
                    $result_ins_ph=$this->insertData('purchase',$arr_ph);
                    if ($result_ins_ph) {
                      $result_ins_count=$result_ins_count+1;
                    }
                  }
                }
              }else{
                $itemNam=$arr_inv_single['item_name'];
        // $batch_no=$arr_inv_single['batch_no'];
                $sql_inv_new="SELECT * FROM inventory_new WHERE item_name='$itemNam' ";
                $result=$this->connect()->query($sql_inv_new);
                if ($result->num_rows>0) {
                  $arr_inv_new=0;
                  while($row=$result->fetch_assoc()){
                    $arr_inv_new=$row;
                  }
                  if ( ($arr_inv_single['item_name']==$arr_inv_new['item_name']) AND  
                    ($arr_inv_single['batch_no']==$arr_inv_new['batch_no'])  ) {
                    $newQYT=$arr_inv_new['qyt']+$arr_inv_single['qyt'];
                  $newQYT_purch=$arr_inv_new['qyt_purch']+$arr_inv_single['qyt_purch'];
                  $condition_arr=array(
                    'qyt'=>$newQYT,
                    'qyt_purch'=>$newQYT_purch
                  );
                  $id=$arr_inv_new['id'];
                  $result_up=$this->updateData('inventory_new',$condition_arr,'id',$id);
                  if ($result_up) {
                    $arr_ph=array();
                    $arr_ph['inv_id'] = $id;
                    $arr_ph['date'] = $arr_inv_single['date'];
                    $arr_ph['qyt_purch'] = $arr_inv_single['qyt_purch']; 
                    $arr_ph['qyt'] = $arr_inv_single['qyt']; 
                    $arr_ph['bill_no'] = $arr_inv_single['bill_no'];
                    $result_ins_ph=$this->insertData('purchase',$arr_ph);
                    if ($result_ins_ph) {
                      $result_ins_count=$result_ins_count+1;
                    }
                  }

                }else{
                  $arr=array(
                    "code"=>$arr_inv_single['code'],
                    "item_name"=>$arr_inv_single['item_name'],
                    "batch_no"=>$arr_inv_single['batch_no'],
                    "expire_date"=>$arr_inv_single['expire_date'],
                    "mrp"=>$arr_inv_single['mrp'],
                    "qyt"=>$arr_inv_single['qyt'],
                    "qyt_purch"=>$arr_inv_single['qyt_purch']
                  );
                  $result_ins=$this->insertData('inventory_new',$arr);
                  if ($result_ins) {
                    $item_name=$arr_inv_single['item_name'];
                    $batch_no=$arr_inv_single['batch_no'];
                    $sql_inv="SELECT id FROM inventory_new WHERE item_name='$item_name' AND batch_no ='$batch_no' ";
                    $result=$this->connect()->query($sql_inv);
                    if ($result->num_rows>0) {
                      while($row=$result->fetch_assoc()){
                        $inv_id=$row['id'];
                      }
                      $arr_ph=array();
                      $arr_ph['inv_id'] = $inv_id;
                      $arr_ph['date'] = $arr_inv_single['date'];
                      $arr_ph['qyt_purch'] = $arr_inv_single['qyt_purch']; 
                      $arr_ph['qyt'] = $arr_inv_single['qyt']; 
                      $arr_ph['bill_no'] = $arr_inv_single['bill_no'];
                      $result_ins_ph=$this->insertData('purchase',$arr_ph);
                      if ($result_ins_ph) {
                        $result_ins_count=$result_ins_count+1;
                      }
                    }
                  }
                }

                
              }else{
                $arr=array(
                  "code"=>$arr_inv_single['code'],
                  "item_name"=>$arr_inv_single['item_name'],
                  "batch_no"=>$arr_inv_single['batch_no'],
                  "expire_date"=>$arr_inv_single['expire_date'],
                  "mrp"=>$arr_inv_single['mrp'],
                  "qyt"=>$arr_inv_single['qyt'],
                  "qyt_purch"=>$arr_inv_single['qyt_purch']
                );
                $result_ins=$this->insertData('inventory_new',$arr);
                if ($result_ins) {
                  $item_name=$arr_inv_single['item_name'];
                  $batch_no=$arr_inv_single['batch_no'];
                  $sql_inv="SELECT id FROM inventory_new WHERE item_name='$item_name' AND batch_no ='$batch_no' ";
                  $result=$this->connect()->query($sql_inv);
                  if ($result->num_rows>0) {
                    while($row=$result->fetch_assoc()){
                      $inv_id=$row['id'];
                    }
                    $arr_ph=array();
                    $arr_ph['inv_id'] = $inv_id;
                    $arr_ph['date'] = $arr_inv_single['date'];
                    $arr_ph['qyt_purch'] = $arr_inv_single['qyt_purch']; 
                    $arr_ph['qyt'] = $arr_inv_single['qyt']; 
                    $arr_ph['bill_no'] = $arr_inv_single['bill_no'];
                    $result_ins_ph=$this->insertData('purchase',$arr_ph);
                    if ($result_ins_ph) {
                      $result_ins_count=$result_ins_count+1;
                    }
                  }
                }
              }
            }
          }
          if ($result_ins_count==sizeof($arr_inv_all)) {
            return 1;
          }
        }
      }
// ------------=====================================================================-------------------------------------

public function changeSalesId(){
	$sql="SELECT * FROM sales";
	$result=$this->connect()->query($sql);
	if ($result->num_rows>0) {
		$arr_sales_inv_id=$arr_sales_id=array();
		while($row=$result->fetch_assoc()){
			$arr_sales_inv_id[]=$row['inv_id'];
			$arr_sales_id[]=$row['id'];
		}
		$inv_NameBatch=array();
		foreach ($arr_sales_inv_id as $key => $inv_id) {
			$sql_inv="SELECT item_name,batch_no FROM inventory WHERE id='$inv_id' ";
			$result=$this->connect()->query($sql_inv);
			if ($result->num_rows>0) {
				while($row=$result->fetch_assoc()){
					$inv_NameBatch[]=$row;
				}
			}
		}
		$inv_new_id=array();
		foreach ($inv_NameBatch as $key => $NameBatch) {
			$item_name=$NameBatch['item_name'];
			$batch_no=$NameBatch['batch_no'];
			$sql_inv_new="SELECT id FROM inventory_new WHERE item_name='$item_name' AND batch_no='$batch_no' ";
			$result=$this->connect()->query($sql_inv_new);
			if ($result->num_rows>0) {
				while($row=$result->fetch_assoc()){
					$inv_new_id[]=$row['id'];
				}
			}
		}
		$result=0;
		foreach ($inv_new_id as $key => $value) {
			$sales_id=$arr_sales_id[$key];
			$sql_up="UPDATE sales SET inv_id='$value' WHERE id='$sales_id' ";
			$result_up_sal=$this->connect()->query($sql_up);
			if ($result_up_sal) {
				$result=$result+1;
			}
		}
		if ($result==sizeof($inv_new_id)) {
			return 1;
		}
	}
}

// ====================================================================================

?>
