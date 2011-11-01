<?php
class searchDB extends DB
{
        public function doQuery($name, $cid)
        {
                if($this->link)
                {
			$query="select id,CONCAT(first_name,' ', last_name), image_src from users where company_id = $cid and (CONCAT(first_name, ' ', last_name) like '$name%' or first_name like '$name%' or last_name like '$name%') limit 0,10";

                        $result = mysql_query($query , $this -> link);
                        if(mysql_affected_rows()>0)
                        {
				return $result;
                        }

                        return 0;
                }
                return 0;
        }






}

?>
