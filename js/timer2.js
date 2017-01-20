$(document).ready(function () {
function theTime() {
	var myDate = new Date(); 

	var H = myDate.getHours();
	var M = myDate.getMinutes();
	var S = myDate.getSeconds();
	
	if (H <= 9) H = "0" + H;
	if (M <= 9) M = "0" + M;
	if (S <= 9) S = "0" + S;
	
	H = H.toString();
	$('.hours0').html(H[0]);
	$('.hours1').html(H[1]);
	
	M = M.toString();
	$('.minutes0').html(M[0]);
	$('.minutes1').html(M[1]);
	
	S = S.toString();
	$('.seconds0').html(S[0]);
	$('.seconds1').html(S[1]);

	// console.log(H+':'+M+':'+S);

	setTimeout(theTime,1000);	
}
theTime();
});