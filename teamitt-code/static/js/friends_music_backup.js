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
        var universityquery = FB.Data.query('SELECT education_history, music,contact_email,email,name, pic_square, uid FROM user WHERE uid in'+fridst);
        FB.Data.waitOn([universityquery],
                function () {
                       var eventNames = friendNames = {};
                       var musichtml = '<table>';
                       FB.Array.forEach(universityquery.value,

                                   function(row){
//alert(row.contact_email);
//alert(row.email);
						  stmusic=String(row.music);
	    					           var music = stmusic.split(",");                   
                                                          var musicCount = music.length;
										musichtml+='<tr>';
				    							    musichtml  += '<td style="width:180;">'+row.name+'</td>';
				    							    musichtml  += '<td style="width:180;"><img src="'+row.pic_square+'"/></td>';
						                                for(i = 0 ; i < musicCount ; i++)
                                                                                {
					//						alert(music[i]);
											$.post("get_lyrics.php?artist=Akon",function(data){
										
	alert("onlye data"+data);
	alert("data"+data['lyrics']+"musicmusic"+music[i]+"name"+row.name);
	},'json');
				    							    musichtml  += '<td style="width:180;">'+music[i]+'</td>';
										}
										musichtml+='</tr>';
					}
				);
	$('#content').append(musichtml);
	friendLists();
		}
	);
          //             $("#content").append(univhtml1);
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
		state=1;
		if(g >= len)
		{
//			state=1;
			break;
		}
                                fridst=fridst+"'"+friends[g].id+"',";

                        g++;
			$count++;
			if($count > 40)
				break;
		}
		if(state=="1")
		{
                stlen =fridst.length;
                stlen= stlen-1;
                fridst=fridst.substr(0, stlen);
                fridst = fridst+')';
                         handleUniversity();
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
											for( i=0;i<len;i++)
											{
											univhtml1+="<td>"+univ[universit][i]+"</td>";
//											if(counting=="8")
//										{
//											univhtml1+="</tr><tr><td></td>";		}
//											counting++;
												//alert("name"+univ[universit][i]);
											}
											univhtml1+="</tr>";		
										}
											univhtml1+="</table>";		
          //             $("#content").append(univhtml1);
		$("#link_wall_post").show();
		$("#link_email").show();
//		univhtml1="<table><tr><td>vtrtgrtg</td><td>fre</td></tr><tr><td>frefre</td><td>frerf</td></tr></table>";
		$.post("make_pdf.php?html="+univhtml1);
		}
	//	if(state==0)
          //      }
               }

