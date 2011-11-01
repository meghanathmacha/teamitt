var work;
function sortByName(a, b) {
    var x = a.name.toLowerCase();
    var y = b.name.toLowerCase();
    return ((x < y) ? -1 : ((x > y) ? 1 : 0));
}
function handleCompany(response) {

	var company_query = FB.Data.query('SELECT work, name, pic_square, uid FROM user WHERE uid in'+fridst);
        FB.Data.waitOn([company_query],
                function () {
                       var eventNames = friendNames = {};
                       var univhtml = '<table>';
                       FB.Array.forEach(company_query.value,

                                   function(row){
				   sttest=row.work;
				alert(row.name);
				alert(sttest);
				   temp=null;
				   for (var ist in sttest) {
				   if(ist==0 && temp==null){ 
				   sttest1 = sttest[0];
				   for (var ist1 in sttest1) {
				   if(ist1=='employer'){
				   sttest2= sttest1['employer'];
				   for (var ist2 in sttest2) { 
				   if(ist2=='name'){
				   work=sttest2[ist2];
				   alert(work);
				   alert("Gdgd");
				   fbid=row.uid;
				

                                                /*          steducation=row.education_history;
                                                           var univtemp=null;
                                                          for (var ist in steducation) {
				
                                                                  if(ist==0 && univtemp==null){
                                                                  steducation1 = steducation[0];
                                                                  for (var ist1 in steducation1) {
                                                                         univId = '1';
                                                                  if(ist1=='name'){
                                                                          steducation2= steducation1['name'];
                                                                          education = steducation2;
                                                                                 univfbid=row.uid;*/
                                                                                body = "";
										work=work.replace(" ","");
										work=work.toLowerCase();
										wor=wor.toLowerCase();
										var index=work.indexOf(wor);
                                                                            	if(index !=  "-1" )
                                                                                {
                                                                                univhtml += '<tr><td style="width:60;">'+row.name+'</td><td style="width:60;"><img src="'+row.pic_square+'"/>'
                                                                                     + '</td><td style="width:60;">'+work+'</td>'
                                                                                       +'</tr>';
                                                                                }


                                                                          }
                                                                  }
                                                          }
                                                  }}}

                          }
                   );
                       univhtml +='</table>';
                       $("#content").append(univhtml);
//			friendLists();

                }
        );

}
function friendCompany(wor){
		work = wor;
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
//alert(len);
//		alert("g"+g);
//		alert("len"+len);
    //            for(var p in friends){
    		while(g < len){
	//	if(g > len)
	//		break;
                                fridst=fridst+"'"+friends[g].id+"',";

                        g++;
			$count++;
			if($count > 40)
				break;
		}
                stlen =fridst.length;
                stlen= stlen-1;
                fridst=fridst.substr(0, stlen);
                fridst = fridst+')';
		alert(fridst);
                         handleCompany();
          //      }
               }

