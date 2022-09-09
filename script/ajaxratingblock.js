var ratingdenominator=10
var ratingscripturl="http://"+window.location.hostname+"/ajaxrating/rateit.php"


function formatscore(num, d){ //remove any leading 0s and format number to be of specified denominator
var d=(typeof d=="undefined" || d<=0)? 100 : d
var formatted=parseInt(num.toString().replace(/^0+/, "")) //remove any leading 00s and trailing "%" signs
formatted=(formatted>0)? Math.round(formatted*d/100*10)/10 : 0 //round score/d to 1 decimal places
return formatted //return score
}

function rateit(id, votes, avgscore){
this.id=id
this.totalvotes=(votes=="")? 0 : votes
this.avgscore=avgscore
}

rateit.prototype.displaytext=function(tester){
var formatavgscore=formatscore(this.avgscore, ratingdenominator) //Format avgscore from percentage to designated unit
if (tester=="inclusion") //if function being invoked as part of displayrating()
document.write('<span class="scoreinfo" style="margin-left: 10px;"><b>'+formatavgscore+'<sub>/'+ratingdenominator+'</sub></b> from <b>'+this.totalvotes+'</b> votes</span>')
else if (parseInt(tester)>0) //more than 1 vote
document.write('<span class="scoreinfoalt" title="Total votes: '+this.totalvotes+'"><b>'+formatavgscore+'</b></span>')
}

rateit.prototype.displayrating=function(){
document.write('<div class="starcontainer" id="ratecontainer'+this.id+'" rel="'+this.totalvotes+'">') //store total votes in "rel" attr
var formatavgscore=formatscore(this.avgscore, ratingdenominator) //Format avgscore from percentage to designated unit
var halfstarcheck=(formatavgscore-Math.floor(formatavgscore))>=0.5? 1 : 0
for (var i=1; i<ratingdenominator+1; i++){
if (formatavgscore>=i) //display star?
document.write('<div id="'+i+'::on" class="ratebar on" title="Rate this item '+i+' out of '+ratingdenominator+'" >&nbsp;</div>')
else if (Math.floor(formatavgscore)+1==i && halfstarcheck)
document.write('<div id="'+i+'::half" class="ratebar halfon" title="Rate this item '+i+' out of '+ratingdenominator+'" >&nbsp;</div>')
else
document.write('<div id="'+i+'::off" class="ratebar" title="Rate this item '+i+' out of '+ratingdenominator+'" >&nbsp;</div>')
} //end loop

this.displaytext("inclusion")
document.write('</div><br style="clear: left" />')

document.getElementById("ratecontainer"+this.id).onmouseover=rateit.selectrating
document.getElementById("ratecontainer"+this.id).onmouseout=rateit.resetrating
document.getElementById("ratecontainer"+this.id).onclick=rateit.countrating
}

rateit.isContained=function(potentialparent, e){
var e=window.event || e
function isparent(p, c){
while (c.parentNode)
if ((c = c.parentNode) == p)
return true;
return false;
}
return (e.toElement)? potentialparent.contains(e.toElement) : (e.currentTarget)? e.currentTarget==e.relatedTarget || isparent(potentialparent, e.relatedTarget) : false
}

rateit.selectrating=function(e){
var evtobj=window.event? window.event: e
var evttarget=window.event? window.event.srcElement : e.target
var ratingimages=this.getElementsByTagName("div")
if (evttarget.tagName=="DIV" && evttarget.className.indexOf("ratebar")!=-1){
for (var i=1; i<ratingdenominator+1; i++){
ratingimages[i-1].className=(parseInt(ratingimages[i-1].id)<=parseInt(evttarget.id))? "ratebar on" : "ratebar"
}
//window.status=(evtobj.type=="mouseover")? evttarget.getAttribute("title") : ""
}
}

rateit.resetrating=function(e){
if (!rateit.isContained(this, e)){
//document.getElementById("tipmsg").style.display="none"
var ratingimages=this.getElementsByTagName("div")
for (var i=1; i<ratingdenominator+1; i++){
ratingimages[i-1].className=(ratingimages[i-1].id.indexOf("on")!=-1)? "ratebar on" : (ratingimages[i-1].id.indexOf("half")!=-1)? "ratebar halfon" : "ratebar"
}
}
}


rateit.countrating=function(e){ //function to count/update rating onClick
var evttarget=window.event? window.event.srcElement : e.target
if (evttarget.tagName.toUpperCase()=="DIV"){
var rateitemid=parseInt(this.id.replace("ratecontainer", "")) //actual ID of rated item
var score=parseInt(evttarget.getAttribute("id"))/ratingdenominator
score=Math.round(score*100) //Unit is percentage (ie: 60%)
var ajaxobj=createAjaxObj()
if (ajaxobj){
var parameters="id="+rateitemid+"&rating="+score+"&bustcache="+new Date().getTime()
ajaxobj.onreadystatechange=function(){rateit.updaterating(ajaxobj, rateitemid, score)}
ajaxobj.open('GET', ratingscripturl+"?"+parameters, true)
ajaxobj.send(null)
}
}
}

rateit.updaterating=function(ajaxinstance, itemid, score){ //function to count/update rating onClick
var ratecontainer=document.getElementById("ratecontainer"+itemid)
var ratingimages=ratecontainer.getElementsByTagName("div")
var fader=new faderoutine(ratecontainer)
fader.fadeTo(0.2)
ratecontainer.onmouseover=null
ratecontainer.onmouseout=null
ratecontainer.onclick=null
ratecontainer.style.cursor="default"
if (ajaxinstance.readyState == 4){ //if request of file completed
if (ajaxinstance.status==200){
var xmldata=ajaxinstance.responseXML
if (xmldata.getElementsByTagName("latestscore").length==0){ //if error getting latest avgscore
fader.fadeTo(1)
alert(ajaxinstance.responseText)
return
}
var totalvotes=xmldata.getElementsByTagName("totalvotes")[0].firstChild.nodeValue
var avgscore=xmldata.getElementsByTagName("avgscore")[0].firstChild.nodeValue
var votedcheck=xmldata.getElementsByTagName("voted")[0].firstChild.nodeValue
avgscore=formatscore(avgscore, ratingdenominator) //format score from "098%" to score/ratingdenominator
var halfstarcheck=(avgscore-Math.floor(avgscore))>=0.5? 1 : 0
for (var i=1; i<ratingdenominator+1; i++){
ratingimages[i-1].className=(avgscore>=i)? "ratebar on" : (Math.floor(avgscore)+1==i && halfstarcheck)? "ratebar halfon" : "ratebar"
}
ratecontainer.getElementsByTagName("span")[0].innerHTML="<b>"+avgscore+"<sub>/"+ratingdenominator+"</sub></b> from <b>"+totalvotes+"</b> votes"
if (votedcheck=="yes")
alert("Note: Vote not recorded, as you have voted already!")
//document.getElementById("tipmsg").display="none" //remove tip message div
fader.gradualFadeUp(0.2)
}
}
}
