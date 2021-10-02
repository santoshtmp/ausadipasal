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

      $conn = new mysqli($this->host, $this->dbusername, $this->dbpassword);
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }
      $sql = "CREATE DATABASE IF NOT EXISTS ".$this->dbname;
      if ($conn->query($sql) === TRUE) {
        $con=new mysqli($this->host,$this->dbusername,$this->dbpassword,$this->dbname);
        if ($con->connect_error) {
          die("DB Connection failed: " . $con->connect_error);
        }else{ return $con;}
      }else{
        $con=new mysqli($this->host,$this->dbusername,$this->dbpassword,$this->dbname);
        return $con;
      }
      
    }

  }

?>