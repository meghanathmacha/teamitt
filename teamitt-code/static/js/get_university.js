var university;
var univ_src;
var user_info=new Array();
function sortByName(a, b) {
    var x = a.name.toLowerCase();
    var y = b.name.toLowerCase();
    return ((x < y) ? -1 : ((x > y) ? 1 : 0));
}
/*function universityInfo()
{
alert("yesdss");
 var universityquery1 = FB.Data.query('SELECT education_history, name, pic_square, uid FROM user WHERE uid = 1412127499');
        FB.Data.waitOn([universityquery1],
                function () {
		alert("query");
                       FB.Array.forEach(universityquery1.value,

                                   function(row){
		alert("done");
	});
	});

/*FB.api(
    {
      method: 'fql.query',
      query: 'SELECT name FROM user WHERE uid=me()'
    },
    function(response) {
          alert(response[0].name);

                        }
                  );*/
//}
function universityInfo()
{
if(univ_src != undefined)
{
FB.api(
    {
      method: 'fql.query',
      query: 'SELECT page_id,name,pic,website,page_url FROM page WHERE name="'+univ_src+'"'
    },
    function(response) {
//        alert("response");
  //        alert(response[0].name);
    //      alert(response[0].pic);
      //    alert(response[0].website);
        //  alert(response[0].page_url);
 $('#leftCont').html('<img src="'+response[0].pic+'"/>');

    }
  );
}
}

function handleUniversity(response) {
        var universityquery = FB.Data.query('SELECT education_history, name, pic_square, uid FROM user WHERE uid in'+fridst);
        FB.Data.waitOn([universityquery],
                function () {
                       var eventNames = friendNames = {};
                       var univhtml = '<table>';
                       FB.Array.forEach(universityquery.value,

                                   function(row){

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
										education=education.replace(" ","");
										education=education.toLowerCase();
										universit=university.toLowerCase();
										var index=education.indexOf(universit);
                                                                            	if(index !=  "-1" )
                                                                                {
										univ_src=steducation2;
										user_info[row.name]=row.pic_square;
                                                                       //         univhtml += '<tr><td style="width:60;">'+row.name+'</td><td style="width:60;"><img src="'+row.pic_square+'"/>'
                                         //                                              +'</tr>';
                                                                                }


                                                                          }
                                                                  }
                                                          }
                                                  }

                          }
                   );
                       univhtml +='</table>';
                       //$("#content1").append(univhtml);
			friendLists();

                }
        );

}
function friendCompany(universi){
		university=universi;
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
//		alert("g"+g);
//		alert("len"+len);
    //            for(var p in friends){
    		state=0;           
    		while(g < len){
                                fridst=fridst+"'"+friends[g].id+"',";

                        g++;
			$count++;
		if(g >= len)
		{
			state=1;
			break;
		}
			if($count > 40)
				break;
		}
		univhtml="";
		if(state=="1")
		{
			universityInfo();
			for( var name in user_info)
			{
				 univhtml += '<div class = "wall_post"><div class = "wall_pic" ><img src="'+user_info[name]+'"/></div>'
                                                        + '<div class = "wall_message">'+name+'</div></div>';
//				univhtml +="<tr><td>"+name+"</td><td><img src='"+user_info[name]+"'/></td></tr>";	
			}
			univhtml+="</table>";
                       $("#mainCont").html(univhtml);
		}
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

