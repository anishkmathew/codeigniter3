    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
		
		<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Company List</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="qsearch" id="qsearch"  class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default" id="search"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding" id="companylist">
            </div>
            <!-- /.box-body -->
			<div align="right" id="pagination_link"></div>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  
<!-- ./wrapper -->
<script>
$(function () {
	
		
/*
Ajax function call to fetch the pagination content for users list
*/	
$("#search").on("click",
	function(){ 
		load_users_data(1)
	}
);
 function load_users_data(page)
 {
  $.ajax({
   url:"<?php echo $base_url; ?>pagination/ajax_pagination/pagination/"+page,
   method:"GET",
   dataType:"json",
   data: { model: 'company_model', view_fn:'get_company_pagination_view', order_by:'id', order:'asc', qsearch:$('#qsearch').val()},
   success:function(data)
   {
    $('#companylist').html(data.loaded_content);
    $('#pagination_link').html(data.pagination_link);
   }
  });
 }
 //Call the first page
 load_users_data(1);

 $(document).on("click", ".pagination li a", function(event){
  event.preventDefault();
  var page = $(this).data("ci-pagination-page");
  load_users_data(page);
 });

	
		
})
</script>