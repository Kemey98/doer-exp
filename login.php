<?php
require_once 'core/init.php';
include 'includes/header.php';
?>
<script type="text/javascript">
  $(document).ready(function(){
    $('#combinationnotfound').hide();
    $('#expiredlogin').hide();
    var form = $('#loginform');
    form.on('submit', function(e){
      e.preventDefault();
      e.stopPropagation();
      var email = document.getElementById("email").value;
      var password = document.getElementById("password").value;
      var remember = document.getElementById("remember").checked;
      var alldata = "email="+email+"&password="+password+"&remember="+remember;
      $.ajax({
        url: "ajax-login.php",
        type: "POST",
        data: alldata,
        success:function(data){
          var obj = JSON.parse(data);
          console.log(obj);
          if(obj.condition === "Passed"){
            if(obj.combination){
              $('#combinationnotfound').html(obj.combination);
              document.getElementById("loginform").reset(); 
              clearform("#emailerror", "emailerror", "#email");
              clearform("#passworderror", "passworderror", "#password");
            }else{
              window.location.replace(obj.link);
            }
            
          }else if(obj.condition === "Expired"){
            $('#expiredlogin').show();
          }else{
            checkvalidity("emailerror","#emailerror", "#email", obj.email);
            checkvalidity("passworderror","#passworderror", "#password", obj.password);
          }
        }
      });
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

    function clearform(data1, data2, data3){
      $(data1).removeClass("text-success").removeClass("text-danger");
      document.getElementById(data2).innerHTML="";
      $(data3).removeClass("border-success").removeClass("border-danger");
    }

  });
</script>
<body class="bg-light">
  <div class="row">
    <div class="col-xl-4 col-1"></div>

    <div class="col-xl-4 col-10 my-5 py-5">
      <div class="text-center mb-5 mt-3">
        <h4>Welcome to <a class="navbar-brand link font-poetsen-one" href="/index.php" id="logo" style="font-size: 25px;"><span class="text-dark">Doer</span><span class="text-primary">HRM</span></a></h4>
        <h5>Sign In</h5>
      </div>
      <div id="combinationnotfound"></div>
      
      <?php
      if(Input::get('error')){
      ?>
      <div class='alert alert-danger alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert'>&times;</button><strong>You email is not verified</strong>
      </div>
      <?php
      }
      ?>
      <form id="loginform">
        <div class="form-group">
          <div class="row">
            <div class="col-3"><label>Email :</label></div>
            <div class="col">
              <input type="text" class="form-control form-control-sm shadow-sm" id="email" name="email" autocomplete="off">
              <small><span id="emailerror"></span></small>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-3"><label for="password">Password :</label></div>
            <div class="col">
              <input type="password" class="form-control form-control-sm shadow-sm" id="password" name="password">
              <small><span id="passworderror"></span></small>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                <label class="custom-control-label" for="remember">Remember me</label>
              </div>

              
            </div>
          </div>
        </div>
        
        <div class="text-center">
          <button name="submit" value="login" type="submit" class="btn btn-primary shadow-sm">Sign In</button>
        </div>

      </form>
      <a href="forgetpassword.php" class="float-right">Forget Password?</a>
    </div>
    <div class="col-xl-4 col-1"></div>
  </div>

  </div>
    <!-- /#page-content-wrapper -->
</div>
<!-- /#wrapper -->

<?php include 'includes/footer.php';?>
