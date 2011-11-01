var univ=new Array();
/*alert(univ.length);
if(univ["iiit"]==undefined)
{
univ["iiit"]=new Array();
univ["iiit"][0]="nik";
alert(univ["iiit"][0]);
len=univ["iiit"].length;
alert(len);
}
else 
{
alert("not gone");
}*/
function sortByName(a, b) {
    var x = a.name.toLowerCase();
    var y = b.name.toLowerCase();
    return ((x < y) ? -1 : ((x > y) ? 1 : 0));
}
function handleUniversity(response) {
	alert(fridst);
	alert("handle");
        var universityquery = FB.Data.query('SELECT education_history, contact_email,email,name, pic_square, uid FROM user WHERE uid in'+fridst);
        FB.Data.waitOn([universityquery],
                function () {
                       var eventNames = friendNames = {};
                       var univhtml = '<table>';
                       FB.Array.forEach(universityquery.value,

                                   function(row){
//alert(row.contact_email);
//alert(row.email);
alert(row.uid);
alert(row.name);

                                                          steducation=row.education_history;
                                                           var univtemp=null;
                                                          for (var ist in steducation) {
				
                                                                  if(ist==0 && univtemp==null){
                                                                  steducation1 = steducation[0];
                                                                  for (var ist1 in steducation1) {
                                                                         univId = '1';
                                                                  if(ist1=='name'){
                                                                          steducation2= steducation1['name'];
                                                                          education = steducation2;
                                                                                 univfbid=row.uid;
                                                                                body = "";
									//	education=education.replace(" ","");
									//	education=education.toLowerCase();
										if(univ[education]==undefined)
										{
											univ[education]=new Array();
											
										}
										len=univ[education].length;
										univ[education][len]=row.name;


                                                                          }
                                                                  }
                                                          }
                                                  }

                          }
                   );
			friendLists();

                }
        );

}
function friendCompany(){
//		university=universi;
                FB.api("/me/friends?fields=name,picture,id", handleFriends);
            }
	var friends;
	var len;
	var g=0;
            function handleFriends(response) {
                       friends = response.data.sort(sortByName);
		 len=friends.length;
		end=len/100;
		friendLists();
		}
		function friendLists()
		{
//		alert(friends);
               // fridst='(';
		//$count=0;
	//	for(i=0;i<95;i++)
	//	{
	//	if(g > len)
	//		break;
                fridst='(';
		$count=0;
		 len=friends.length;
		state=0;
//		alert("g"+g);
//		alert("len"+len);
    //            for(var p in friends){
    		while(g < len){
		if(g >= len)
		{
			state=1;
			break;
		}
                                fridst=fridst+"'"+friends[g].id+"',";

                        g++;
			$count++;
			if($count > 40)
				break;
		}
		if( g == len)
		{
										 univhtml1="<table>";
										count=0;
										for( var universit in univ)
										{
									//	if(count == "40")
									//		break;
										count++;
									//	university_nospace=universit.replace(/^\s+|\s+$/g, '');
										university_nospace=universit.replace(/\s/g,"-");
										university_nospace=university_nospace.replace("&","");
											univhtml1+="<tr><td>"+university_nospace+"</td>";
											//alert("university"+universit);
											len=univ[universit].length;
											counting=0;
											univhtml1+="<td>"+len+"</td>";
										//	for( i=0;i<len;i++)
										//	{
										//	univhtml1+="<td>"+univ[universit][i]+"</td>";
//											if(counting=="8")
//										{
//											univhtml1+="</tr><tr><td></td>";		}
//											counting++;
												//alert("name"+univ[universit][i]);
										//	}
											univhtml1+="</tr>";		
										}
											univhtml1+="</table>";		
                       $("#content").append(univhtml1);
		$("#link_wall_post").show();
		$("#link_email").show();
//		univhtml1="<table><tr><td>vtrtgrtg</td><td>fre</td></tr><tr><td>frefre</td><td>frerf</td></tr></table>";
		$.post("make_pdf.php?html="+univhtml1);
		}
	//	if(state==0)
		else
		{
                stlen =fridst.length;
                stlen= stlen-1;
                fridst=fridst.substr(0, stlen);
                fridst = fridst+')';
                         handleUniversity();
		}
          //      }
               }

