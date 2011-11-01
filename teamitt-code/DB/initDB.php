<?php
class DB
{
protected $link=null;
public $status=1;
public function  __construct()
{
$this->link=mysql_connect("localhost","goalcat_admin","praytogod");
$res=mysql_select_db("teamitt",$this->link);
if(!$this->link || !$res)
{
$this->status=null;
die("Mysql Connection Eror ".mysql_error());
}

}

public function __destruct()
{
//mysql_close($this->link);
}

}

?>
