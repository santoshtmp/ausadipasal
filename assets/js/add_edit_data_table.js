$(document).ready( function () {
  $('#myTable').DataTable();
} );

$('#myTable').dataTable( {
  "pageLength": 50,
  "lengthMenu": [[10, 25, 50, 100, 250, 500,750,1000, -1], [10, 25, 50, 100, 250, 500,750,1000, "All"]],
} );

// $('select').append(new Option('150', '150'));


// ------------------add purchase----------------------------
adds = document.getElementsByClassName('add');
Array.from(adds).forEach((element)=>{
  element.addEventListener('click',(e)=>{
      // console.log('add--');
      $('#addModal').modal('toggle');
    })
})
// ---------------------------------------------------
// adds = document.getElementsByClassName('add');
// Array.from(adds).forEach((element)=>{
//   element.addEventListener('click',(e)=>{
//       // console.log('add--');
//       $('#addModal').modal('toggle');
//     })
// });

// adds = document.getElementsByClassName('add');
// Array.from(adds).forEach((element)=>{
//   element.addEventListener('click',(e)=>{
//       $('#addModal').modal('toggle');
//     })
// })



// ---------------------sales delete -----------------------
// deletes = document.getElementsByClassName('delete');
// Array.from(deletes).forEach((element)=>{
//   element.addEventListener('click',(e)=>{
//     sno=e.target.id.substr(1,);
//     if (confirm("Are you sure you want to delete...")) {
//       console.log("delete-yes", sno);
//       window.location='sales.php?delete='+sno;
//     }
//     else{
//       console.log("delete-no", sno);
//     }

//   })
// })


// ---------------------Purchase edit -----------------------
function editProcess(obj){
    const btnClik=obj.id;
    const delEditId = (btnClik).split("-");
    const id = delEditId[0];
    const qyt = delEditId[1];
    const qyt_purch = delEditId[2];
    if(qyt==qyt_purch){
        var tr = document.getElementById(obj.id).parentNode.parentNode; 
        // console.log(tr);
        idEdit.value=id;
        editBillNo.value=tr.getElementsByTagName("td")[2].innerText;
        editCodeNo.value=tr.getElementsByTagName("td")[3].innerText;
        editItem.value=tr.getElementsByTagName("td")[4].innerText;
        editBatchNum.value=tr.getElementsByTagName("td")[5].innerText;
        editExpDate.value=tr.getElementsByTagName("td")[6].innerText;
        editMRP.value=tr.getElementsByTagName("td")[7].innerText;
        editQYT.value=tr.getElementsByTagName("td")[8].innerText;
        $("#editCodeNo").prop('readonly', true);
        $("#editMRP").prop('readonly', true);
        $("#editExpDate").prop('readonly', true);

        $('#editModal').modal('toggle');
    }
    else{
        $('#editQytEqualPuchModal').modal('toggle');
    }
}
// ---------------------Purchase delete -----------------------

function deletePurchase(obj){
    var delId = (obj.id).split("-");
    const sno = delId[0];
    const qyt = delId[1];
    const qyt_purch = delId[2];
    if(qyt==qyt_purch){
        confDelete.value=sno;
        $('#delConformModal').modal('toggle');
    }
    else{
        $('#qytEqualPuchModal').modal('toggle');
    }
    
}
function confDel(){
    var delid=document.getElementById('confDelete').value;
    window.location='purchase.php?delete='+delid;
}
// ----------------- outStockList Click display--------------------------------

// function outStockListClick(){
//     $('tbody tr').each(function(){
//         var qyt_val=$(this).find('#qyt').text();
//         var qyt = $(this).find('#qyt');
//         if(Number(qyt_val)!=0){
//             $(this).hide();
//         }
//     });
//     document.getElementById('page_name').textContent='Stock Out List';
//     document.getElementById('page-info').textContent='Item Quantity-QYT is 0';
// }
// ----------------------------------------------------------------------------

