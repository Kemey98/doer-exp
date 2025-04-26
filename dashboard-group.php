<div class="tab-pane" id="groupmanage">
  <div class="row my-3">
    <div class="col px-2">
      <input class="form-control rounded-0" id="searchgroups" type="text" placeholder="Search..">
    </div>
    <div class="col px-2">
       <select class="form-control rounded-0" id="selectgrouptype">
          <option value="All">All</option>
          <option value="Department">Department</option>
          <option value="Team">Team</option>
          <option value="Project">Project</option>
          <option value="Campaign">Campaign</option>
        </select>
    </div>
    <div class="col px-2">
       <select class="form-control rounded-0" id="selectgroupstatus">
          <option value="All">All</option>
          <option value="Active">Active</option>
          <option value="Inactive">Inactive</option>
        </select>
    </div>
    <div class="col-2 px-2">
      <button type="button" class="btn btn-primary rounded-0 btn-block float-right" data-toggle="modal" data-backdrop='static' data-target="#adminaddgroup"><i class='fas fa-plus'></i> <?php echo $array['add']?> <?php echo $array['group']?></button>
    </div>
  </div>
  <script type="text/javascript">
    $(document).ready(function(){
      $("#searchgroups").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#showgroupslist .searchgroups").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });

      $('#selectgrouptype').change(function () {
        var type = document.getElementById("selectgrouptype").value;
        var status = document.getElementById("selectgroupstatus").value;
        if(type === "All" && status === "All"){
          $(".all").show();
        }else if(type != "All" && status === "All"){
          $(".all").hide();
          $("."+type+"").show();
        }else if(type === "All" && status != "All"){
          $(".all").hide();
          $("."+status+"").show();
        }else if(type != "All" && status != "All"){
          $(".all").hide();
          $("."+type+"."+status+"").show();
        }
      });

      $('#selectgroupstatus').change(function () {
        var type = document.getElementById("selectgrouptype").value;
        var status = document.getElementById("selectgroupstatus").value;
        if(type === "All" && status === "All"){
          $(".all").show();
        }else if(type != "All" && status === "All"){
          $(".all").hide();
          $("."+type+"").show();
        }else if(type === "All" && status != "All"){
          $(".all").hide();
          $("."+status+"").show();
        }else if(type != "All" && status != "All"){
          $(".all").hide();
          $("."+type+"."+status+"").show();
        }
      });

      $("a[href='#groupmanage']").on('show.bs.tab', function(e) {
        getgroupsinfo();
      });
    });
  </script>
  <div id="groupsinfo"></div>
</div>