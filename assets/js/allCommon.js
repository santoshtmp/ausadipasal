// --------------- nav-bar hover effect ----------------
$(".navbar-collapse .nav-item").each(function(){
    var nav=$(this).find('.nav-link');
    nav.hover(
        function(){
        	nav.addClass('act-nav');
            // nav.css("font-size", "larger");
        },
        function(){
        	nav.removeClass('act-nav');
            // nav.css("font-size", "");
        });
});

  // ------------Add Purchase :: get code_no as itemname is entered------------
  function changeCodeNo() {
    var inputItem = document.getElementById("inputItem").value;
    var editItem = document.getElementById("editItem").value;
    var itemName='';
    if(inputItem){
        itemName=inputItem;
    }
    if(editItem){
        itemName=editItem;
    }
    var urlPag=window.location.href;
    $.ajax({
      url: urlPag,
      type: 'post',
      data: { callFunc1: itemName},
      success: function(response){ 
        var val = response.split("\n"); 
        CodeNo=val[0].trim();
        if (CodeNo) {
            inputCodeNo.value = CodeNo;
            editCodeNo.value = CodeNo;
            $("#inputCodeNo").prop('readonly', true); 
            $("#editCodeNo").prop('readonly', true);
        }else{
            inputCodeNo.value = '';
            editCodeNo.value = '';
            $("#inputCodeNo").prop('readonly', false);
            $("#editCodeNo").prop('readonly', false);
        }
      }
    });
  }

// ----------------------changeExpMrp------------------------------
   function changeExpMrp() {
    var inputItem = document.getElementById("inputItem").value;
    var editItem = document.getElementById("editItem").value;
    var itemName='';
    if(inputItem){
        itemName=inputItem;
    }
    if(editItem){
        itemName=editItem;
    }
    var inputBatchNum = document.getElementById("inputBatchNum").value;
    var editBatchNum = document.getElementById("editBatchNum").value;
    var BatchNum='';
    if(inputBatchNum){
        BatchNum=inputBatchNum;
    }
    if(editBatchNum){
        BatchNum=editBatchNum;
    }
    var itemNameBatchNum=itemName.concat('-');
    itemNameBatchNum=itemNameBatchNum.concat(BatchNum);
    var urlPag=window.location.href;
    $.ajax({
      url: urlPag,
      type: 'post',
      data: { callFunc2: itemNameBatchNum},
      success: function(response){ 
        var val = response.split("\n"); 
        var expMrp=val[0].split(",");
        ExpDate=expMrp[0].trim();
        if (ExpDate) {
            inputExpDate.value = ExpDate;
            editExpDate.value = ExpDate;
            $("#inputExpDate").prop('readonly', true);
            $("#editExpDate").prop('readonly', true);
        }
        if(ExpDate==0){
            $("#inputExpDate").prop('readonly', false);
            $("#editExpDate").prop('readonly', false);
        }
        MRP=Number(expMrp[1]);
        if (MRP) {
            inputMRP.value = MRP;
            editMRP.value = MRP;
            $("#inputMRP").prop('readonly', true);
            $("#editMRP").prop('readonly', true);
        }else{
            inputMRP.value = '';
            editMRP.value = '';
            $("#inputMRP").prop('readonly', false);
            $("#editMRP").prop('readonly', false);
        }
      }
    });
  }

// --------------------------------------------------------
