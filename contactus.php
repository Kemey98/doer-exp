<?php
require_once 'core/init.php';
include 'includes/header.php';
?>
<script type="text/javascript">
  $(document).ready(function(){
    $('.after').hide();
    var form = $('#youmessageform');
    form.on('submit', function(e){
      e.preventDefault();
        e.stopPropagation();
        var alldata = form.serialize();
        $.ajax({
          url: "ajax-contactus.php",
          type: "POST",
          data: alldata,
          success:function(data){
            var obj = JSON.parse(data);
            console.log(obj);
            if(obj.condition === "Passed"){
              $('.before').hide();
              $('.after').show();
            }else{
              checkvalidity("nameerror","#nameerror", "#name", obj.name);
              checkvalidity("emailerror","#emailerror", "#email", obj.email);
              checkvalidity("messageerror","#messageerror", "#message", obj.message);
            }
          }
        });
        function checkvalidity(data1, data2, data3, data4){
          document.getElementById(data1).innerHTML = data4;
          if(data4 === "Required"){
            $(data2).removeClass("text-success").addClass("text-danger");
            $(data3).removeClass("border-success").addClass("border-danger");
          }else if(data4 === "Valid"){
            $(data2).removeClass("text-danger").addClass("text-success");
            $(data3).removeClass("border-danger").addClass("border-success");
          }else{
            $(data2).removeClass("text-success").addClass("text-danger");
            $(data3).removeClass("border-success").addClass("border-danger");
          }
        }
    });
  });
</script>
<body class="bg-light">
  <div class="row">
    <div class="col-xl-3 col-12"></div>
    <div class="col-xl-6 col-12">
      <div class="before px-5">
        <div class="text-center my-5">
          <a class="navbar-brand link font-poetsen-one" href="/index.php" id="logo" style="font-size: 25px;"><span class="text-dark">Doer</span><span class="text-primary">HRM</span></a>
          <h1>Contact Us</h1>
          <h5>Want to know more about us? Let us know by fill the form below</h5>
        </div>
        <form id="youmessageform">
           <div class="form-group">
            <div class="row">
              <div class="col-3"><label>Your Name :</label></div>
              <div class="col">
                <input type="text" class="form-control form-control-sm shadow-sm" id="name" name="name" autocomplete="off">
                <small><span id="nameerror"></span></small>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-3"><label for="email">Your Email :</label></div>
              <div class="col">
                <input type="text" class="form-control form-control-sm shadow-sm" id="email" name="email">
                <small><span id="emailerror"></span></small>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="message">Message:</label>
            <textarea class="form-control" rows="5" id="message" name="message"></textarea>
            <small><span id="messageerror"></span></small>
          </div> 
          <center><button type="submit" class="btn btn-primary mt-3">Submit</button></center>
        </form>
      </div>
      <div class="after">
        <div class="p-5 text-center">
          <i class='far fa-check-circle text-success my-3' style='font-size:50px;'></i>
          <h4>You have successfully send us a question.</h4>
          <p>We will comeback to you.</p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-12"></div>
  </div>
  </div>
    <!-- /#page-content-wrapper -->
</div>
<!-- /#wrapper -->
<?php include 'includes/footer.php';?>