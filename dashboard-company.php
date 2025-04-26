<div class="tab-pane" id="companymanage">
  <div class="row my-3">
    <div class="col"></div>
    <div class="col-6 col-xl-2">
      <button type="button" class="btn btn-primary btn-block float-right editCompany" data-toggle="modal" data-id="<?php echo $resultresult->companyID;?>" data-backdrop='static' data-target="#admineditcompany"><?php echo $array['edit']?> <?php echo $array['company']?></button>
    </div>
  </div>
  <div class="row my-3">
    <div class="col-12 col-xl-3 text-center">
      <div class="row">
        <?php
        $companyobject = new Company();
        $user = new User();
        $companyresult = $companyobject->searchCompany($resultresult->companyID);
        if($companyresult->profilepic){
          $pic = "data:image/jpeg;base64,".base64_encode($companyresult->profilepic);
        }else{
          $pic = "img/userprofile.png";
        }
        ?>
        <div class="col mb-3" id="companyinfoprofilepic">
          <img src="<?php echo $pic;?>" class="rounded-circle" width="100" height="100" style="object-fit: cover;">
        </div>
      </div>

      <div class="custom-file">
        <input type="file" class="custom-file-input" name="upload_image2" id="upload_image2" accept="image/*" />
        <label class="custom-file-label" for="upload_image2">Choose file</label>
      </div>

      <div id="uploadimageModal2" class="modal" role="dialog">
       <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">

            <h6 class="modal-title">Upload Profile Picture</h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="row">
               <div class="col-md-8 text-center">
                <div id="image_demo2" style="width:350px; margin-top:30px"></div>
               </div>
               <div class="col-md-4" style="padding-top:30px;">
                  <button class="btn btn-primary crop_image2">Upload</button>
               </div>
            </div>
          </div>
         </div>
        </div>
      </div>

      <script>  
        $(document).ready(function(){

         $image_crop = $('#image_demo2').croppie({
            enableExif: true,
            viewport: {
              width:200,
              height:200,
              type:'circle' //circle
            },
            boundary:{
              width:300,
              height:300
            }
          });

          $('#upload_image2').on('change', function(){
            var reader = new FileReader();
            reader.onload = function (event) {
              $image_crop.croppie('bind', {
                url: event.target.result
              });
            }
            reader.readAsDataURL(this.files[0]);
            $('#uploadimageModal2').modal('show');
          });

          $('.crop_image2').click(function(event){
            $image_crop.croppie('result', {
              type: 'canvas',
              size: 'viewport'
            }).then(function(response){
              $.ajax({
                url:"ajax-uploadprofilecompany.php",
                type: "POST",
                data:{"image": response},
                success:function(data)
                {
                  $('#uploadimageModal2').modal('hide');
                  $('#uploaded_image2').html(data);
                  getcompanyinfoprofilepic();
                }
              });
            })
          });

        });  
        </script>


    </div>
    <script type="text/javascript">
      $(document).ready(function(){
        $("a[href='#companymanage']").on('shown.bs.tab', function(e) {
          getcompanyinfo();
        });
      });
    </script>
    <div class="col" id="companyinfo"></div>
  </div>
</div>