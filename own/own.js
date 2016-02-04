/**
 * 
 */

function toRs(rs)
{
	
	var x=toStr(rs);
	var input = x;
	
	x=x.toString();
	var lastThree = x.substring(x.length-3);
	var otherNumbers = x.substring(0,x.length-3);
	if(otherNumbers != '')
	    lastThree = ',' + lastThree;
	var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;


//alert('Input : '+input+'        Output :'+res);
	return res;
}

function toStr(rs)
{
	
	var str = rs;
	var res = str.replace(",", "");

	return res;
}

