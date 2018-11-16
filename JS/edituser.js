
$(document).ready( function(){
   var editid;
   $('#Edit').on('show.bs.modal', function(e) {
       var $modal = $(this);
       $.ajax({
           method: 'GET',
           url: '../Controllers/getedit.php',
           data: 'id=' + editid
       })
       .done(function(data) {
        $modal.find('.edit-content').html(data);
      })
   });

   $('#edit-button').click(function(){
     var nickname = $("#changeform input[name='nickname']").val();
     var age = $("#changeform input[name='age']").val();
     var rolevalue = $("#changeform select[name='rolevalue']").val();
     $.ajax({
         type: 'GET',
         url: '../Controllers/edituser.php',
         data: {id: editid, nickname: nickname, age: age, rolevalue: rolevalue }
     })
     .done(function(data) {
       $('#user-'+editid).html(data);
       $('#Edit').modal('toggle');
    });
   });

   $(".users-element").click(function(e) {
     editid = this.dataset.editid;
     $('#Edit').modal('show');
   });

   $('#Delete').on('show.bs.modal', function(e) {
       var $modal = $(this);
       $.ajax({
           method: 'GET',
           url: '../Controllers/getuser.php',
           data: 'id=' + editid
       })
       .done(function(data) {
        $modal.find('.delete-content').html(data);
      })
      .fail(function() {
        $modal.find('.delete-content').html(editid);
      })
   });

   $('#agree-delete-button').click(function(){
     $.ajax({
         method: 'GET',
         url: '../Controllers/deleteuser.php',
         data: 'id='+ editid
     })
     .done(function() {
      $('#user-'+editid).remove();
      $('#Delete').modal('toggle');
    });
   });

   $("#delete-button").on('click', function(){
     $('#Delete').modal('show');
     $('#Edit').modal('toggle');
   });

   $("#back-delete-button").on('click', function(){
     $('#Delete').modal('toggle');
     $('#Edit').modal('show');
   });

})
