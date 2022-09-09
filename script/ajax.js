function createAjaxObj(){
var httprequest=false
if (window.XMLHttpRequest){ // if Mozilla, Safari etc
httprequest=new XMLHttpRequest()
if (httprequest.overrideMimeType)
httprequest.overrideMimeType('text/xml')
}
else if (window.ActiveXObject){ // if IE
try {
httprequest=new ActiveXObject("Msxml2.XMLHTTP");
} 
catch (e){
try{
httprequest=new ActiveXObject("Microsoft.XMLHTTP");
}
catch (e){}
}
}
return httprequest
}


function faderoutine(obj){
//this.fadediv=document.getElementById("ratecontainer"+id)
this.fadediv=obj
this.fadeupvalue=0.2 //initial fade value when gradually fading up, if non specified via param
this.fadedownvalue=1 //initial fade value when gradually fading down, if non specified via param
}

faderoutine.prototype.fadeTo=function(amount){
if (this.fadediv.filters && this.fadediv.filters[0])
this.fadediv.filters[0].opacity=amount*100
else if (typeof this.fadediv.style.MozOpacity!="undefined")
this.fadediv.style.MozOpacity=amount
}

faderoutine.prototype.gradualFadeUp=function(initialamount){
if (typeof initialamount!="undefined")
this.fadeupvalue=initialamount
var faderinstance=this
if (this.fadeupvalue<1){
this.fadeupvalue+=0.1
this.fadeTo(this.fadeupvalue)
setTimeout(function(){faderinstance.gradualFadeUp()}, 100)
}
}

faderoutine.prototype.gradualFadeDown=function(initialamount){
if (typeof initialamount!="undefined")
this.fadedownvalue=initialamount
var faderinstance=this
if (this.fadedownvalue>0){
this.fadedownvalue-=0.1
this.fadeTo(this.fadedownvalue)
setTimeout(function(){faderinstance.gradualFadeDown()}, 100)
}
}