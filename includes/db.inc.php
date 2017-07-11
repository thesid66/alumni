<?php
class Database {
 
    private $host;
    private $user;
    private $pass;
    private $database_name;
    private $link;
    private $error;
    private $errno;
    private $query;
 
    function __construct($host, $user, $pass, $database_name = "") {
        $this -> host = $host;
        $this -> user = $user;
        $this -> pass = $pass;
        if (!empty($database_name)) $this -> name = $database_name;      
        $this -> connect();
    }
 
    function __destruct() {
        @mysqli_close($this->link);
    }
 
    public function connect() {
        if ($this -> link = mysqli_connect($this -> host, $this -> user, $this -> pass)) {
            if (!empty($this -> name)) {
                if (!mysqli_select_db($this -> link, $this -> name)) $this -> exception("Could not connect to the database!");
            }
        } else {
            $this -> exception("Could not create database connection!");
        }
    }
 
    public function close() {
        @mysqli_close($this->link);
    }
 
    public function query($sql) {
		$this->query = @mysqli_query($this->link,"SET NAMES utf8;");		//change this when your database is UTF-8;
        if ($this->query = @mysqli_query($this->link,$sql)) {
            return $this->query;
        } else {
            $this->exception("Could not query database!");
            return false;
        }
    }

    public function multi_query($sql) {
		$this->query = @mysqli_query($this->link,"SET NAMES utf8;");		//change this when your database is UTF-8;
        if ($this->query = @mysqli_multi_query($this->link,$sql)) {
            return $this->query;
        } else {
            $this->exception("Could not query database!");
            return false;
        }
    }

    public function begin() {
//        if ($this->query = @mysqli_query($this->link,"BEGIN;"))		// BEGIN Transaction
		if ($this->query = @mysqli_autocommit($this->link,FALSE))
		{
					return $this->query;
		}
		else
		{
				$this->exception("Could not query BEGIN!");
				return false;
			}
    }

    public function commit() {
//        if ($this->query = @mysqli_query($this->link,"COMMIT;"))			// Permanent Change into the database after BEGIN Transaction
//			if ($this->query = @mysqli_commit($this->link))
if ($this->query = @mysqli_commit($this->link))

		{
            return $this->query;
						@mysqli_autocommit($this->link,TRUE);
        } else
		{
            $this->exception("Could not query COMMIT!");
            return false;
        } 
    }

    public function rollback() {
//        if ($this->query = @mysqli_query($this->link,"ROLLBACK;")) 		// Rollback Transaction
//			if ($this->query = @mysqli_rollback($this->link))
if ($this->query = @mysqli_rollback($this->link))
		{
            return $this->query;
						@mysqli_autocommit($this->link,TRUE);
        } else
		{
            $this->exception("Could not query COMMIT!");
            return false;
        }
    }

    public function affected_rows() {
        if ($this->query = @mysqli_affected_rows($this->link)) 		// Affected Rows
		{
            return $this->query;
        } else
		{
            $this->exception("Could not get Affected Rows!");
            return false;
        }
    }

    public function num_rows($qid) {
        if (empty($qid)) {         
            $this->exception("Could not get number of rows because no query id was supplied!");
            return false;
        } else {
            return mysqli_num_rows($qid);
        }
    }

    public function fetch_array($qid) {
        if (empty($qid)) {
            $this->exception("Could not fetch array because no query id was supplied!");
            return false;
        } else {
            $data = mysqli_fetch_array($qid);
        }
        return $data;
    }

    public function fetch_fields($qid) {
        if (empty($qid)) {
            $this->exception("Could not fetch array because no query id was supplied!");
            return false;
        } else {
            $data = mysqli_fetch_fields($qid);
        }
        return $data;
    }

 
    public function fetch_array_assoc($qid) {
        if (empty($qid)) {
            $this->exception("Could not fetch array assoc because no query id was supplied!");
            return false;
        } else {
            $data = mysqli_fetch_array($qid, MYSQL_ASSOC);
        }
        return $data;
    }

    public function fetch_object($qid) {
       if (empty($qid)) {
            $this->exception("Could not fetch object because no query id was supplied!");
            return false;
        } else {
            $data = mysqli_fetch_object($qid);
        }
        return $data;
    }
	public function real_escape_string($string) {
		// todo: make sure your connection is active etc.
            $data = mysqli_real_escape_string($this -> link, $string);
        return $data;
	  }

    public function free($qid) {
       if (empty($qid)) {
            $this->exception("Could not free the result because no query id was supplied!");
            return false;
        } else {
            $data = mysqli_free_result($qid);
        }
        return $data;
    }


    public function fetch_all_array($sql, $assoc = true) {
        $data = array();
        if ($qid = $this->query($sql)) {
            if ($assoc) {
                while ($row = $this->fetch_array_assoc($qid)) {
                    $data[] = $row;
                }
            } else {
                while ($row = $this->fetch_array($qid)) {
                    $data[] = $row;
                }
            }
        } else {
            return false;
        }
        return $data;
    }
 
    public function last_id() {
        if ($id = mysqli_insert_id()) {
            return $id;
        } else {
            return false;
        }
    }
 
    private function exception($message) {
        if ($this->link) {
            $this->error = mysqli_error($this->link);
            $this->errno = mysqli_errno($this->link);
        } else {
            $this->error = mysqli_error();
            $this->errno = mysqli_errno();
        }


        if (PHP_SAPI !== 'cli') {
        ?>
 <style>
 
	 .alert-bad
	 {
		 font-weight:bold;
		 color:red;
		 font-size:90%;
	 }

 </style>
            <div class="panel panel-danger">
                <div class="panel-heading">
                    Database Error
                </div>
                <div class="panel-body">
                <div>
                    Message: <?php echo $message; ?>
                </div>
                <?php if (strlen($this->error) > 0): ?>
                    <div>
                        <?php echo $this->error; ?>
                    </div>
                <?php endif; ?>
                <div>
                    Script: <?php echo @$_SERVER['REQUEST_URI']; ?>
                </div>
                <?php if (strlen(@$_SERVER['HTTP_REFERER']) > 0): ?>
                    <div>
                        Referrer: <?php echo @$_SERVER['HTTP_REFERER']; ?>
                    </div>
                <?php endif; ?>
                </div>
            </div>
        <?php
        } else {
                    echo "MYSQL ERROR: " . ((isset($this->error) && !empty($this->error)) ? $this->error:'') . "\n";
        };
    }
 
}


function maxid($table,$pk,$db){
	$getmax = "select max($pk) as $pk from $table";
	$getmaxRes = $db->query($getmax);
	$setMax = $db->fetch_object($getmaxRes);
	if($setMax->$pk=="")
	{
		$pk = 1;
	}
	else
	{
		$pk = $setMax->$pk+1;
	}
	return $pk;
}
function district($data,$db) {
	$getDst = $db->query("select * from tbldistrict where DistrictCode = '$data'");
	$setDst = $db->fetch_object($getDst);
	$data = $setDst->District;
	
	return $data;
}
function Commodity($type,$data,$db) {
	if($type=="cereal") {$table = "tblcerealcom"; $field ="CommdityName"; $sField = "ComID";}
	else if($type=="cash") {$table = "tblcashcom"; $field ="CommdityName"; $sField = "ComID";}
	else if($type=="pulse") {$table = "tblpulsecom"; $field ="CommdityName"; $sField = "ComID";}
	else if($type=="livestock") {$table = "tbllivestockcate"; $field ="Category"; $sField = "CateID";}
	else if($type=="horti") {$table = "tblhorticom"; $field ="CommodityName"; $sField = "ComID";}
	
	$getCom = $db->query("select $field from $table where $sField = '$data'");
	$setCom = $db->fetch_object($getCom);
	$data = $setCom->$field;
	
	return $data;
}
function region($data){
	if($data==1)
	{
		$data="Eastern Development Region";
	}
	else if($data==2)
	{
		$data="Central Development Region";
	}
	else if($data==3)
	{
		$data="Western Development Region";
	}
	else if($data==4)
	{
		$data="Mid-Western Development Region";
	}
	else if($data==5)
	{
		$data="Far-Western Development Region";
	}
	
	return $data;
}
function region_short($data){
	if($data==1)
	{
		$data="E. Region";
	}
	else if($data==2)
	{
		$data="C. Region";
	}
	else if($data==3)
	{
		$data="W. Region";
	}
	else if($data==4)
	{
		$data="MW. Region";
	}
	else if($data==5)
	{
		$data="FW. Region";
	}
	
	return $data;
}

function geo($data){
	if($data==1)
	{
		$data="Mountains";
	}
	else if($data==2)
	{
		$data="Hills";
	}
	else if($data==3)
	{
		$data="Terai";
	}

	return $data;
}

function ProductType($data){
	if($data==1)
	{
		$data="Meat";
	}
	else if($data==2)
	{
		$data="Milk";
	}
	else if($data==3)
	{
		$data="Egg";
	}
	else if($data==4)
	{
		$data="Wool";
	}

	return $data;
}

function FruitsType($data){
	if($data==1)
	{
		$data=" - Citrus";
	}
	else if($data==2)
	{
		$data=" - Winter (Decidious)";
	}
	else if($data==3)
	{
		$data=" - Summer (Tropical)";
	}
	else
	{
		$data="";
	}

	return $data;
}

function FrVg($data){
	if($data==1)
	{
		$data="Fruits";
	}
	else if($data==2)
	{
		$data="Vegetable";
	}
	else
	{
		$data="";
	}

	return $data;
}
function check($data){
	if($data==0)
	{
		return "-";
	}
	else
	{
		return $data;
	}
}
?>