function csstopbanner(){
var randomnumberad=Math.floor(Math.random()*4)
if (randomnumberad<1) //1st slot
document.write('<a href="http://www.tradingeye.com" title="Accessible E-commerce software for your site!"><img src="http://www.cssdrive.com/ad_468x60px.gif" width="468px" height="60px" border="0" /></a><br /><a href="http://www.tradingeye.com">Accessible E-commerce script for your site!</a>')
else if (randomnumberad<2) //2nd slot
document.write('<a href="http://www.psd2html.com/order-now.html" title="PSD to HTML"><img src="http://ads.psd2html.com/468x60.jpg" width="468px" height="60px" border="0" alt="PSD to HTML"/></a><br /><a href="http://www.psd2html.com/order-now.html">PSD to HTML</a>')
else if (randomnumberad<4) //3rd and 4th slot
document.write('<a href="http://www.psd2html.com/order-now.html" title="PSD to HTML"><img src="http://ads.psd2html.com/468x60.jpg" width="468px" height="60px" border="0" alt="PSD to HTML" /></a><br /><a href="http://www.psd2html.com/order-now.html">PSD to HTML</a>')
}

csstopbanner()