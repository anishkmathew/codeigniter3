    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
		<div class="row"><div class="col-md-12">
		<div class="box box-primary">
            
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" id="from_company" enctype="multipart/form-data" method="POST"  novalidate >
              <div class="box-body">
                <div class="form-group">
                  <label for="company_name">Company Name</label>
                  <input type="text" class="form-control" id="company_name" placeholder="Company Name">
                </div>
                <div class="form-group">
                  <label for="stock_value">Stock value</label>
                  <input type="text" class="form-control" id="stock_value" placeholder="Stock value">
                </div>
				<div class="form-group">
                  <label>Address</label>
                  <textarea class="form-control" rows="3"name="company_address"  ></textarea>
                </div>
                <div class="form-group">
                  <label for="company_pic">Company pic</label>
                  <input type="file" id="company_pic" name="company_pic">

                  <p class="help-block">Example block-level help text here.</p>
                </div>
                <!-- <div class="checkbox">
                  <label>
                    <input type="checkbox"> Check me out
                  </label>
                </div> -->
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
      </div>  </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  
<!-- ./wrapper -->
<script>
$('#from_company').validate();
$(function () {
	//$('#from_company').validate();
	//$('#from_company').validate();
	// $('#from_company').validate({
	// rules:{
		// password:{
			// required:true,
			// minlength : 8				
		// }
	// }
//});	
})
</script>