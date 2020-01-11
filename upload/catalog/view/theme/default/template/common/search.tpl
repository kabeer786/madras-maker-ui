<div id="search" class="input-group">
  <input type="text" name="search" value="<?php echo $search; ?>" placeholder="Search Halls & hotels Here" class="form-control input-lg" />
  <span class="input-group-btn">
    <button type="button" class="btn btn-default btn-lg"><i class="fa fa-search"></i></button>
  </span>
</div>
 <div class="col-sm-6">
              <div class="form-group">
<!--                <label class="control-label" for="input-date-added">from date</label>-->
                <div class="input-group date">
                  <input type="text" name="filter_date_added"  placeholder="From date" data-date-format="DD-mm-YYYY" id="input-date-added" class="datetime form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
    </div>
 <div class="col-sm-6">
              <div class="form-group">
<!--                <label class="control-label" for="input-date-added">from date</label>-->
                <div class="input-group date">
                  <input type="text" name="filter_date_added"  placeholder="From date" data-date-format="DD-mm-YYYY" id="input-date-added" class="datetime form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
    </div>
<script src="admin/view/javascript/jquery/datetimepicker/moment.js" type="text/javascript"></script>
<script src="admin/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
  <link href="admin/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />
       <script type="text/javascript"> 

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: false
});
 </script>
 <style>
 .datetime{
   cursor:pointer;
 }
 #search{
       padding: 0px 11px ;
 }
 </style>