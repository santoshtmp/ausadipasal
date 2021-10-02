
	// ---------------card :: grand_total = sum of all total_mrp  -----------------
	var total_mrp = document.getElementsByClassName('total_mrp');
	var grand_total_val=0;
	for(var i = 0; i < total_mrp.length; i++) {
		grand_total_val = grand_total_val+Number(total_mrp[i].textContent);
	}
	var sales_item_id =document.getElementsByClassName('sales_item_id');
	var all_sales_item_id_conc='';
	for(var i = 0; i < sales_item_id.length; i++) {
		if (i==0) {
			all_sales_item_id_conc = sales_item_id[i].textContent;
		}
		else if (i==(sales_item_id.length-1)) {
			all_sales_item_id_conc = all_sales_item_id_conc.concat(',');
			all_sales_item_id_conc = all_sales_item_id_conc.concat(sales_item_id[i].textContent);
		}
		else{
			all_sales_item_id_conc = all_sales_item_id_conc.concat(',');
			all_sales_item_id_conc = all_sales_item_id_conc.concat(sales_item_id[i].textContent);
		}
	}
	if(grand_total_val){
		cardProcess.value='1';
		all_sales_item_id.value=all_sales_item_id_conc;
		total_amo.value=grand_total_val;
		total_net_amo.value=grand_total_val;
	}
	document.getElementById('grand_total').textContent=grand_total_val;
	document.getElementById('net_total').textContent=grand_total_val;
	document.getElementById('cancel-edit-btn').classList.add('hide');
	document.getElementById('edit-sales-btn').classList.add('hide');
	document.getElementById('submit-sales-btn').classList.remove('hide'); 
	document.getElementById('cancel-sales-btn').classList.remove('hide');

	// --------------- card :: get disc perc and display net_total  -----------------
	function getDisAmo() {
		var inputDisPerc = document.getElementById("dis_percent").value;
		var net_total=grand_total_val/(1+(inputDisPerc/100));
		net_total=parseFloat(net_total.toFixed(3));
		document.getElementById('net_total').textContent=net_total;
		disount_percent.value=inputDisPerc;
		total_net_amo.value=net_total;
	}

	// --------------- card :: change qyt :: Edit sales qyt   -----------------
	function changeQyt(obj){
		const itemID=(obj.id).split('-')[1];
		const mrp_id='mrp-'.concat(itemID);
		const qyt_id='qyt-'.concat(itemID);
		const total_mrp_id='total_mrp-'.concat(itemID);
		const mrp=Number(document.getElementById(mrp_id).textContent);
		const qyt=Number(document.getElementById(qyt_id).value);
		document.getElementById(total_mrp_id).textContent=mrp*qyt;
		var total_mrp = document.getElementsByClassName('total_mrp');
		var grand_total_val=0;
		for(var i = 0; i < total_mrp.length; i++) {
			grand_total_val = grand_total_val+Number(total_mrp[i].textContent);
		}
		if(grand_total_val){
			total_amo.value=grand_total_val;
			total_net_amo.value=grand_total_val;
		}
		document.getElementById('grand_total').textContent=grand_total_val;
		document.getElementById('net_total').textContent=grand_total_val;
		document.getElementById('dis_percent').type='hidden';
		document.getElementById('submit-sales-btn').disabled = true; 
		var sales_qyt =document.getElementsByClassName('sales_qyt');
		var all_sales_qyt_conc='';
		for(var i = 0; i < sales_qyt.length; i++) {
			if (i==0) {
				all_sales_qyt_conc = sales_qyt[i].value;
			}
			else if (i==(sales_qyt.length-1)) {
				all_sales_qyt_conc = all_sales_qyt_conc.concat(',');
				all_sales_qyt_conc = all_sales_qyt_conc.concat(sales_qyt[i].value);
			}
			else{
				all_sales_qyt_conc = all_sales_qyt_conc.concat(',');
				all_sales_qyt_conc = all_sales_qyt_conc.concat(sales_qyt[i].value);
			}
		}
		var total_mrp = document.getElementsByClassName('total_mrp');
		var all_total_mrp_conc='';
		for(var i = 0; i < total_mrp.length; i++) {
			if (i==0) {
				all_total_mrp_conc = total_mrp[i].textContent;
			}
			else if (i==(total_mrp.length-1)) {
				all_total_mrp_conc = all_total_mrp_conc.concat(',');
				all_total_mrp_conc = all_total_mrp_conc.concat(total_mrp[i].textContent);
			}
			else{
				all_total_mrp_conc = all_total_mrp_conc.concat(',');
				all_total_mrp_conc = all_total_mrp_conc.concat(total_mrp[i].textContent);
			}
		}
		all_sales_qyt.value=all_sales_qyt_conc;
		all_total_p.value=all_total_mrp_conc;
		document.getElementById('cancel-edit-btn').classList.remove('hide');
		document.getElementById('edit-sales-btn').classList.remove('hide');
		document.getElementById('submit-sales-btn').classList.add('hide'); 
		document.getElementById('cancel-sales-btn').classList.add('hide');
	}

	// ------------ on click cancel-edit-btn redirect to http://ausadipasal.freecluster.eu/Card.php  ----------------

	document.getElementById("cancel-edit-btn").onclick = function () {
		// console.log(window.location.href);
		location.href = window.location.href;
	};

	// -------------------------- cancel btn conform ---------------------
	document.getElementById("cancel-sales-btn").onclick = function () {
		// https://craftpip.github.io/jquery-confirm/
		$.confirm({
			title: 'Confirm   !!!',
			content: 'Cancel Sales Process',
			buttons: {
				conform: {
					btnClass: 'btn-blue',
					action: function(){
						$('#card-form').append('<input type="hidden" name="cancel_sales" value="cancel_sales" >   ');
						document.getElementById("card-form").submit();
					}
				},
				cancel: {
					btnClass: 'btn-blue',
					action: function(){
						console.log('cancel');
					}
				}
			}
		});
	}

	// -------------------------sales process btn ------------------
	document.getElementById("submit-sales-btn").onclick = function () {
		// https://craftpip.github.io/jquery-confirm/
		$.confirm({
			title: 'Confirm !!!',
			content: '<p class="sales-btn-clk">---   Sales Process   ---</p>',
			buttons: {
				conform: {
					btnClass: 'btn-blue',
					action: function(){
						$('#card-form').append('<input type="hidden" name="submit_sales" value="submit_sales">   ');
						document.getElementById("card-form").submit();
					}
				},
				cancel: {
					btnClass: 'btn-blue',
					action: function(){
						console.log('cancel');
					}
				}
			}
		});
	}

	// -------------------------edit sales process btn ------------------
	// document.getElementById("edit-sales-btn").onclick = function () {
	// 	// https://craftpip.github.io/jquery-confirm/
	// 	$.confirm({
	// 		title: 'Confirm !!!',
	// 		content: '<p class="edit-sales-btn-clk">---   Edit Sales Process   ---<p>',
	// 		buttons: {
	// 			conform: {
	// 				btnClass: 'btn-yellow',
	// 				action: function(){
	// 					$('#card-form').append('<input type="hidden" name="edit_sales" value="edit_sales"  >  ');
	// 					document.getElementById("card-form").submit();
	// 				}
	// 			},
	// 			cancel: {
	// 				btnClass: 'btn-blue',
	// 				action: function(){
	// 					console.log('cancel');
	// 				}
	// 			}
	// 		}
	// 	});
	// }

// ----------------------Delete single card item-------------------------------

document.getElementById("delcarditem").onclick = function () {
	var delid=document.getElementById('delcarditem').value;
    window.location='Card.php?delete='+delid;
		// location.href = window.location.href;
};
// -----------------------------------------------------
