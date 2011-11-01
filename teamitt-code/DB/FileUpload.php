<?php
class FileUpload extends DB
{	
	public function get_uploaded_files($section,$sectionID,$tag)
	{	if ($this->link)
		{	if ($tag=='all')
				$query="SELECT * from files where section='".$section."' and sectionID=".$sectionID." order by fileID"; 
			else 
			{	$query="SELECT * FROM files where section='".$section."' and sectionID=".$sectionID." and related_tags LIKE '%".$tag."%' order by fileID";
			}
			$recordset=mysql_query($query,$this->link); 
                        if (mysql_affected_rows()>0)
			{	$r=mysql_num_rows($recordset); 
				for ($i=0;$i<$r;$i++) 
					$rows[]=mysql_fetch_assoc($recordset); 
				return $rows; 
			}
			return 0;
		}
		return -1;
	}
	
	public function delete_uploaded_file($fileID)
	{	if ($this->link)
                {	$query="DELETE from files where fileID=".$fileID; 
			mysql_query($query,$this->link);
			if (mysql_affected_rows()>0)
				return $fileID; 
			else 
				return 0; 
		}
		return -1; 
	}

        public function find_tag($tag)
        {       if ($this->link)
                { 	$query="SELECT * from tags where tag='".$tag."'";
			$recordset=mysql_query($query,$this->link); 
			if (mysql_affected_rows()>0)
			{	$row=mysql_fetch_assoc($recordset); 
				return $row; 
			}
			return 0; 
		} 
		return -1; 
	} 

	public function insert_new_tag($tag,$category,$userID)
	{
		if ($this->link)
		{	$query="INSERT INTO tags (tag,section,usersID) values('".$tag."','".$category."','".$userID."')"; 
			$recordset=mysql_query($query,$this->link);
			if (mysql_affected_rows()>0)
				return mysql_insert_id(); 
			else 
				return 0; 			
		}
		return -1; 
	}

	public function	insert_file_details($filename, $related_tags, $userID, $category, $belongstoID, $filesize, $filepath, $timestamp)
	{	if ($this->link) 
		{	$query="INSERT INTO files (filename, related_tags, userID, section, sectionID, filesize, filepath, upload_date) values ('".$filename."','".$related_tags."',".$userID.",'".$category."',".$belongstoID.",".$filesize.",'".$filepath."','".$timestamp."')"; 
			$recordset=mysql_query($query,$this->link);	
			if (mysql_affected_rows()>0)
				return mysql_insert_id(); 
			else 
				return 0; 
		}
		return -1; 
	}

	public function update_new_tag($tagID,$section,$usersID)
	{	if ($this->link) 
		{	$query="UPDATE tags SET section='".$section."',usersID='".$usersID."' where tagId=".$tagID; 
			$recordset=mysql_query($query,$this->link); 
			if (mysql_affected_rows()>0) 
				return $tagID; 
			else
				return 0; 
		}
		return -1; 
	}

	public function get_suggestions_for_tag($word)
	{	if ($this->link)
                {	$query="SELECT tag from tags WHERE tag LIKE '".$word."%'"; 
			$recordset=mysql_query($query,$this->link);
                        if (mysql_affected_rows()>0)
			{	
				$r=mysql_num_rows($recordset);
                                for ($i=0;$i<$r;$i++)
                                        $rows[]=mysql_fetch_assoc($recordset);
                                return $rows;
			}
			return 0; 
		}
		return -1;
	}
} 
