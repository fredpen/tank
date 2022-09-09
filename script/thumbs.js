var thumbrateurl="http://"+window.location.hostname+"/ajaxrating-news/rateit.php"

var thumbsrate={
thumbs_up: "http://www.cssdrive.com/ajaxrating-news/thumbsup.gif",
thumbs_down: "http://www.cssdrive.com/ajaxrating-news/thumbsdown.gif",
presenttime: new Date(),
thirtydaysinmillisec: 21*24*60*60*1000,

getTally:function(dbresult){
	if (dbresult=="")
		dbresult="0, 0"
 return dbresult.split(/\s*,\s*/)
},

displayscore:function(newsid, dbresult, entrypostdate, aip){
	var enablevoting=this.presenttime.getTime()-new Date(entrypostdate).getTime()<this.thirtydaysinmillisec
	var aip=aip.substr(5)
	var tally=this.getTally(dbresult)
	var tupcolor=(tally[0]==0)? "color: gray" : (parseInt(tally[0])>parseInt(tally[1]))? "color:green;background:#E5E5E5" : "color:green"
	var tdowncolor=(tally[1]==0)? "color: gray" : (parseInt(tally[1])>parseInt(tally[0]))? "color:red;background:#E5E5E5" : "color:red"
	var yays='<span id="tup-'+newsid+'" style="'+tupcolor+'">'+tally[0]+' Yays</span>'
	var nays='<span id="tdown-'+newsid+'" style="'+tdowncolor+'">'+tally[1]+' Nays</span>'
	var thumbup='<img src="../CSS Drive- Categorized CSS gallery and examples_files/'+this.thumbs_up+'" class="finger" title="I like it" rel="'+newsid+'"/>'
	var thumbdown='<img src="../CSS Drive- Categorized CSS gallery and examples_files/'+this.thumbs_down+'" class="finger" title="I don\'t like it" rel="'+newsid+'"/>'
	if (enablevoting || manual_enablevoting){
		document.write('<div id="'+newsid+'-div" class="thumbsdiv">'+thumbup+' '+yays+' '+thumbdown+' '+nays+'</div>')
		var thumbimagesref=document.getElementById(newsid+'-div').getElementsByTagName("img")
		thumbimagesref[0].onclick=function(){thumbsrate.updatescore(this, "up", aip)}
		thumbimagesref[1].onclick=function(){thumbsrate.updatescore(this, "down", aip)}
	}
	else //if simply show tally results, no voting
		document.write('<div title="Voting period has expired" class="thumbsdiv">Your Votes: '+yays+'  '+nays+'</div>')
},

updatescore:function(imgobj, score, aip){
	var newsid=imgobj.getAttribute("rel")
	var ajaxobj=createAjaxObj()
	if (ajaxobj){
		var parameters="id="+newsid+"&rating="+score+"&aip="+aip+"&bustcache="+new Date().getTime()
		ajaxobj.onreadystatechange=function(){thumbsrate.refreshscore(ajaxobj, newsid, score)}
		ajaxobj.open('GET', thumbrateurl+"?"+parameters, true)
		ajaxobj.send(null)
	}
},

refreshscore:function(ajaxinstance, newsid, score){
	var thumbsdiv=document.getElementById(newsid+"-div")
	var thumbspansref=thumbsdiv.getElementsByTagName("span")
	var thumbimagesref=thumbsdiv.getElementsByTagName("img")
	var targetthumbimage=(score=="up")? thumbimagesref[0] : thumbimagesref[1]
	if (typeof fader=="undefined"){
		var fader=new faderoutine(targetthumbimage)
		fader.fadeTo(0.2)
	}
	if (ajaxinstance.readyState == 4){ //if request of file completed
		if (ajaxinstance.status==200){
			var xmldata=ajaxinstance.responseXML
			if (xmldata.getElementsByTagName("thumbsup").length==0){ //if error getting latest avgscore
				alert(ajaxinstance.responseText)
				fader.fadeTo(1)
				return
			} //End status 200 error
			var uptally=xmldata.getElementsByTagName("thumbsup")[0].firstChild.nodeValue
			var downtally=xmldata.getElementsByTagName("thumbsdown")[0].firstChild.nodeValue
			var votedcheck=xmldata.getElementsByTagName("voted")[0].firstChild.nodeValue
			if (votedcheck=="yes" || votedcheck=="isauthor"){
				var errmsg=(votedcheck=="yes")? "Vote not recorded, as you have already voted" : "Vote not recorded, as you cannot vote for your own entry"
				fader.fadeTo(1)
				alert(errmsg)
				thumbimagesref[0].className=thumbimagesref[1].className=""
				thumbimagesref[0].onclick=thumbimagesref[1].onclick=null
			}
			else{ //No error, proceed to show new tally
				thumbspansref[0].innerHTML=uptally+" Yays"
				thumbspansref[1].innerHTML=downtally+" Nays"
				thumbspansref[0].style.color=(uptally==0)? "gray" : "green"
				thumbspansref[1].style.color=(downtally==0)? "gray" : "red"
				thumbspansref[0].style.background=(parseInt(uptally)>parseInt(downtally))? "#E5E5E5" : "transparent"
				thumbspansref[1].style.background=(parseInt(downtally)>parseInt(uptally))? "#E5E5E5" : "transparent"
				fader.gradualFadeUp(0.2)
				thumbimagesref[0].className=thumbimagesref[1].className=""
				thumbimagesref[0].onclick=thumbimagesref[1].onclick=null
			}
		}
	}
}

}