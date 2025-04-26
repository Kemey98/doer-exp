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
        var socialmedia = document.getElementById("socialmedia").checked;
        var emailmarketing = document.getElementById("emailmarketing").checked;
        var runningads = document.getElementById("runningads").checked;
        var blogwebsite = document.getElementById("blogwebsite").checked;
        var education = document.getElementById("education").checked;
        var referring = document.getElementById("referring").checked;
        var other = document.getElementById("other").checked;
        var alldata2 = "&socialmedia="+socialmedia+"&emailmarketing="+emailmarketing+"&runningads="+runningads+"&blogwebsite="+blogwebsite+"&education="+education+"referring="+referring+"&other="+other;
        console.log(alldata+alldata2);
        $.ajax({
          url: "ajax-becomeouraffiliate.php",
          type: "POST",
          data: alldata+alldata2,
          success:function(data){
            var obj = JSON.parse(data);
            console.log(obj);
            if(obj.condition === "Passed"){
              $('.before').hide();
              $('.after').show();
            }else{
              checkvalidity("nameerror","#nameerror", "#name", obj.name);
              checkvalidity("emailerror","#emailerror", "#email", obj.email);
              checkvalidity("jobtitleerror","#jobtitleerror", "#jobtitle", obj.jobtitle);
              checkvalidity("companynameerror","#companynameerror", "#companyname", obj.companyname);
              checkvalidity("websiteurlerror","#websiteurlerror", "#websiteurl", obj.websiteurl);
              checkvalidity("countryerror","#countryerror", "#country", obj.country);
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
  <div class="row mb-5">
    <div class="col-xl-3 col-12"></div>
    <div class="col-xl-6 col-12 mb-5">
      <div class="before px-5">
        <div class="text-center my-5">
          <a class="navbar-brand link font-poetsen-one" href="/index.php" id="logo" style="font-size: 25px;"><span class="text-dark">Doer</span><span class="text-primary">HRM</span></a>
          <h1>Become a DoerHRM Affiliate</h1>
          <h5>Interested to become our affiliate? Let us know by fill the form below</h5>
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
            <div class="row">
              <div class="col-3"><label for="jobtitle">Job Title :</label></div>
              <div class="col">
                <input type="text" class="form-control form-control-sm shadow-sm" id="jobtitle" name="jobtitle">
                <small><span id="jobtitleerror"></span></small>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-3"><label for="companyname">Company Name :</label></div>
              <div class="col">
                <input type="text" class="form-control form-control-sm shadow-sm" id="companyname" name="companyname">
                <small><span id="companynameerror"></span></small>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-3"><label for="websiteurl">Website URL :</label></div>
              <div class="col">
                <input type="text" class="form-control form-control-sm shadow-sm" id="websiteurl" name="websiteurl">
                <small><span id="websiteurlerror"></span></small>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-3"><label for="country">Country :</label></div>
              <div class="col">
                <input type="text" class="form-control form-control-sm shadow-sm" id="country" name="country">
                <small><span id="countryerror"></span></small>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="message">Why are you interested in the DoerHRM affiliate program?</label>
            <textarea class="form-control" rows="5" id="message" name="message"></textarea>
            <small><span id="messageerror"></span></small>
          </div> 
          <p>If accepted into the program, where will you promote your affiliate links?<br>Please select all that apply</p>
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="socialmedia" name="socialmedia">
            <label class="custom-control-label" for="socialmedia">Social media (Facebook, Twitter, LinkedIn, etc)</label>
          </div>
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="emailmarketing" name="emailmarketing">
            <label class="custom-control-label" for="emailmarketing">Email marketing</label>
          </div>
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="runningads" name="runningads">
            <label class="custom-control-label" for="runningads">Running ads (Google Adwords, Facebook ads, etc)</label>
          </div>
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="blogwebsite" name="blogwebsite">
            <label class="custom-control-label" for="blogwebsite">Blog/website articles</label>
          </div>
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="education" name="education">
            <label class="custom-control-label" for="education">Courses and educational content</label>
          </div>
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="referring" name="referring">
            <label class="custom-control-label" for="referring">Referring clients</label>
          </div>
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="other" name="other">
            <label class="custom-control-label" for="other">Other</label>
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