<?php include('header.php'); ?>
    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
		
		<div class="row">
		
		<div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>150</h3>

              <p>New Orders</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
		</div>
		<div class="row">
		<div class="col-md-9">
		
		<div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Users List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="userlist">
             <?php /* <table class="table table-bordered">
                <tbody><tr>
                  <th style="width: 10px">#</th>
                  <th>User Name</th>
                  <th>Email</th>
                  <th style="width: 40px">ID</th>
                </tr>
				<?php if ($user_list){
					$num = 0;
					foreach($user_list as $k=>$user_data){?>
                <tr>
                  <td><?php echo ++$num?></td>
                  <td><?php echo $user_data['username']?></td>
                  <td>
                    <?php echo $user_data['email']?>
                  </td>
                  <td><span class="badge bg-red"><?php echo $user_data['id']?></span></td>
                </tr>
					<?php }
				}else{?>
				<tr>
                  <td colspan="4">No Records</td>
                </tr>
				<?php } ?>
              </tbody></table> */ ?>
            </div>
            <!-- /.box-body -->
			
			<div align="right" id="pagination_link"></div>
            
          </div>
		  
		</div>
		</div>
		<div class="row">
		<div class="col-md-9">
		<div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Carousel</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                  <li data-target="#carousel-example-generic" data-slide-to="0" class=""></li>
                  <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                  <li data-target="#carousel-example-generic" data-slide-to="2" class="active"></li>
                </ol>
                <div class="carousel-inner">
                  <div class="item">
                    <img src="http://placehold.it/900x500/39CCCC/ffffff&amp;text=I+Love+Bootstrap" alt="First slide">

                    <div class="carousel-caption">
                      First Slide
                    </div>
                  </div>
                  <div class="item active left">
                    <img src="http://placehold.it/900x500/3c8dbc/ffffff&amp;text=I+Love+Bootstrap" alt="Second slide">

                    <div class="carousel-caption">
                      Second Slide
                    </div>
                  </div>
                  <div class="item next left">
                    <img src="http://placehold.it/900x500/f39c12/ffffff&amp;text=I+Love+Bootstrap" alt="Third slide">

                    <div class="carousel-caption">
                      Third Slide
                    </div>
                  </div>
                </div>
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                  <span class="fa fa-angle-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                  <span class="fa fa-angle-right"></span>
                </a>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
		  </div>
		</div>
		<div class="row">
		<div class="col-md-6">
		<div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-bar-chart-o"></i>

              <h3 class="box-title">Line Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div id="line-chart" style="height: 300px; padding: 0px; position: relative;"><canvas class="flot-base" width="616" height="300" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 616px; height: 300px;"></canvas><div class="flot-text" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; font-size: smaller; color: rgb(84, 84, 84);"><div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px;"><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 63px; top: 283px; left: 22px; text-align: center;">0</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 63px; top: 283px; left: 108px; text-align: center;">2</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 63px; top: 283px; left: 195px; text-align: center;">4</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 63px; top: 283px; left: 281px; text-align: center;">6</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 63px; top: 283px; left: 368px; text-align: center;">8</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 63px; top: 283px; left: 451px; text-align: center;">10</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 63px; top: 283px; left: 537px; text-align: center;">12</div></div><div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px;"><div class="flot-tick-label tickLabel" style="position: absolute; top: 270px; left: 1px; text-align: right;">-1.5</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 225px; left: 1px; text-align: right;">-1.0</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 180px; left: 1px; text-align: right;">-0.5</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 135px; left: 5px; text-align: right;">0.0</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 90px; left: 5px; text-align: right;">0.5</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 45px; left: 5px; text-align: right;">1.0</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 0px; left: 5px; text-align: right;">1.5</div></div></div><canvas class="flot-overlay" width="616" height="300" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 616px; height: 300px;"></canvas></div>
            </div>
            <!-- /.box-body-->
          </div>
		</div>
		<div class="col-md-6">
		<div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-bar-chart-o"></i>

              <h3 class="box-title">Bar Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div id="bar-chart" style="height: 300px; padding: 0px; position: relative;"><canvas class="flot-base" width="386" height="300" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 386px; height: 300px;"></canvas><div class="flot-text" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; font-size: smaller; color: rgb(84, 84, 84);"><div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px;"><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 84px; top: 283px; left: 18px; text-align: center;">January</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 84px; top: 283px; left: 78px; text-align: center;">February</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 84px; top: 283px; left: 147px; text-align: center;">March</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 84px; top: 283px; left: 213px; text-align: center;">April</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 84px; top: 283px; left: 276px; text-align: center;">May</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 84px; top: 283px; left: 336px; text-align: center;">June</div></div><div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px;"><div class="flot-tick-label tickLabel" style="position: absolute; top: 270px; left: 7px; text-align: right;">0</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 203px; left: 7px; text-align: right;">5</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 135px; left: 1px; text-align: right;">10</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 68px; left: 1px; text-align: right;">15</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 0px; left: 1px; text-align: right;">20</div></div></div><canvas class="flot-overlay" width="386" height="300" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 386px; height: 300px;"></canvas></div>
            </div>
            <!-- /.box-body-->
			</div>
          </div>
		  <div class="col-md-6">
		  <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-bar-chart-o"></i>

              <h3 class="box-title">Donut Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div id="donut-chart" style="height: 300px; padding: 0px; position: relative;"><canvas class="flot-base" width="358" height="300" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 358.5px; height: 300px;"></canvas><canvas class="flot-overlay" width="358" height="300" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 358.5px; height: 300px;"></canvas><span class="pieLabel" id="pieLabel0" style="position: absolute; top: 71px; left: 237.852px;"><div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">Series2<br>30%</div></span><span class="pieLabel" id="pieLabel1" style="position: absolute; top: 211px; left: 215.852px;"><div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">Series3<br>20%</div></span><span class="pieLabel" id="pieLabel2" style="position: absolute; top: 130px; left: 56.8516px;"><div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">Series4<br>50%</div></span></div>
            </div>
            <!-- /.box-body-->
          </div>
		  </div>
		  
		</div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2016 <a href="#">Company</a>.</strong> All rights reserved.
  </footer>
 
  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<?php include('footer.php')?>
<script>
$(function () {
/*
Ajax function call to fetch the pagination content for users list
*/	

 function load_users_data(page)
 {
  $.ajax({
   url:"<?php echo $base_url; ?>pagination/ajax_pagination/pagination/"+page,
   method:"GET",
   dataType:"json",
   data: { model: 'user_model', view_fn:'get_users_pagination_view', order_by:'id', order:'asc' },
   success:function(data)
   {
    $('#userlist').html(data.loaded_content);
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


	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

     /*
     * LINE CHART
     * ----------
     */
    //LINE randomly generated data

    var sin = [], cos = []
    for (var i = 0; i < 14; i += 0.5) {
      sin.push([i, Math.sin(i)])
      cos.push([i, Math.cos(i)])
    }
    var line_data1 = {
		label :'t1',
      data : sin,
      color: '#3c8dbc'
    }
    var line_data2 = {
      label :'t2',
	  data : cos,
      color: '#00c0ef'
    }
    $.plot('#line-chart', [line_data1, line_data2], {
      grid  : {
        hoverable  : true,
        borderColor: '#f3f3f3',
        borderWidth: 1,
        tickColor  : '#f3f3f3'
      },
      series: {
        shadowSize: 0,
        lines     : {
          show: true
        },
        points    : {
          show: true
        },
		label : {
			show:true
		},
      },
      lines : {
        fill : false,
        color: ['#3c8dbc', '#f56954']
      },
      yaxis : {
        show: true
      },
      xaxis : {
        show: true
      }
    })
    //Initialize tooltip on hover
    $('<div class="tooltip-inner" id="line-chart-tooltip"></div>').css({
      position: 'absolute',
      display : 'none',
      opacity : 0.8
    }).appendTo('body')
    $('#line-chart').bind('plothover', function (event, pos, item) {

      if (item) {
        var x = item.datapoint[0].toFixed(2),
            y = item.datapoint[1].toFixed(2)

        $('#line-chart-tooltip').html(item.series.label + ' of ' + x + ' = ' + y)
          .css({ top: item.pageY + 5, left: item.pageX + 5 })
          .fadeIn(200)
      } else {
        $('#line-chart-tooltip').hide()
      }

    })
    /* END LINE CHART */
	
	/*
     * BAR CHART
     * ---------
     */

    var bar_data = {
      data : [['January', 10], ['February', 8], ['March', 4], ['April', 13], ['May', 17], ['June', 9]],
      color: '#3c8dbc'
    }
	$.plot('#bar-chart', [bar_data], {
      grid  : {
        borderWidth: 1,
        borderColor: '#f3f3f3',
        tickColor  : '#f3f3f3'
      },
      series: {
        bars: {
          show    : true,
          barWidth: 0.9,
          align   : 'center'
        }
      },
      xaxis : {
        mode      : 'categories',
        tickLength: 1
      }
    })
    /* END BAR CHART */
	
	  /*
     * DONUT CHART
     * -----------
     */

    var donutData = [
      { label: 'Series2', data: 30, color: '#3c8dbc' },
      { label: 'Series3', data: 20, color: '#0073b7' },
      { label: 'Series4', data: 50, color: '#00c0ef' }
    ]
    $.plot('#donut-chart', donutData, {
      series: {
        pie: {
          show       : true,
          radius     : 1,
          innerRadius: 0.5,
          label      : {
            show     : true,
            radius   : 2 / 3,
            formatter: labelFormatter,
            threshold: 0.1
          }

        }
      },
      legend: {
        show: false
      }
    })
    /*
     * END DONUT CHART
     */
		
})

/*
   * Custom Label formatter
   * ----------------------
   */
  function labelFormatter(label, series) {
    return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
      + label
      + '<br>'
      + Math.round(series.percent) + '%</div>'
  }
</script>