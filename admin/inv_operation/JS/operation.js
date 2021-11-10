function cal_mater_cub(lenght,width,height) {
	let l=parseFloat(lenght);
	let w=parseFloat(width);
	let h=parseFloat(height);
	let result=l*w*h;
	return result.toFixed(4);
}
function sum_salary(salary,dword,inde,adeduct,reduce) {
	let s1=parseFloat(salary);
	let s2=parseFloat(dword);
	let s3=parseFloat(inde);
	let s4=parseFloat(adeduct);
	let s5=parseFloat(reduce);
	let results=(s1/30)*s2+s3+s4+s4;
	return results.toFixed(2);
}