<?php

function actionUserhtml($company_name,$DB)
{
	$result = $DB -> getAction($company_name);

	if($result)
	{
		$action_user_html = "<table><tr>";
		while(($row = mysql_fetch_array($result)) != null)
		{
			$user_fbid =  $row['user_fbid'];
			$action_user_html .=  "<td><img style='cursor:pointer;' class=".$user_fbid." src='http://graph.facebook.com/".$user_fbid."/picture'></img></td>";
		}
		$action_user_html .= "</tr></table>";
		return $action_user_html;
	}
	return $result;

}


?>
