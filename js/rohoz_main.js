function RohoZ_EC_Reload_Woo1(ee)
{ListRohoZ=document.getElementsByTagName('iframe');
ListRohoZNum=ListRohoZ.length;
for (var u = 0; u < ListRohoZNum; u++) {
if (ListRohoZ[u].hasAttributes('name')) {
if (ListRohoZ[u].getAttribute('name')=='RohoZ_Ecaptcha') {
ListRohoZ[u].src = ListRohoZ[u].src+'';
}
}
}
}
function RohoZ_EC_Reload_Woo()
{
ListRohoZF=document.getElementsByTagName('form');
ListRohoZFNum=ListRohoZF.length;
iv=0;
for (var u = 0; u < ListRohoZFNum; u++) {
ListRohoZF[u].addEventListener( 'submit', function( event ) {
setTimeout("RohoZ_EC_Reload_Woo1()", 1400);
}, false );
}


}
function ROHOZ_EC_setbut_cf7(form)
{
var wpcf7Elm = document.querySelector( '.wpcf7' );
wpcf7Elm.addEventListener( 'wpcf7submit', function( event ) {
	var frames = document.getElementById(form).getElementsByTagName('iframe');

for (s = 0; s < frames.length; s++) {

frames[s].src = frames[s].src;
}
}, false );
}
