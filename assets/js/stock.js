
$(document).ready(function() {
  $('#myTable').DataTable( {
    "order": [[ 3, "asc" ]],
    "pageLength": 50,
    "lengthMenu": [[10, 25, 50, 100, 250, 500,750,1000, -1], [10, 25, 50, 100, 250, 500,750,1000, "All"]],
  } );
} );


$('tbody tr').each(function(){
  var qyt=$(this).find('td:last-child').text();
  qyt=Number(qyt);
  if(qyt==0){
    console.log(qyt);
    $(this).css("color","red");
    $(this).css("font-weight","bold");
  }
});
