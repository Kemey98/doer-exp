<?php
require_once 'core/init.php';
$userlevel = "";
$user = new User();
if(!$user->isLoggedIn()){
  Redirect::to("login.php");
}else{
  $resultresult = $user->data();
  $userlevel = $resultresult->role;
  if($resultresult->verified == false || $resultresult->superadmin == true){
    $user->logout();
    Redirect::to("login.php?error=error");
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Account Settings - DoerHRM</title> 
  <?php
  include 'includes/header.php';
  ?>
</head>
<body>
  <?php include 'includes/topbar.php';?>
  <div class="d-flex" id="wrapper">
    <?php include 'includes/navbar.php';?>
    <div id="page-content-wrapper">
      <div class="container-fluid" id="content"> 
        <h3 class="my-5"><i class='fas fa-user-cog'></i> <?php echo $array['personalsetting']?></h3>
        <ul class="nav nav-tabs">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#profile"><?php echo $array['profile']?></a>
              </li>
            </ul>
            <script type="text/javascript">
          $(document).ready(function(){
          $('.after').hide();
          var form = $('#changepasswordform');
          form.on('submit', function(e){
            e.preventDefault();
            e.stopPropagation();
            var id = <?php echo $resultresult->userID;?>;
            var password = document.getElementById("oldpassword").value;
            var newpassword = document.getElementById("newconfirmpassword").value;
            $.ajax({
              url: "ajax-editpassword.php?lang=<?php echo $extlg;?>",
              type: "POST",
              data: {
                id:id,
                password:password,
                newconfirmpassword:newpassword
              },
              success:function(data){
                var obj = JSON.parse(data);
                console.log(obj);
                if(obj.condition === "Passed"){
                  $('.before').hide();
                  $('.after').show();
                  
                }else{
                  checkvalidity("oldpassworderror","#oldpassworderror", "#oldpassword", obj.password);
                  checkvalidity("newconfirmpassworderror","#newconfirmpassworderror", "#newconfirmpassword", obj.newpassword);
                }
              }
            });
          });

          $(document).on('click', "#closechangepasswordmodal", function(){
            $("#changepassword").modal("hide");
            modalformrefresh();
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
            document.getElementById(data2).textContent="";
            $(data3).removeClass("border-success").removeClass("border-danger");
          }

          function modalformrefresh(){
            $('.after').hide();
            $('.before').show();
            document.getElementById("changepasswordform").reset(); 
            clearform("#oldpassworderror", "oldpassworderror", "#oldpassword");
            clearform("#newconfirmpassworderror", "newconfirmpassworderror", "#newconfirmpassword");
          }
        });
        </script>
        <div class="modal fade" id="changepassword">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-primary">
                <h6 class="modal-title text-white">Change Password</h6>
                <button type="button" class="close text-white" id="closechangepasswordmodal">&times;</button>
              </div>
              <div class="modal-body">

                <div class="before">
                  <form id="changepasswordform">
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <div class="row">
                            <div class="col-4"><label for="password">Password :</label></div>
                            <div class="col">
                              <input type="password" class="form-control form-control-sm shadow-sm" id="oldpassword" name="oldpassword">
                              <small><span id="oldpassworderror"></span></small>
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="row">
                            <div class="col-4"><label for="confirmpassword">Confirm Password :</label></div>
                            <div class="col">
                              <input type="password" class="form-control form-control-sm shadow-sm" id="newconfirmpassword" name="newconfirmpassword">
                              <small><span id="newconfirmpassworderror"></span></small>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>

                      <div class="text-right mt-3">
                        <button name="submit" value="login" type="submit" class="btn btn-primary shadow-sm">Change</button>
                      </div>

                    </form>
                </div>

                <div class="after">
                  <div class="p-5 text-center">
                    <i class='far fa-check-circle text-success my-3' style='font-size:80px;'></i>
                    <h4>You have successfully change the Password</h4>
                  </div>
                </div>
                
              </div>
            </div>
          </div>
        </div>
        <!-- Tab panes -->
        <div class="tab-content mb-5">
          <div class="tab-pane active" id="profile">
            <div class="row mt-3">
              <div class='col text-right'>
                <button type='button' class='btn btn-outline-danger' data-toggle='modal' data-target='#changepassword' data-backdrop="static" data-keyboard="false"> <?php echo $array['changepassword']?></button>
              </div>
            </div>
            <div class="row my-3">
              <div class="col-3 text-center">
                <div class="row">
                  <div class="col mb-3">
                    <?php
                    if($resultresult->profilepic){
                      ?>
                      <img src="data:image/jpeg;base64,<?php echo base64_encode($resultresult->profilepic);?>" width="100" height="100" style="object-fit: cover;">
                      <?php
                    }else{
                      ?>
                      <img src="img/userprofile.png" class="rounded-circle" width="100" height="100" style="object-fit: cover;">
                      <?php
                    }
                    ?>
                  </div>
                </div>
                
                <div class="custom-file">
                  <input type="file" class="custom-file-input" name="upload_image" id="upload_image" accept="image/*" />
                  <label class="custom-file-label" for="upload_image">Choose file</label>
                </div>

                <div id="uploadimageModal" class="modal" role="dialog">
                 <div class="modal-dialog">
                  <div class="modal-content">
                        <div class="modal-header">
                          
                          <h6 class="modal-title">Upload Profile Picture</h6>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                          <div class="row">
                       <div class="col-md-8 text-center">
                        <div id="image_demo" style="width:350px; margin-top:30px"></div>
                       </div>
                       <div class="col-md-4" style="padding-top:30px;">
                        <button class="btn btn-primary crop_image">Upload</button>
                     </div>
                    </div>
                        </div>
                     </div>
                    </div>
                </div>

                <script>  
                  $(document).ready(function(){

                   $image_crop = $('#image_demo').croppie({
                      enableExif: true,
                      viewport: {
                        width:200,
                        height:200,
                        type:'circle'
                      },
                      boundary:{
                        width:300,
                        height:300
                      }
                    });

                    $('#upload_image').on('change', function(){
                      var reader = new FileReader();
                      reader.onload = function (event) {
                        $image_crop.croppie('bind', {
                          url: event.target.result
                        });
                      }
                      reader.readAsDataURL(this.files[0]);
                      $('#uploadimageModal').modal('show');
                    });

                    $('.crop_image').click(function(event){
                      $image_crop.croppie('result', {
                        type: 'canvas',
                        size: 'viewport'
                      }).then(function(response){
                        console.log(response);
                        $.ajax({
                          url:"ajax-uploadprofilepicture.php",
                          type: "POST",
                          data:{"image": response},
                          success:function(data)
                          {
                            $('#uploadimageModal').modal('hide');
                            $('#uploaded_image').html(data);
                            location.reload();
                          }
                        });
                      })
                    });

                  });  
                  </script>

              </div>
              <div class="col-9">
                <form id="updatepersonaldetailform">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-2"><label><?php echo $array['firstname']?> :</label></div>
                      <div class="col">
                        <input type="text" class="form-control-plaintext form-control-sm" id="profileuserfirstname" name="profileuserfirstname" value="<?php echo $resultresult->firstname;?>"autocomplete="off" readonly>
                        <small><span id="profileuserfirstnameerror"></span></small>
                      </div>
                      <div class="col-2"><label><?php echo $array['lastname']?> :</label></div>
                      <div class="col">
                        <input type="text" class="form-control-plaintext form-control-sm" id="profileuserlastname" name="profileuserlastname" value="<?php echo $resultresult->lastname;?>" autocomplete="off" readonly>
                        <small><span id="profileuserlastnameerror"></span></small>
                      </div>
                      
                    </div>
                    
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-2"><label><?php echo $array['email']?> :</label></div>
                      <div class="col">
                        <input type="text" class="form-control-plaintext form-control-sm" id="profileuseremail" name="profileuseremail" value="<?php echo $resultresult->email;?>" autocomplete="off" readonly>
                        <small><span id="profileuseremailerror"></span></small>
                      </div>
                      <div class="col-2"><label><?php echo $array['jobposition']?> :</label></div>
                      <div class="col">
                        <input type="text" class="form-control-plaintext form-control-sm" id="profileuserjobposition" name="profileuserjobposition" value="<?php echo $resultresult->jobposition?>" autocomplete="off" readonly>
                        <small><span id="profileuserjobpositionerror"></span></small>
                      </div>
                    </div>
                  </div>
                  <?php
                  if($resultresult->corporateID){
                    $corporateobject = new Corporate();
                    $corporateresult = $corporateobject->searchCorporate($resultresult->corporateID);
                    if($corporateresult){
                      $corporatename = $corporateresult->corporate;
                    }else{
                      $corporatename = "--";
                    }
                    $companyobject = new Company();
                    $companyresult = $companyobject->searchCompany($resultresult->companyID);
                    if($companyresult){
                      $companyname = $companyresult->company;
                    }else{
                      $companyname = "--";
                    }
                    ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-2"><label><?php echo $array['corporate']?> :</label></div>
                        <div class="col">
                          <input type="text" class="form-control-plaintext form-control-sm" id="corporatebelong" name="corporatebelong" value="<?php echo $corporatename;?>" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-2"><label><?php echo $array['company']?> :</label></div>
                        <div class="col">
                          <input type="text" class="form-control-plaintext form-control-sm" id="companybelong" name="companybelong" value="<?php echo $companyname;?>" readonly>
                        </div>
                      </div>
                    </div>
                    <?php
                  }else{
                    $companyobject = new Company();
                    $companyresult = $companyobject->searchCompany($resultresult->companyID);
                    if($companyresult){
                      $companyname = $companyresult->company;
                    }else{
                      $companyname = "--";
                    }
                    ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-2"><label><?php echo $array['company']?> :</label></div>
                        <div class="col">
                          <input type="text" class="form-control-plaintext form-control-sm" id="companybelong" name="companybelong" value="<?php echo $companyname;?>" readonly>
                        </div>
                      </div>
                    </div>
                    <?php
                  }
                  ?>
                </form>
              </div>
            </div>
          </div>

        </div>
        
        
        
      </div>
    </div>
    <!-- /#page-content-wrapper -->
  </div>
  <!-- /#wrapper -->

  <script type="text/javascript">
    $(document).ready(function(){
       $("#sidebar-wrapper .active").removeClass("active");
       $("#personaltab").addClass("active");
       document.getElementById("personaltab").style.backgroundColor = "DeepSkyBlue";
    });
  </script>
  <?php
  include 'includes/footer.php';
  ?>
</body>
</html>