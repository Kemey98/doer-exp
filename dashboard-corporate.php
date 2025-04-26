<div class="tab-pane" id="corporatemanage">
  <div class="row my-3">
    <div class="col"></div>
    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
      <button type="button" class="btn btn-primary rounded-0 btn-block float-right editCorporate" data-id="<?php echo $resultresult->corporateID?>" data-toggle="modal" data-backdrop='static' data-target="#admineditcorporate"><?php echo $array['edit']?> <?php echo $array['corporate']?></button>
    </div>
  </div>
  <div class="row my-3">
    <div class="col-12 col-xl-3 text-center">
      <div class="row">
        <?php
        $corporateobject = new Corporate();
        $user = new User();
        $corporateobjectresult = $corporateobject->searchCorporate($resultresult->corporateID);
        if($corporateobjectresult->profilepic){
          $pic = "data:image/jpeg;base64,".base64_encode($corporateobjectresult->profilepic);
        }else{
          $pic = "img/userprofile.png";
        }
        ?>
        <div class="col mb-3" id="corporateinfoprofilepic">
          <img src="<?php echo $pic;?>" class="rounded-circle" width="100" height="100" style="object-fit: cover;">
        </div>
      </div>
      
      <div class="custom-file">
        <input type="file" class="custom-file-input" name="upload_image" id="upload_image" accept="image/*" />
        <label class="custom-file-label rounded-0" for="upload_image">Choose file</label>
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
              type:'circle' //circle
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
              $.ajax({
                url:"ajax-uploadprofilecorporate.php",
                type: "POST",
                data:{"image": response},
                success:function(data){
                  $('#uploadimageModal').modal('hide');
                  $('#uploaded_image').html(data);
                  getcorporateinfoprofilepic();
                }
              });
            })
          });

          

        });  
      </script>
    </div>
    <script type="text/javascript">
      $(document).ready(function(){
        $("a[href='#corporatemanage']").on('shown.bs.tab', function(e) {
          getcorporateinfo();
        });
      });
    </script>
    <div class="col-12 col-xl-9" id="corporateinfo"></div>
  </div>    
</div>