<div class="modal adminModal fade" id="subscriptionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
 <div class="modal-dialog" role="document">
  <div class="modal-content">
   <div class="modal-body">
    <p class="modal-title"> Please select a subscription</p>
    <div class="subscription-body">
     <div class="row no-gutters subrRow">
      <div class="col-6">
       <input type="radio" name="radiog_lite" id="radio1" class="css-radio" checked="checked"/>
       <label for="radio1" class="radio-label radGroup1">Yearly</label>
      </div>
      <div class="col-6 documentPrice">$49.99</div>
     </div>
     <div class="row no-gutters subrRow">
      <div class="col-6">
       <input type="radio" name="radiog_lite" id="radio2" class="css-radio" />
       <label for="radio2" class="radio-label radGroup1">Monthly</label>
      </div>
      <div class="col-6 documentPrice">$9.99</div>
     </div>
    </div>
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    <button type="button" class="btn btn-primary">Submit</button>
   </div>
  </div>
 </div>
</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
  crossorigin="anonymous"></script>
<!--<script src="/js/paginate.js" ></script> -->
<script>
  /*  let options = {
        numberPerPage:3, //Cantidad de datos por pagina
        goBar:false, //Barra donde puedes digitar el numero de la pagina al que quiere ir
        pageCounter:true, //Contador de paginas, en cual estas, de cuantas paginas
    };

    let filterOptions = {
        el:'#searchBox' //Caja de texto para filtrar, puede ser una clase o un ID
    };

    paginate.init('.apptable',options);*/




//tab sorting -----------------------------
    function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("stTableSearch");
  switching = true;
  //Set the sorting direction to ascending:
  dir = "asc"; 
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++;      
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}


$('body').on('click','.sorting',function(){
if($(this).hasClass('sorting_asc')){
   $(this).removeClass('sorting_asc');
  $(this).addClass('sorting_desc');
}else if($(this).hasClass('sorting_desc')){
  $(this).addClass('sorting_asc');
 $(this).removeClass('sorting_desc');
}else {
$(this).addClass('sorting_asc');
}

$('.sorting').not(this).removeClass('sorting_desc');
$('.sorting').not(this).removeClass('sorting_asc');

});

$(document).on("click", ".delete" , function() {
  var delete_id = $(this).data('id');
  var el = $('.memberrow'+delete_id);
  $.ajax({
    url: 'deleteUsermember/'+delete_id,
    type: 'get',
    success: function(response){
      $(el).fadeOut().remove();
	  $('.modal.show').hide();
    }
  });
});


$(document).on("click", ".deletemob" , function() {
  var delete_id = $(this).data('id');
  var el = $('.row'+delete_id);
  $.ajax({
    url: 'deleteUsermember/'+delete_id,
    type: 'get',
    success: function(response){
      $(el).fadeOut().remove();
	  $('.modal.show').hide();
    }
  });
});
</script>
</body>
</html>
<span></span>