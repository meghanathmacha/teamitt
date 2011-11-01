<?php
class paypalDB extends DB
{
	public function addTransaction($email,$password)
	{
		if($this->link)
		{

			$query="insert into paypal (email,password) values ( '". mysql_escape_string($email) ."', '".md5($password)."' )";
			$result=mysql_query($query,$this->link);
			if(mysql_affected_rows()>0)
			{
				return 1;
			}
			return 0;
		}
		return 0;
	}
}

?>

