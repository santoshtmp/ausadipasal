

function expListClick(){
	const date = new Date();
	var today_date=(date.getFullYear()).toString();
	today_date=today_date.concat('-');
	today_date=today_date.concat(date.getMonth() + 1);  
	today_date=today_date.concat('-');
	today_date=today_date.concat(date.getDate());
	const today_date_obj=new Date(today_date);
	$('tbody tr').each(function(){
		var exp_date_val=$(this).find('#exp-date').text();
		var exp_date = $(this).find('#exp-date');
		const exp_date_val_obj=new Date(exp_date_val);
		if(exp_date_val_obj<today_date_obj){
			exp_date.css("color", "red");
		}else{
			$(this).hide();
		}
		var qyt = $(this).find('#qyt');
		qyt.css("color", "black");
	});
	document.getElementById('page_name').textContent='Inventory : Expired List';
	document.getElementById('today_date_v').textContent=today_date;
	document.getElementById('today_date_id').classList.remove('hide');
	document.getElementById('inventory_back').classList.remove('hide'); 
	document.getElementById('today_date_id').classList.add('today_date');
}

function stockListClick(){
	$('tbody tr').each(function(){
		var qyt_val=$(this).find('#qyt').text();
		var qyt = $(this).find('#qyt');
		if(Number(qyt_val)<30){
			qyt.css("color", "red");
		}else{
			$(this).hide();
		}
		var exp_date = $(this).find('#exp-date');
		exp_date.css("color", "black");
	});
	document.getElementById('page_name').textContent='Inventory : Stock List';
	document.getElementById('inventory_back').classList.remove('hide');
	document.getElementById('today_date_id').classList.add('hide');
}

function inventoryBack(){
	$('tbody tr').each(function(){
		var exp_date = $(this).find('#exp-date');
		var qyt = $(this).find('#qyt');
		exp_date.css("color", "black");
		qyt.css("color", "black");
		$(this).show();
	});
	document.getElementById('page_name').textContent='Inventory List';
	document.getElementById('today_date_id').classList.add('hide');
	document.getElementById('inventory_back').classList.add('hide');
}
