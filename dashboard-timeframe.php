<div class="tab-pane" id="timeframe">
  <div class="row my-3">
    <div class="col px-2">
      <input class="form-control rounded-0" id="searchtimeframes" type="text" placeholder="Search..">
    </div>
    <div class="col px-2">
       <select class="form-control rounded-0" id="selecttimeframestatus">
          <option value="All">All</option>
          <option value="Active">Active</option>
          <option value="Inactive">Inactive</option>
        </select>
    </div>
    <div class="col-2 px-2">
      <button type="button" class="btn btn-primary rounded-0 btn-block float-right" data-toggle="modal" data-backdrop='static' data-target="#addtimeframemodal"><i class='fas fa-plus'></i> <?php echo $array['add']?> <?php echo $array['timeframe']?></button>
    </div>
  </div>
  <script type="text/javascript">
    $(document).ready(function(){
      $("#searchtimeframes").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#showtimeframeslist .searchtimeframes").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });

      $('#selecttimeframestatus').change(function () {
        var status = document.getElementById("selecttimeframestatus").value;
        if(status === "All"){
          $(".all").show();
        }else if(status === "Active" || status === "Inactive"){
          $(".all").hide();
          $("."+status+"").show();
        }
      });

      $("a[href='#timeframe']").on('show.bs.tab', function(e) {
        gettimeframeinfo();
      });
    });
  </script>
  <div id="timeframesinfo"></div>
</div>