<?php
class MiscDB extends DB
{
/* Leave comment about this function 

1) What does it do ?
2) When do you call it ?
3) details regarding the parameters and return type

=================Example==================

- Used to get the name of the user for some id
- Calling it to show name on profile bar

@param1:id, corresponds to userid
@return user names on success, otherwise returns 0

*/

public function getName($id)
{
if($this->link)
{
$query="select name from test where id=$id";
$result=mysql_query($query,$this->link);
if(mysql_affected_rows()>0)
{
$row=mysql_fetch_row($result);
return $row[0];
}
return 0;
}
return 0;
}


public function addPartner($email,$fname,$lname,$company,$size, $address, $city, $state, $zip,$phone, $promo)
	{
		if($this->link)
		{
			$query="insert into partners (email_id,first_name,last_name,company,size,address,city,state,zip,phone,promo) values ('$email','$fname','$lname','$company',$size,'$address','$city', '$state','$zip', '$phone','$promo')";
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
