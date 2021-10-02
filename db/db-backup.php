        <?php

        class database{
          private $host;
          private $dbusername;
          private $dbpassword;
          private $dbname;

          protected function connect(){
            $this->host='localhost';
            $this->dbusername='root';
            $this->dbpassword='';
            $this->dbname='ausadipasal';
            $con=new mysqli($this->host,$this->dbusername,$this->dbpassword,$this->dbname);
            return $con;
          }
        }

        class query extends database{
          public function getUserInfo($uname){
            $sql="SELECT username,email,last_login,count_login FROM user where username='$uname' ";
            $result=$this->connect()->query($sql);
            if ($result->num_rows>0) {
              $arr=array();
              while($row=$result->fetch_assoc()){
                $arr[]=$row;
              }
              return $arr;
            }else{
              return 0;
            }
          }

          public function checkLogin($uname,$pass){
            $sql="SELECT * FROM user where username='$uname' ";
            $result=$this->connect()->query($sql);
            if ($result->num_rows>0) {
              while($row=$result->fetch_assoc()){
                $verify = password_verify($pass,$row['password']);
                if ($verify) {
                  date_default_timezone_set("Asia/Kathmandu");
                  $now_time=date("Y-m-d H:i:s");
                  if ($row['count_login']) {
                    $count_log=$row['count_login']+1; 
                    $sql_first=" UPDATE user set count_login='$count_log',last_login='$now_time' WHERE username='$uname' ";
                    $result_sql_first=$this->connect()->query($sql_first);
                  }else{
                    $count_log='1';
                    $sql_first=" UPDATE user set count_login='$count_log',last_login='$now_time' WHERE username='$uname' ";
                    $result_sql_first=$this->connect()->query($sql_first);
                  }
                  return $verify;
                }else{return 0;}
              }
              
            }else{
              return 0;
            }
          }

          public function getData($table){
            $sql="SELECT * FROM $table ORDER BY id DESC";
            $result=$this->connect()->query($sql);
            if ($result->num_rows>0) {
              $arr=array();
              while($row=$result->fetch_assoc()){
                $arr[]=$row;
              }
              return $arr;
            }else{
              return 0;
            }
          }


          public function insertData($table,$condition_arr){
            if($condition_arr!=''){
              foreach($condition_arr as $key=>$val){
                $fieldArr[]=$key;
                $valueArr[]=$val;
              }
              $field=implode(",",$fieldArr);
              $value=implode("','",$valueArr);
              $value="'".$value."'";      
              $sql="insert into $table($field) values($value) ";
              $result=$this->connect()->query($sql);
              return $result;
            }
          }


          public function deleteData($table,$condition_arr){
            if($condition_arr!=''){
              $sql="delete from $table where ";
              $c=count($condition_arr); 
              $i=1;
              foreach($condition_arr as $key=>$val){
                if($i==$c){
                  $sql.="$key='$val'";
                }else{
                  $sql.="$key='$val' and ";
                }
                $i++;
              }
              $result=$this->connect()->query($sql);
              return $result;
            }
          }

          public function deletePhData($id){
            $sql="SELECT inv.qyt AS inv_qyt, inv.qyt_purch AS inv_qyt_purch,inv.id AS inv_id, ph.qyt AS ph_qyt, ph.qyt_purch AS ph_qyt_purch  
                  FROM purchase AS ph 
                  JOIN inventory AS inv ON inv.id=ph.inv_id
                  WHERE ph.id='$id' ";
            $result=$this->connect()->query($sql);
            if ($result->num_rows>0) {
              while($row=$result->fetch_assoc()){
               $inv_id=$row['inv_id'];
               $inv_qyt=$row['inv_qyt'];
               $inv_qyt_purch=$row['inv_qyt_purch'];
               $ph_qyt=$row['ph_qyt'];
               $ph_qyt_purch=$row['ph_qyt_purch']; 
              }
            }
            if ($inv_qyt AND $inv_qyt_purch AND $ph_qyt AND $ph_qyt_purch AND $inv_id) {
              $updIn_qyt=$inv_qyt-$ph_qyt;
              $updIn_qyt_purch=$inv_qyt_purch-$ph_qyt_purch;
              $condition_arr=array(
                "qyt"=>$updIn_qyt,
                "qyt_purch"=>$updIn_qyt_purch
              );
              $upd_inv_result=$this->updateData('inventory',$condition_arr,'id',$inv_id);
              if ($upd_inv_result) {
                $arr=array( 'id'=>$id );
                $del_res=$this->deleteData('purchase',$arr);
                if ($del_res) {
                  $sql="SELECT * FROM purchase WHERE inv_id='$inv_id' ";
                  $result=$this->connect()->query($sql);
                  if ($result->num_rows==0) {
                    $arr=array( 'id'=>$inv_id );
                    $del_res=$this->deleteData('inventory',$arr);
                    if ($del_res) {
                      return 1;
                    }
                  }else{
                    return 1;
                  }
                }
              }
            }
          }
          //  close deletePhData function


          public function updateData($table,$condition_arr,$where_field,$where_value){
            if($condition_arr!=''){
              $sql="update $table set ";
              $c=count($condition_arr); 
              $i=1;
              foreach($condition_arr as $key=>$val){
                if($i==$c){
                  $sql.="$key='$val'";
                }else{
                  $sql.="$key='$val', ";
                }
                $i++;
              }
              $sql.=" where $where_field='$where_value' ";
              $result=$this->connect()->query($sql);
              return $result;
            }
          }


          public function getSalesCardData(){
            $sql="SELECT * FROM sales WHERE card='1' ORDER BY id DESC";
            $result=$this->connect()->query($sql);
            if ($result->num_rows>0) {
              $arr=array();
              while($row=$result->fetch_assoc()){
                $arr[]=$row;
              }
              return $arr;
            }else{
              return 0;
            }
          }

          public function salesDoneAddTocard_processed_sale($all_sales_item_id){
            $arr_id = explode(",",$all_sales_item_id);
            $result=0;
            foreach($arr_id as $key => $value){
              $sql="UPDATE sales SET card='0' WHERE id='$value'";
              $result_update=$this->connect()->query($sql);
              if ($result_update) {
                $result=$result+1;
              }
            }
            if ($result==sizeof($arr_id)) {
              return $result;
            }else{
              return 0;
            }
          }
      public function getStockList(){
        $sql="SELECT * FROM inventory ";
        $result=$this->connect()->query($sql);
        $arr_qyt=$arr_net_qyt=array();
        $arr_itemName=$arr_itemName_uniq=array();
        if ($result->num_rows>0) {
          while($row=$result->fetch_assoc()){
            $arr_qyt[$row['id']]=$row['qyt'];
            $arr_itemName[$row['id']]=$row['item_name'];
          }
          $arr_itemName_uniq=array_unique($arr_itemName);
          foreach ($arr_itemName_uniq as $key => $val) {
            $itemNameDupKeyId=array();
            $id=0;
            if(array_search($val,$arr_itemName)){
              foreach ($arr_itemName as $key_id => $value) {
                if ($val==$value) {
                  $itemNameDupKeyId[]=$key_id;
                  $id=$key_id;
                }
              }
            }
            $item_new_qyt=0;
            foreach ($itemNameDupKeyId as $key => $value) {
              $item_new_qyt=$arr_qyt[$value]+ $item_new_qyt;
            }
            $arr_net_qyt[$id]= $item_new_qyt;
          } 
             // print_r($arr_net_qyt);
          $return_value=array();
          foreach ($arr_net_qyt as $key => $value) {
            $sql_q="SELECT id,code,item_name FROM inventory WHERE id='$key'  ORDER BY id DESC ";
            $result_sql_q=$this->connect()->query($sql_q);
            if ($result_sql_q->num_rows>0) {
              while($row=$result_sql_q->fetch_assoc()){
                if($arr_net_qyt[$row['id']]<30){
                  $row['qyt']=$arr_net_qyt[$row['id']];
                  $return_value[]=$row;
                }
              }
            }
          }
          return $return_value;
        }else{
          return 0;
        }
      }

      public function getOutStockList(){
        $sql="SELECT * FROM inventory WHERE qyt='0' ORDER BY id DESC";
        $result=$this->connect()->query($sql);
        if ($result->num_rows>0) {
          $arr=array();
          while($row=$result->fetch_assoc()){
            $arr[]=$row;
          }
          return $arr;
        }else{
          return 0;
        }
      }

      public function getExpiredList(){
        $today=date("Y-m-d");
        $sql="SELECT * FROM inventory WHERE expire_date<'$today' ORDER BY id DESC";
        $result=$this->connect()->query($sql);
        if ($result->num_rows>0) {
          $arr=array();
          while($row=$result->fetch_assoc()){
            $arr[]=$row;
          }
          return $arr;
        }else{
          return 0;
        }
      }
        // close getExpiredList function

      public function insertEditInvPurchData($arr){
        $arr_inv=$arr_purch=array();
        $editID=0;
        foreach($arr as $key=>$val){
          switch ($key) {
            case 'code':
            $arr_inv[$key]=$val;
            $code=$val;
            break;
            case 'item_name':
            $arr_inv[$key]=$val;
            $item_name=$val;
            break;
            case 'batch_no':
            $arr_inv[$key]=$val;
            $batch_no=$val;
            break;
            case 'expire_date':
            $arr_inv[$key]=$val;
            $expire_date=$val;
            break;
            case 'mrp':
            $arr_inv[$key]=$val;
            $mrp=$val;
            break;
            case 'qyt':
            $arr_inv[$key]=$val;
            $arr_purch[$key]=$val;
            $arr_inv['qyt_purch']=$val;
            $arr_purch['qyt_purch']=$val;
            break;
            case 'bill_no':
            $arr_purch[$key]=$val;
            break;
            case 'date':
            $arr_purch[$key]=$val;
            break;
            case 'id':
            $editID=$val;
            break;
          }
        }
        if($editID){
          $result_return_inv_upd=$result_return_purch_upd=0;
          $sql="SELECT inv_id FROM purchase WHERE id='$editID' ";
          $result=$this->connect()->query($sql);
          if ($result->num_rows>0) {
            while($row=$result->fetch_assoc()){
              $inv_id=$row['inv_id'];
            }
          }
          if ($inv_id) {
            $sql_inv_purch="SELECT inv.item_name AS item_name, inv.code AS code, inv.batch_no AS batch_no, inv.expire_date AS expire_date, inv.mrp AS mrp, inv.qyt AS inv_qyt,inv.qyt_purch AS inv_qyt_purch, ph.date as date, ph.bill_no as bill_no, ph.qyt AS ph_qyt, ph.qyt_purch AS ph_qyt_purch
            FROM purchase AS ph 
            JOIN inventory AS inv ON inv.id=ph.inv_id 
            WHERE ph.inv_id='$inv_id' AND ph.id='$editID' ";
            $result=$this->connect()->query($sql_inv_purch); 
            if ($result->num_rows>0){
              while($row=$result->fetch_assoc()){
                $inv_purch = $row;
              }
            }
            $inv_purch_change=array();
            if ($inv_purch['item_name']!=$arr['item_name']){
              $inv_purch_change['item_name']=$arr['item_name'];
              $inv_purch_change['code']=$arr['code'];
            }
            if ($inv_purch['batch_no']!=$arr['batch_no']) {
              $inv_purch_change['batch_no']=$arr['batch_no'];
              $inv_purch_change['expire_date']=$arr['expire_date'];
              $inv_purch_change['mrp']=$arr['mrp'];
            }
            if ($inv_purch['date']!=$arr['date']) {
              $inv_purch_change['date']=$arr['date'];
            }
            if ($inv_purch['bill_no']!=$arr['bill_no']) {
              $inv_purch_change['bill_no']=$arr['bill_no'];
            }
            if ($inv_purch['ph_qyt']!=$arr['qyt']) {
              $inv_purch_change['qyt']=$arr['qyt'];
            }
            $change_key=array();
            foreach ($inv_purch_change as $key => $value) {
              $change_key[$key]=$key;
            }
            if (in_array("item_name", $change_key) || in_array("batch_no", $change_key) || in_array("expire_date", $change_key) || in_array("mrp", $change_key) || in_array("qyt", $change_key) ){
              $update_inv=$update_ph=array();
              foreach($arr as $key=>$val){
                switch ($key) {
                  case 'qyt':
                  if (in_array("qyt", $change_key)) {
                    $update_inv['qyt']=($inv_purch['inv_qyt']-$inv_purch['ph_qyt'])+$inv_purch_change['qyt'];
                    $update_inv['qyt_purch']=($inv_purch['inv_qyt_purch']-$inv_purch['ph_qyt_purch'])+$inv_purch_change['qyt'];
                    $update_ph['qyt']=$inv_purch_change['qyt'];
                    $update_ph['qyt_purch']=$inv_purch_change['qyt'];
                  }
                  break;
                  case 'mrp':
                  if (in_array("mrp", $change_key)) {
                    $update_inv['mrp']=$inv_purch_change['mrp'];
                  }
                  break;
                  case 'expire_date':
                  if (in_array("expire_date", $change_key)) {
                    $update_inv['expire_date']=$inv_purch_change['expire_date'];
                  }
                  break;
                  case 'batch_no':
                  if (in_array("batch_no", $change_key)) {
                    $update_inv['batch_no']=$inv_purch_change['batch_no'];
                  }
                  break;
                  case 'item_name':
                  if (in_array("item_name", $change_key)) {
                    $update_inv['item_name']=$inv_purch_change['item_name'];
                    $update_inv['code']=$inv_purch_change['code'];
                  }
                  break;
                  case 'bill_no':
                  if (in_array("bill_no", $change_key)) {
                    $update_ph['bill_no']=$inv_purch_change['bill_no'];
                  }
                  break;
                  case 'date':
                  if (in_array("date", $change_key)) {
                    $update_ph['date']=$inv_purch_change['date'];
                  }
                  break;
                }
              }
              if ( in_array("qyt", $change_key)  AND (!in_array("item_name", $change_key) && !in_array("batch_no", $change_key) && !in_array("expire_date", $change_key) && !in_array("mrp", $change_key) ) ) { 
                $result_purch_upd=$this->updateData('purchase', $update_ph,'id',$editID);
                if ($result_purch_upd) {
                  $result_return_purch_upd=$result_return_purch_upd+1;
                  $result_inv_upd=$this->updateData('inventory',$update_inv,'id',$inv_id);
                  if ($result_inv_upd) {
                    $result_return_inv_upd=$result_return_inv_upd+1;
                  }
                }
              }
              else{
                if (in_array("item_name", $change_key) AND in_array("batch_no", $change_key) ){
                  if (!in_array("expire_date", $change_key)) {
                    $update_inv['expire_date']=$inv_purch['expire_date'];
                  }
                  if (!in_array("mrp", $change_key)) {
                    $update_inv['mrp']=$inv_purch['mrp'];
                  }
                  if (!in_array("qyt", $change_key)) {
                    $update_inv['qyt']=$inv_purch['ph_qyt'];
                    $update_inv['qyt_purch']=$inv_purch['ph_qyt_purch'];
                  }else{
                    $update_inv['qyt']=$inv_purch_change['qyt'];
                    $update_inv['qyt_purch']=$inv_purch_change['qyt'];
                  }
                  $sql_inv_CHK="SELECT * FROM inventory WHERE item_name='$item_name' AND batch_no='$batch_no' ";
                  $result_sql_inv_CHK=$this->connect()->query($sql_inv_CHK);
                  $new_inv_arr=array();
                  if ($result_sql_inv_CHK->num_rows>0) {
                    while($row=$result_sql_inv_CHK->fetch_assoc()){
                      $new_inv_arr=$row;
                    }

                        // $inv_old=array(); 
                        // $inv_old['qyt']=$inv_purch['inv_qyt']-$inv_purch['ph_qyt'];
                        // $inv_old['qyt_purch']=$inv_purch['inv_qyt_purch']-$inv_purch['ph_qyt_purch'];
                        // $result_inv_id_upd=$this->updateData('inventory', $inv_old,'id',$inv_id);

                    $deleteID=array('id'=>$inv_id);
                    $result_inv_id_del=$this->deleteData('inventory',$deleteID);

                    $inv_new_id=$new_inv_arr['id'];
                    $update_inv['qyt']=$new_inv_arr['qyt']+$update_inv['qyt'];
                    $update_inv['qyt_purch']=$new_inv_arr['qyt_purch']+$update_inv['qyt_purch'];
                    $result_inv_upd=$this->updateData('inventory', $update_inv,'id',$inv_new_id);
                    if ($result_inv_upd) {
                      $result_return_inv_upd=$result_return_inv_upd+1;
                      $update_ph['inv_id']=$inv_new_id;
                      $result_purch_upd=$this->updateData('purchase', $update_ph,'id',$editID);
                      if ($result_purch_upd) {
                        $result_return_purch_upd=$result_return_purch_upd+1;
                      }
                    }
                  }else{
                        // $inv_old=array(); 
                        // $inv_old['qyt']=$inv_purch['inv_qyt']-$inv_purch['ph_qyt'];
                        // $inv_old['qyt_purch']=$inv_purch['inv_qyt_purch']-$inv_purch['ph_qyt_purch'];
                        // $result_inv_id_upd=$this->updateData('inventory', $inv_old,'id',$inv_id);

                    $deleteID=array('id'=>$inv_id);
                    $result_inv_id_del=$this->deleteData('inventory',$deleteID);

                    $result_inv_in_up=$this->insertData('inventory',$update_inv);
                    if ($result_inv_in_up) {
                      $result_return_inv_upd=$result_return_inv_upd+1;
                      $sql_new_inv_id="SELECT id FROM inventory WHERE item_name='$item_name' AND batch_no='$batch_no' ";
                      $result_sql_new_inv_id=$this->connect()->query($sql_new_inv_id);
                      $id_new_inv=0;
                      if ($result_sql_new_inv_id->num_rows>0) {
                        while($row=$result_sql_new_inv_id->fetch_assoc()){
                          $id_new_inv=$row['id'];
                        }
                      }
                      if ($id_new_inv) {
                        $update_ph['inv_id']=$id_new_inv;
                        $result_purch_upd=$this->updateData('purchase', $update_ph,'id',$editID);
                        if ($result_purch_upd) {
                          $result_return_purch_upd=$result_return_purch_upd+1;
                        }
                      }
                    }
                  }
                }else{
                  if (in_array("batch_no", $change_key) ) {
                    $item_name=$update_inv['item_name']=$inv_purch['item_name'];
                    $update_inv['code']=$inv_purch['code'];
                    if (!in_array("expire_date", $change_key)) {
                      $update_inv['expire_date']=$inv_purch['expire_date'];
                    }
                    if (!in_array("mrp", $change_key)) {
                      $update_inv['mrp']=$inv_purch['mrp'];
                    }
                    if (!in_array("qyt", $change_key)) {
                      $update_inv['qyt']=$inv_purch['ph_qyt'];
                      $update_inv['qyt_purch']=$inv_purch['ph_qyt_purch'];
                    }else{
                      $update_inv['qyt']=$inv_purch_change['qyt'];
                      $update_inv['qyt_purch']=$inv_purch_change['qyt'];
                    }
                    $sql_inv_CHK="SELECT * FROM inventory WHERE item_name='$item_name' AND batch_no='$batch_no' ";
                    $result_sql_inv_CHK=$this->connect()->query($sql_inv_CHK);
                    $new_inv_arr=array();
                    if ($result_sql_inv_CHK->num_rows>0) {
                      while($row=$result_sql_inv_CHK->fetch_assoc()){
                        $new_inv_arr=$row;
                      }
                          // $inv_old=array(); 
                          // $inv_old['qyt']=$inv_purch['inv_qyt']-$inv_purch['ph_qyt'];
                          // $inv_old['qyt_purch']=$inv_purch['inv_qyt_purch']-$inv_purch['ph_qyt_purch'];
                          // $result_inv_id_upd=$this->updateData('inventory', $inv_old,'id',$inv_id);

                      $deleteID=array('id'=>$inv_id);
                      $result_inv_id_del=$this->deleteData('inventory',$deleteID);

                      $inv_new_id=$new_inv_arr['id'];
                      $update_inv['qyt']=$new_inv_arr['qyt']+$update_inv['qyt'];
                      $update_inv['qyt_purch']=$new_inv_arr['qyt_purch']+$update_inv['qyt_purch'];
                      $result_inv_upd=$this->updateData('inventory', $update_inv,'id',$inv_new_id);
                      if ($result_inv_upd) {
                        $result_return_inv_upd=$result_return_inv_upd+1;
                        $update_ph['inv_id']=$inv_new_id;
                        $result_purch_upd=$this->updateData('purchase', $update_ph,'id',$editID);
                        if ($result_purch_upd) {
                          $result_return_purch_upd=$result_return_purch_upd+1;
                        }
                      }
                    }else{
                          // $inv_old=array(); 
                          // $inv_old['qyt']=$inv_purch['inv_qyt']-$inv_purch['ph_qyt'];
                          // $inv_old['qyt_purch']=$inv_purch['inv_qyt_purch']-$inv_purch['ph_qyt_purch'];
                          // $result_inv_id_upd=$this->updateData('inventory', $inv_old,'id',$inv_id);

                      $deleteID=array('id'=>$inv_id);
                      $result_inv_id_del=$this->deleteData('inventory',$deleteID);

                      $result_inv_in_up=$this->insertData('inventory',$update_inv);
                      if ($result_inv_in_up) {
                        $result_return_inv_upd=$result_return_inv_upd+1;
                        $sql_new_inv_id="SELECT id FROM inventory WHERE item_name='$item_name' AND batch_no='$batch_no' ";
                        $result_sql_new_inv_id=$this->connect()->query($sql_new_inv_id);
                        $id_new_inv=0;
                        if ($result_sql_new_inv_id->num_rows>0) {
                          while($row=$result_sql_new_inv_id->fetch_assoc()){
                            $id_new_inv=$row['id'];
                          }
                        }
                        if ($id_new_inv) {
                          $update_ph['inv_id']=$id_new_inv;
                          $result_purch_upd=$this->updateData('purchase', $update_ph,'id',$editID);
                          if ($result_purch_upd) {
                            $result_return_purch_upd=$result_return_purch_upd+1;
                          }
                        }
                      }
                    }
                  }
                  elseif (in_array("item_name", $change_key) ) {
                    $batch_no=$update_inv['batch_no']=$inv_purch['batch_no'];
                    $update_inv['expire_date']=$inv_purch['expire_date'];
                    $update_inv['mrp']=$inv_purch['mrp'];
                    if (!in_array("qyt", $change_key)) {
                      $update_inv['qyt']=$inv_purch['ph_qyt'];
                      $update_inv['qyt_purch']=$inv_purch['ph_qyt_purch'];
                    }else{
                      $update_inv['qyt']=$inv_purch_change['qyt'];
                      $update_inv['qyt_purch']=$inv_purch_change['qyt'];
                    }
                    $sql_inv_nameBatch="SELECT * FROM inventory WHERE item_name='$item_name' AND batch_no='$batch_no' ";
                    $result_sql_inv_nameBatch=$this->connect()->query($sql_inv_nameBatch);
                    if ($result_sql_inv_nameBatch->num_rows>0) {
                      while($row=$result_sql_inv_nameBatch->fetch_assoc()){
                        $inv_nameBatch=$row;
                      }
                          // $inv_old=array(); 
                          // $inv_old['qyt']=$inv_purch['inv_qyt']-$inv_purch['ph_qyt'];
                          // $inv_old['qyt_purch']=$inv_purch['inv_qyt_purch']-$inv_purch['ph_qyt_purch'];
                          // $result_inv_id_upd=$this->updateData('inventory', $inv_old,'id',$inv_id);

                      $deleteID=array('id'=>$inv_id);
                      $result_inv_id_del=$this->deleteData('inventory',$deleteID);

                      $inv_new_id=$inv_nameBatch['id'];
                      $update_inv['qyt']=$inv_nameBatch['qyt']+$update_inv['qyt'];
                      $update_inv['qyt_purch']=$inv_nameBatch['qyt_purch']+$update_inv['qyt_purch'];
                      $result_inv_upd=$this->updateData('inventory', $update_inv,'id',$inv_new_id);
                      if ($result_inv_upd) {
                        $result_return_inv_upd=$result_return_inv_upd+1;
                        $update_ph['inv_id']=$inv_new_id;
                        $result_purch_upd=$this->updateData('purchase', $update_ph,'id',$editID);
                        if ($result_purch_upd) {
                          $result_return_purch_upd=$result_return_purch_upd+1;
                        }
                      }

                    }else{
                          // $inv_old=array(); 
                          // $inv_old['qyt']=$inv_purch['inv_qyt']-$inv_purch['ph_qyt'];
                          // $inv_old['qyt_purch']=$inv_purch['inv_qyt_purch']-$inv_purch['ph_qyt_purch'];
                          // $result_inv_id_upd=$this->updateData('inventory', $inv_old,'id',$inv_id);

                      $deleteID=array('id'=>$inv_id);
                      $result_inv_id_del=$this->deleteData('inventory',$deleteID);

                      $result_inv_in_up=$this->insertData('inventory',$update_inv);
                      if ($result_inv_in_up) {
                        $result_return_inv_upd=$result_return_inv_upd+1;
                        $sql_new_inv_id="SELECT id FROM inventory WHERE item_name='$item_name' AND batch_no='$batch_no' ";
                        $result_sql_new_inv_id=$this->connect()->query($sql_new_inv_id);
                        $id_new_inv=0;
                        if ($result_sql_new_inv_id->num_rows>0) {
                          while($row=$result_sql_new_inv_id->fetch_assoc()){
                            $id_new_inv=$row['id'];
                          }
                        }
                        if ($id_new_inv) {
                          $update_ph['inv_id']=$id_new_inv;
                          $result_purch_upd=$this->updateData('purchase', $update_ph,'id',$editID);
                          if ($result_purch_upd) {
                            $result_return_purch_upd=$result_return_purch_upd+1;
                          }
                        }
                      }
                    }
                  }
                }
              }
            }
            else{
              $result_purch_upd=$this->updateData('purchase',$inv_purch_change,'id',$editID);
              if ($result_purch_upd) {
                $result_return_purch_upd=$result_return_purch_upd+1;
                $result_return_inv_upd=$result_return_inv_upd+1;
              }
            }
          }
          if ($result_return_inv_upd==1 AND $result_return_purch_upd==1) {
            return "update_inv_ph";
          }else{
            return 0;
          }
        }else{
            // for purch insert-new_entry
          $result_return=$result_return_purch=0;
          $sql_inv=" SELECT * FROM inventory where code='$code' AND item_name='$item_name' AND batch_no='$batch_no' AND expire_date='$expire_date' AND mrp='$mrp' ";
          $result=$this->connect()->query($sql_inv);
          $arr_sql_inv=0;
          if ($result->num_rows>0) {
            while($row=$result->fetch_assoc()){
              $arr_sql_inv=$row;
            }
            $id=$arr_sql_inv['id'];
            $qyt_upd=$arr_sql_inv['qyt']+$arr_inv['qyt'];
            $qyt_purch_upd=$arr_sql_inv['qyt_purch']+$arr_inv['qyt_purch'];
            $sql_inv_upd="UPDATE inventory SET qyt='$qyt_upd',qyt_purch='$qyt_purch_upd' WHERE id='$id' ";
            $result_sql_inv_upd=$this->connect()->query($sql_inv_upd);
            if ($result_sql_inv_upd) {
              $result_return=$result_return+1;
              $arr_purch['inv_id']=$id;
              $result_purch=$this->insertData('purchase',$arr_purch);
              if ($result_purch) {
                $result_return_purch=$result_return_purch+1;
              }
            }
          }else{
            $result_ins=$this->insertData('inventory',$arr_inv);
            if ($result_ins) {
              $result_return=$result_return+1;
              $sql_inv=" SELECT id FROM inventory where code='$code' AND item_name='$item_name' AND batch_no='$batch_no' AND expire_date='$expire_date' AND mrp='$mrp' ";
              $result=$this->connect()->query($sql_inv);
              if ($result->num_rows>0) {
                while($row=$result->fetch_assoc()){
                  $arr_purch['inv_id']=$row['id'];
                }
                $result_ins_purch=$this->insertData('purchase',$arr_purch);
                if ($result_ins_purch) {
                  $result_return_purch=$result_return_purch+1;
                }
              }
            }
          }
          if (($result_return==1) AND ($result_return_purch==1)) {
            return 'result_return_inv_purch_1';
          }elseif (($result_return==1) AND ($result_return_purch==0)) {
            return 'result_return_inv_1';
          }elseif (($result_return==0) AND ($result_return_purch==1)) {
            return 'result_return_purch_1';
          }elseif (($result_return==0) AND ($result_return_purch==0)) {
            return 'result_return_inv_purch_0';
          }
        }
      }
        // close insertEditInvPurchData function

      public function getPurchData(){
        $sql_invPh="SELECT inv.item_name AS item_name, inv.code AS code, inv.batch_no AS batch_no, inv.expire_date AS expire_date, inv.mrp AS mrp, ph.date as 'date', ph.bill_no as bill_no, ph.qyt AS qyt, ph.qyt_purch AS qyt_purch, ph.id AS id 
        FROM purchase AS ph 
        JOIN inventory AS inv ON inv.id=ph.inv_id 
        ORDER BY id DESC";
        $result=$this->connect()->query($sql_invPh);
        if ($result->num_rows>0) {
          $arr=array();
          while($row=$result->fetch_assoc()){
            $arr[] = $row;
          }
          return $arr;
        }else{
          return 0;
        }

      }
      // close getPurchData function

    }
        //close query class 


    class SalesItem extends database{

      public function getCardQyt($id){
        $sql="SELECT qyt FROM  sales WHERE ph_id='$id' AND card='1' " ;
        $result=$this->connect()->query($sql);
        if ($result->num_rows>0) {
          $arr=array();
          while($row=$result->fetch_assoc()){
            $arr[] = $row['qyt'];
          }
          return $arr;
        }else{
          return 0;
        }
      }

      public function getInvCodeNo($itemName){
        $sql="SELECT DISTINCT code FROM  inventory WHERE item_name='$itemName' " ;
        $result=$this->connect()->query($sql);
        if ($result->num_rows>0) {
          while($row=$result->fetch_assoc()){
            return $row['code'];
          }
        }else{
          return 0;
        }
      }

      public function getExpMrp($itemNameBatchNum){
        $NameBatch=explode('-',$itemNameBatchNum);
        $itemName=$NameBatch[0];
        $batch_no=$NameBatch[1];
        $sql="SELECT expire_date, mrp FROM  inventory WHERE item_name='$itemName' AND batch_no='$batch_no' " ;
        $result=$this->connect()->query($sql);
        if ($result->num_rows>0) {
          while($row=$result->fetch_assoc()){
            $return=$row;
          }
          return $return;
        }else{
          return 0;
        }
      }

      public function getInvItemData($item){
        $sql="SELECT inv.item_name AS item_name, inv.code AS code, inv.batch_no AS batch_no, inv.expire_date AS expire_date, inv.mrp AS mrp, ph.qyt AS qyt,ph.date AS 'date',ph.bill_no AS bill_no, ph.id AS id, inv.id AS inv_id
        FROM purchase AS ph 
        JOIN inventory AS inv ON inv.id=ph.inv_id 
        WHERE inv.item_name='$item' AND ph.qyt>0
        ORDER BY id DESC";
        // $sql="SELECT * FROM inventory WHERE item_name='$item' ";
        $result=$this->connect()->query($sql);
        if ($result->num_rows>0) {
          $arr=array();
          while($row=$result->fetch_assoc()){
            $arr[]=$row;
          }
          return $arr;
        }else{
          return 0;
        }
      }

      public function getInvItemName(){
        $sql="SELECT DISTINCT item_name FROM inventory";
        $result=$this->connect()->query($sql);
        if ($result->num_rows>0) {
          $arr=array();
          while($row=$result->fetch_assoc()){
            $arr[]=$row['item_name'];
          }
          return $arr;
        }else{
          return 0;
        }
      }

      public function getInvItemNameBatchNumLis(){
        $sql="SELECT DISTINCT batch_no FROM inventory";
        $result=$this->connect()->query($sql);
        if ($result->num_rows>0) {
          $arr=array();
          while($row=$result->fetch_assoc()){
            $arr[]=$row['batch_no'];
          }
          return $arr;
        }else{
          return 0;
        }
      }

      public function getSalesDataCard0($id){
        $sql="SELECT * FROM sales WHERE id='$id' AND card='0' ";
        $result=$this->connect()->query($sql);
        if ($result->num_rows>0) {
          $arr=array();
          while($row=$result->fetch_assoc()){
            $arr=$row;
          }
          return $arr;
        }else{
          return 0;
        }
      }

    }
        // close SalesItem class

    class CardProcessInvUpd extends database{
      public function getSalesData($idstr){
        $arr_id = explode(",",$idstr);
        $arr=array();
        foreach($arr_id as $key => $value){
          $sql="SELECT inv_id,qyt,ph_id FROM sales WHERE id='$value' ";
          $result=$this->connect()->query($sql);
          if ($result->num_rows>0) {
            while($row=$result->fetch_assoc()){
              $arr[$value]=$row;
            }
          }else{
            $arr[$value]='';
          }
        }
        return $arr;
      }
          // close getSalesData function 

      public function updateInvPhQWhenCardProc($all_sales_item_id){
        $eaach_sales_data_arr=$this->getSalesData($all_sales_item_id);
        $result=0;
        foreach($eaach_sales_data_arr as $key => $eaach_sales_data){
          $id_inv=$eaach_sales_data['inv_id'];
          $qyt_inv_value=0;
          $sql_inv_qyt="SELECT qyt FROM inventory WHERE id='$id_inv' ";
          $result_sql_inv_qyt=$this->connect()->query($sql_inv_qyt);
          if ($result_sql_inv_qyt->num_rows>0) {
            while($row=$result_sql_inv_qyt->fetch_assoc()){
              $qyt_inv_value=$row['qyt'];
            }
          }
          $id_ph=$eaach_sales_data['ph_id'];
          $qyt_ph_value=0;
          $sql_ph_qyt="SELECT qyt FROM purchase WHERE id='$id_ph' ";
          $result_sql_ph_qyt=$this->connect()->query($sql_ph_qyt);
          if ($result_sql_ph_qyt->num_rows>0) {
            while($row=$result_sql_ph_qyt->fetch_assoc()){
              $qyt_ph_value=$row['qyt'];
            }
          }
          $result_inv_qyt=$qyt_inv_value-$eaach_sales_data['qyt'];
          $sql="UPDATE inventory SET qyt='$result_inv_qyt' WHERE id='$id_inv' ";
          $result_update=$this->connect()->query($sql);
          if ($result_update) {
            $result_ph_qyt=$qyt_ph_value-$eaach_sales_data['qyt'];
            $sql="UPDATE purchase SET qyt='$result_ph_qyt' WHERE id='$id_ph' ";
            $result_update_ph=$this->connect()->query($sql);
            if ($result_update_ph) {
              $result=$result+1;
            }
          }
        }
        if ($result==sizeof($eaach_sales_data_arr)) {
          return $result;
        }else{
          return 0;
        }
      }
          // close function updateInvPhQWhenCardProc function

      public function cancelSalesProcess($all_sales_item_id){
        $arr_id = explode(",",$all_sales_item_id);
        $result=0;
        foreach($arr_id as $key => $value){
              // $sql_delete="DELETE FROM sales WHERE id='$value'";
          $sql="UPDATE sales SET card='2' WHERE id='$value'";
          $result_sql=$this->connect()->query($sql);
          if ($result_sql) {
            $result=$result+1;
          }
        }
        if ($result==sizeof($arr_id)) {
          return $result;
        }else{
          return 0;
        }
      }
          // close function cancelSalesProcess

      public function editSalesProcess($all_sales_item_id,$all_sales_qyt,$all_total_p){
        $all_sales_item_id = explode(",",$all_sales_item_id);
        $all_sales_qyt = explode(",",$all_sales_qyt);
        $all_total_p = explode(",",$all_total_p);
        $result=0;
        foreach($all_sales_item_id as $key => $value){
          $sql="UPDATE sales SET qyt='$all_sales_qyt[$key]',total_mrp='$all_total_p[$key]' WHERE id='$value'";
          $result_sql=$this->connect()->query($sql);
          if ($result_sql) {
            $result=$result+1;
          }
        }
        if ($result==sizeof($all_sales_item_id)) {
          return $result;
        }else{
          return 0;
        }
      }
          // close function editSalesProcess

      public function getQytSale($id){
        $sql="SELECT ph_id FROM sales WHERE id='$id' ";
        $result=$this->connect()->query($sql);
        $ph_id=0;
        if ($result->num_rows>0) {
          while($row=$result->fetch_assoc()){
            $ph_id=$row['ph_id'];
          }
        }
        $qyt_ph=0;
        if($ph_id){
          $sql_inv_id="SELECT qyt FROM purchase WHERE id='$ph_id' ";
          $result_inv=$this->connect()->query($sql_inv_id);
          if ($result_inv->num_rows>0) {
            while($row_inv=$result_inv->fetch_assoc()){
              $qyt_ph = $row_inv['qyt'];
              // return $row_inv['qyt'];
            }
          }
        }
        $Totalqyt_card_phid=0;
        $sql="SELECT qyt FROM sales WHERE ph_id='$ph_id' AND card='1' ";
        $result=$this->connect()->query($sql);
        if ($result->num_rows>0) {
          while($row=$result->fetch_assoc()){
            $Totalqyt_card_phid=$Totalqyt_card_phid+$row['qyt'];
          }
        }
        if ($qyt_ph AND $Totalqyt_card_phid) {
          return ($qyt_ph-$Totalqyt_card_phid);
        }
      }
           // close function getQytSale
    } 
        //close CardProcessInvUpd class


    ?>
