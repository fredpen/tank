var disappeardelay=250  //menu disappear speed onMouseout (in miliseconds)
var enableanchorlink=0 //Enable or disable the anchor link when clicked on? (1=e, 0=d)
var hidemenu_onclick=1 //hide menu when user clicks within menu? (1=yes, 0=no)

/////No further editting needed

var ie5=document.all
var ns6=document.getElementById&&!document.all

function getposOffset(what, offsettype){
var totaloffset=(offsettype=="left")? what.offsetLeft : what.offsetTop;
var parentEl=what.offsetParent;
while (parentEl!=null){
totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
parentEl=parentEl.offsetParent;
}
return totaloffset;
}

function showhide(obj, e, visible, hidden){
if (ie5||ns6)
dropmenuobj.style.left=dropmenuobj.style.top=-500
if (e.type=="click" && obj.visibility==hidden || e.type=="mouseover"){
obj.visibility=visible
}
else if (e.type=="click"){
obj.visibility=hidden
}
}

function iecompattest(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function clearbrowseredge(obj, whichedge){
var edgeoffset=0
if (whichedge=="rightedge"){
var windowedge=ie5 && !window.opera? iecompattest().scrollLeft+iecompattest().clientWidth-15 : window.pageXOffset+window.innerWidth-15
dropmenuobj.contentmeasure=dropmenuobj.offsetWidth
if (windowedge-dropmenuobj.x < dropmenuobj.contentmeasure)
edgeoffset=dropmenuobj.contentmeasure-obj.offsetWidth
}
else{
var topedge=ie5 && !window.opera? iecompattest().scrollTop : window.pageYOffset
var windowedge=ie5 && !window.opera? iecompattest().scrollTop+iecompattest().clientHeight-15 : window.pageYOffset+window.innerHeight-18
dropmenuobj.contentmeasure=dropmenuobj.offsetHeight
if (windowedge-dropmenuobj.y < dropmenuobj.contentmeasure){ //move up?
edgeoffset=dropmenuobj.contentmeasure+obj.offsetHeight
if ((dropmenuobj.y-topedge)<dropmenuobj.contentmeasure) //up no good either?
edgeoffset=dropmenuobj.y+obj.offsetHeight-topedge
}
}
return edgeoffset
}

function dropdownmenu(obj, e, dropmenuID, isTop){
var e=window.event || e
var topmenuoffset=(typeof isTop!="undefined")? 4 : 0
if (window.event) event.cancelBubble=true
else if (e.stopPropagation) e.stopPropagation()
if (typeof dropmenuobj!="undefined") //hide previous menu
dropmenuobj.style.visibility="hidden"
clearhidemenu()
if (ie5||ns6){
obj.onmouseout=delayhidemenu
dropmenuobj=document.getElementById(dropmenuID)
if (hidemenu_onclick) dropmenuobj.onclick=function(){dropmenuobj.style.visibility='hidden'}
dropmenuobj.onmouseover=clearhidemenu
dropmenuobj.onmouseout=ie5? function(){ dynamichide(event)} : function(event){ dynamichide(event)}
showhide(dropmenuobj.style, e, "visible", "hidden")
dropmenuobj.x=getposOffset(obj, "left")
dropmenuobj.y=getposOffset(obj, "top")
dropmenuobj.style.left=dropmenuobj.x-clearbrowseredge(obj, "rightedge")+"px"
dropmenuobj.style.top=dropmenuobj.y-clearbrowseredge(obj, "bottomedge")+obj.offsetHeight-topmenuoffset+"px"
}
return clickreturnvalue()
}

function clickreturnvalue(){
if ((ie5||ns6) && !enableanchorlink) return false
else return true
}

function contains_ns6(a, b) {
while (b.parentNode)
if ((b = b.parentNode) == a)
return true;
return false;
}

function dynamichide(e){
if (ie5&&!dropmenuobj.contains(e.toElement))
delayhidemenu()
else if (ns6&&e.currentTarget!= e.relatedTarget&& !contains_ns6(e.currentTarget, e.relatedTarget))
delayhidemenu()
}

function delayhidemenu(){
delayhide=setTimeout("dropmenuobj.style.visibility='hidden'",disappeardelay)
}

function clearhidemenu(){
if (typeof delayhide!="undefined")
clearTimeout(delayhide)
}

function getposOffset(overlay, offsettype){
var totaloffset=(offsettype=="left")? overlay.offsetLeft : overlay.offsetTop;
var parentEl=overlay.offsetParent;
while (parentEl!=null){
totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
parentEl=parentEl.offsetParent;
}
return totaloffset;
}

function overlay(curobj, subobj){
if (document.getElementById){
var subobj=document.getElementById(subobj)
subobj.style.left=getposOffset(curobj, "left")+"px"
subobj.style.top=getposOffset(curobj, "top")+"px"
subobj.style.display="block"
return false
}
else
return true
}

function overlayclose(subobj){
document.getElementById(subobj).style.display="none"
}

////Random Order Contents script////////////

function randomizeContent(classname){
var contents=randomizeContent.collectElementbyClass(classname)
contents.text.sort(function() {return 0.5 - Math.random();})
for (var i=0; i<contents.ref.length; i++){
contents.ref[i].innerHTML=contents.text[i]
contents.ref[i].style.visibility="visible"
}
}

randomizeContent.collectElementbyClass=function(classname){ //return two arrays containing elements with specified classname, plus their innerHTML content
var classnameRE=new RegExp("(^|\\s+)"+classname+"($|\\s+)", "i") //regular expression to screen for classname within element
var contentobj=new Object()
contentobj.ref=new Array() //array containing references to the participating contents
contentobj.text=new Array() //array containing participating contents' contents (innerHTML property)
var alltags=document.all? document.all : document.getElementsByTagName("*")
for (var i=0; i<alltags.length; i++){
if (typeof alltags[i].className=="string" && alltags[i].className.search(classnameRE)!=-1){
contentobj.ref[contentobj.ref.length]=alltags[i]
contentobj.text[contentobj.text.length]=alltags[i].innerHTML
}
}
if (document.all){ //remove first DIV from group in IE
	contentobj.ref.shift()
	contentobj.text.shift()
}
return contentobj
}

////Dynamic Assign event handler////////////

function assignmyevents(){
var topitem1=document.getElementById("topmenuitem1")
var topitem2=document.getElementById("topmenuitem2")
var topitem3=document.getElementById("topmenuitem3")
var topitem4=document.getElementById("topmenuitem4")
var topitem5=document.getElementById("topmenuitem5")
var topitem6=document.getElementById("topmenuitem6")
var topitem7=document.getElementById("topmenuitem7")
var topitem8=document.getElementById("topmenuitem8")
var topitem9=document.getElementById("topmenuitem9")

/*var login=document.getElementById("login")
var register=document.getElementById("register")
var edit=document.getElementById("editprofile")
var logout=document.getElementById("logout")
var keysearch=document.getElementById("keywords")
*/
topitem1.onmouseover=function(event){
dropdownmenu(this, event, 'anylinkmenu1')
}
topitem2.onmouseover=function(event){
dropdownmenu(this, event, 'anylinkmenu2')
}
topitem3.onmouseover=function(event){
dropdownmenu(this, event, 'anylinkmenu3')
}
topitem4.onmouseover=function(event){
dropdownmenu(this, event, 'anylinkmenu4')
}
topitem5.onmouseover=function(event){
dropdownmenu(this, event, 'anylinkmenu5')
}
topitem6.onmouseover=function(event){
dropdownmenu(this, event, 'anylinkmenu6')
}
topitem7.onmouseover=function(event){
dropdownmenu(this, event, 'anylinkmenu7')
}
topitem8.onmouseover=function(event){
dropdownmenu(this, event, 'anylinkmenu8')
}
topitem9.onmouseover=function(event){
dropdownmenu(this, event, 'anylinkmenu9')
}
if (login!=null){
login.onclick=function(){window.location=this.title}
register.onclick=function(){window.location=this.title}
}
else if (edit!=null){
edit.onclick=function(){window.location=this.title}
logout.onclick=function(){window.location=this.title}
}
keysearch.onfocus=function(){clearText(this)}

}


function _addEvent(target, functionref, tasktype) {
	if (target.addEventListener)
		target.addEventListener(tasktype, functionref, false);
	else if (target.attachEvent)
		target.attachEvent('on'+tasktype, function(){return functionref.call(target, window.event)});
}
