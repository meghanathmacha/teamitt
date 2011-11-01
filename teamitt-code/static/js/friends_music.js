var univ=new Array();
var music_data=new Array();
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
function try1(song)
{
var url;
var lyrics;
url=music_data[song]['url'];
lyrics=music_data[song]['lyrics'];

        var domain = "company";
        var friend_fbid = "none";
        var desc = ' uses goalcat to help friends and get help from friends and win rewards';
	var  company_logo =  'http://www.goalcat.com/catlogo32.png';
	var message=lyrics;
        var actions = {name:"win free gifts", link:"http://goalcat.com"};
	var body;
	var user_fbid='';
	body="Has Gifted you the lyrics of \""+song+"\" Song";
        FB.api('/1456223666/feed', 'post', { name:body, link:actions.link,  actions:actions, message:lyrics,
                        picture:company_logo,
                        caption:actions.link,
                        description: desc}, function(response) {
//FB.api('/me/feed', 'post', params, function(response) {
  if (!response || response.error) {
    alert('Error occured');
  } else {
    alert('Published to Friends Wall');
  }
});

}
function handleMusic1()
{
//count=0;
        var universityquery = FB.Data.query('SELECT education_history, music,contact_email,email,name, pic_square, uid FROM user WHERE uid =1456223666');
        FB.Data.waitOn([universityquery],
                function () {
                       FB.Array.forEach(universityquery.value,
                                   function(row){
					 stmusic=String(row.music);
                                                           var music = stmusic.split(",");
                                                          var musicCount = music.length;
							var wallhtml='';
							var lyrics='';
                                        for(i=0 ; i < musicCount;i++)
                                        {
//music_nospace=music[i].replace(" ","");
music_nospace=jQuery.trim(music[i]);
music_nospace=music_nospace.replace(/\s/g,"_");
   $.post("get_lyrics.php?artist="+music_nospace+"&turn="+i,function(data){

//        alert("data"+data['lyrics']+"musi
//        cmusic"+music[i]+"name"+row.name);
	lyrics=data['lyrics'];
	turn=data['turn'];
	music_data[data['song']]=new Array();
	music_data[data['song']]['url']=data['url'];
	music_data[data['song']]['lyrics']=data['lyrics'];

 wallhtml += '<div class = "wall_post"><div class = "wall_pic" ><b>'+music[turn]+'</b></div>'
                                                        + '<div class = "wall_message"><b>'+data['song']+'</b>&nbsp &nbsp<input type="button" title="Gift The Song" value="Gift the Song To Wallpost" onClick=try1("'+data['song']+'")><br/><br/>'+lyrics+'<br/><span style="font-size:10px;cursor:pointer;color:blue;"><b>'+data['url']+'</b></span></div></div>';

//                                         wallhtml += '<div class = "wall_post"><div class = "wall_pic" >'+music[turn]+'</div>'
  //                                                      + '<div class = "wall_message">'+lyrics+'</div></div>';
                                 $('#mainCont').html(wallhtml);
        },'json');


                                        }

							$('#leftCont').html('<img src="'+row.pic_square+'"/>');
				//	if(count=="1")
				//	break;
				   });
				}
		);
}
function handleMusic() {
	alert("query");
        var universityquery = FB.Data.query('SELECT education_history, music,contact_email,email,name, pic_square, uid FROM user WHERE uid in'+fridst);
        FB.Data.waitOn([universityquery],
                function () {
                       var eventNames = friendNames = {};
                       var musichtml = '<table>';
			count=0;
                       FB.Array.forEach(universityquery.value,

                                   function(row){
//alert(row.contact_email);
//alert(row.email);
						  stmusic=String(row.music);
	    					           var music = stmusic.split(",");                   
                                                          var musicCount = music.length;
								if(count=="1")
							{
									break;
							}
							count=1;
							$('#leftCont').html('<img src="'+row.pic_square+'"/>');
							alert("done");
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
//	$('#content').append(musichtml);
//	friendLists();
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
			if($count > 0)
				break;
		}
		if(state=="1")
		{
                stlen =fridst.length;
                stlen= stlen-1;
                fridst=fridst.substr(0, stlen);
                fridst = fridst+')';
                         handleMusic1();
	//		tr();
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

