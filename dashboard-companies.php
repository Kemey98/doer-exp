<div class="tab-pane" id="companymanage">
  <div class="row mt-3">
    <div class="col-12 col-xl-5 px-2">
      <div class="form-group">
        <input class="form-control rounded-0" id="searchcompanies" type="text" placeholder="Search..">
      </div>
    </div>
    <div class="col-12 col-xl-5 px-2">
      <div class="form-group">
        <select class="form-control rounded-0" id="selectcompaniestatus">
          <option value="All">All</option>
          <option value="Active">Active</option>
          <option value="Inactive">Inactive</option>
        </select>
      </div>
    </div>
    <div class="col-12 col-xl-2 px-2">
      <button type="button" class="btn btn-primary rounded-0 btn-block float-right" data-toggle="modal" data-backdrop='static' data-target="#adminaddcompany"><i class='fas fa-plus'></i> <?php echo $array['add']?> <?php echo $array['company']?></button>
    </div>
  </div>
  <script type="text/javascript">
    $(document).ready(function(){
      $("#searchcompanies").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#showcompanieslist .searchcompany").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });

      $('#selectcompaniestatus').change(function () {
        var status = document.getElementById("selectcompaniestatus").value;
        if(status === "All"){
          $(".all").show();
        }else if(status === "Active" || status === "Inactive"){
          $(".all").hide();
          $("."+status+"").show();
        }
      });

      $("a[href='#companymanage']").on('show.bs.tab', function(e) {
        getcompaniesinfo();
      });
    });
  </script>
  <div id="companiesinfo"></div>
</div>