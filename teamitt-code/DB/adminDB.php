<?php
class adminDB extends DB
{

public function addInvites($uid,$cid,  $email, $ikey)
{
if($this->link)
{
$query="insert into invitations (userid, company_id, invited, ikey) values ($uid, $cid, '$email', '$ikey')";
$result=mysql_query($query,$this->link);
if(mysql_affected_rows()>0)
{
return true;
}
return false;
}
return false;
}

public function existInvites($uid, $email)
{
if($this->link)
{
$query="select invitedon from  invitations where userid = $uid and invited='$email'";
$result=mysql_query($query,$this->link);
if(mysql_affected_rows()>0)
{
return true;
}
return false;
}
return false;
}

public function updateInvites($uid, $email)
{
if($this->link)
{
$query="update invitations set invitedon = NOW()  where userid = $uid and invited='$email'";
$result=mysql_query($query,$this->link);
if(mysql_affected_rows()>0)
{
return true;
}
return false;
}
return false;
}




	public function userExist($email)
        {
                if($this->link)
                {
                        $query = "select id from users where email_id='$email'";
                        $result = mysql_query($query , $this -> link);
                        if(mysql_affected_rows()>0)
                        {
                                return true;
                        }

                        return false;
                }
                return false;
        }



}

?>
