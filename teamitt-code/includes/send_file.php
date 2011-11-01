<html>

<head>

<?php 
# TEMP variables : to be removed when the module is integrated in the code
$user="enfp"; 
$connection="intj";
echo $user . "\n"; 
echo $connection . "\n"; 

# The dictionary storing the file names. This array should go in a 'common' module storing all the data variables. 
$relationship_files=array(
				"EI"=>"file1.txt",
				"IE"=>"file2.txt",
				"SN"=>"file3.txt",
				"NS"=>"file4.txt",
				"FT"=>"file5.txt",
				"TF"=>"file6.txt",
				"JP"=>"file7.txt",
				"PJ"=>"file8.txt"
			  );

# Function call
send_MBTI_relationship_file(strtoupper($user), strtoupper($connection) , $relationship_files); 

# This function accepts the MBTI types of a USER and its CONNECTION 
# and returns the relavant file names 
# which represent the pre-defined relationships between the two MBTI types 
function send_MBTI_relationship_file($user, $connection, $relationship_files)
{	# variable for the list of files to be returned
	$file_list="";	
	
	# if the MBTI type is more than 4 characters then the function returns no files
	if (strlen($user)==4)
	{	if (strlen($connection)==4) 
		{ 	
			$user=chunk_split($user,1,"");
			$connection=chunk_split($connection,1,"");
			
			# checking for relationship files after comparing the USER and CONNECTION's MBTI types
			for ($i=0; $i<4; $i++) 
			{	$arr_key=$user[$i] . $connection[$i]; 
				if (array_key_exists($arr_key,$relationship_files))  
				{	# adding the file names found to the file_list variable	
					$file_list= $file_list . $relationship_files[$arr_key] . "|" ;

				} 
			} 						 
					echo $file_list;					  
		} 
		else
		{	echo "Incorrect MBTI value of CONNECTION"; 
			return $file_list; 
		}        
	} 
	else 
	{	echo "Incorrect MBTI value of USER.\n";
		return $file_list;  
	} 
	return $file_list; 
}	
?>



</head>

<body><br><br>MBTI relationship files</body> 


</html> 

