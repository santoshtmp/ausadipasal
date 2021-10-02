 //----------------- show sales detail modal---------------------
  $("tr").each(function(){
    $(this).find('#details').click(function(){
      var mod='#detailsModal'.concat($(this).find('strong').attr('value'));
      // console.log(mod);
      $(mod).modal('toggle');
    })
  });


// ---------------------Add sales to card -----------------------
asales = document.getElementsByClassName('sales');
Array.from(asales).forEach((element)=>{
  element.addEventListener('click',(e)=>{
    tr=e.target.parentNode.parentNode;
    id=(e.target.id).split('-');
    id_ph_inv=id[0].split('/');
    idEditph.value=id_ph_inv[0];
    idEditinv.value=id_ph_inv[1];
    var qyt_max=tr.getElementsByTagName("td")[8].innerText;
    maxqytvalContent=qyt_max;
    if(id[1]){
      qyt_max=qyt_max-id[1];
      maxqytvalContent=qyt_max.toString();
      maxqytvalContent=maxqytvalContent.concat(' => ');
      maxqytvalContent=maxqytvalContent.concat(id[1]);
      maxqytvalContent=maxqytvalContent.concat(' is in card ');
    }
    editItemNam.value=tr.getElementsByTagName("td")[4].innerText;
    editMRP.value=tr.getElementsByTagName("td")[7].innerText;
    editQYT.setAttribute('max',qyt_max);
    maxqytval.textContent=maxqytvalContent; 
    $('#addSalesModal').modal('toggle');
  })
})

// -----------print---------------------
function printContent(id){
     tableId="table-".concat(id);
    var restorepage = document.body.innerHTML;
    var printcontent = document.getElementById(tableId).innerHTML;
    document.body.innerHTML = printcontent;
    window.print();
    document.body.innerHTML = restorepage;
    location.href = window.location.href;
}
