<script language="javascript">
			function PrintElem(el) {
			  
				var restorepage = $('body').html();
				var printcontent = $('#' + el).clone();
				$('body').empty().html(printcontent);
				window.print();
				$('body').html(restorepage);

			}
</script>
<script>
		 $(document).ready(function() {
		$('.adddatatable').DataTable({
			responsive: true,
			paging: false,
			lengthChange: false,
			ordering: false,
			searching: false,
			info: false,
			autoWidth: true,
			sDom: 'lfrtip'
		
		});
	});
</script>		
</head>
<body>	
		<div id="getpassprint" style="margin-left:10px;">
			<table width="100%" border="0">
				<tbody>
					<tr>
						<td align="left">
						<?php $nowdate = date("Y-m-d");?>
							{{ trans('app.Date')}} : <?php echo  date(getDateFormat(),strtotime($nowdate)); ?> </td>
					</tr>
				</tbody>
			</table> <br/>
		
			<div class="row">
				<div class="col-md-4 col-sm-4 col-xs-12">
						<span style="float:left;" class="printimg">
							<img src="../public/vehicle/service.png" style="width: 240px; height: 90px;">
							<img src="..//public/general_setting/<?php echo $setting->logo_image ?>" width="230px" height="70px" style="position: absolute; top: 10px; left: 15px;">
						</span>
				</div>
				<div class="col-md-8 col-sm-8 col-xs-12">
							<h3 align="center" class="modal-title"><?php echo $setting->system_name; ?> </h3>
							<h5 align="center"> <?php echo $setting->address; ?></h5>
				</div>
				<hr/>		
				
				<div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-8 col-sm-offset-8">
							<h5>{{ trans('app.Gate Pass No. :')}} <?php echo $getpassdata->gatepass_no; ?></h5>
				</div>
			</div>
					<div class="modal-body">
						<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;" >
				
	            			<tbody> 	
	            				<tr>
	            					<h3 align="center"><u>{{ trans('app.Gate Pass')}}</u></h3><br>
	            				</tr>

	            				<tr class="printimg">
	            					<td color="white" align="center" colspan="2" style="padding:0px;"><b><h4>{{ trans('app.Gate Pass Details')}}</h4></b></td>
	            				</tr>
							
	            				<tr>
	            					<td class="cname">{{ trans('app.Name:')}}</td>
	            					<td class="cname"> <?php echo $getpassdata->name.' '.$getpassdata->lastname; ?></td>
	            				</tr>
	            				
	            				<tr>
	            					<td class="cname">{{ trans('app.Jobcard Number:')}}</td>
	            					<td class="cname"> <?php echo $getpassdata->jobcard_id; ?></td>
	            				</tr>
	            				           				
	            				<tr>
	            					<td class="cname">{{ trans('app.Vehicle Name:')}}</td>
	            					<td class="cname"><?php echo $getpassdata->modelname; ?></td>
	            				</tr>
	            				
	            				<tr>
	            					<td class="cname">{{ trans('app.Service Date:')}}</td>
	            					<td class="cname">											{{date(getDateFormat(),strtotime($getpassdata->service_date)) }}</td>
	            				</tr>
	            				
								<tr>
	            					<td class="cname">{{ trans('app.Vehicle Out Date:')}}</td>
	            					<td class="cname">{{date(getDateFormat(),strtotime($getpassdata->service_out_date)) }}</td>
	            				</tr>
								
	            				<tr>
	            					<td class="cname"> {{ trans('app.Created On:')}}</td>
	            					<td class="cname">{{date(getDateFormat(),strtotime($getpassdata->created_at)) }}</td>
	            				</tr>
	            				
	            				<tr>
	            					<td class="cname">{{ trans('app.Created By:')}}</td>
	            					<td class="cname"><?php echo getAssignTo($getpassdata->create_by); ?></td>
	            				</tr>
                              </tbody>
	               			</table>
					</div></div>

					<div class="col-md-8 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div id="carousel" class="carousel slide">
								<div class="carousel-inner">
								</div>
							</div>
							<div id="thumbcarousel" >
								<div class="carousel-inner-1">
								</div><!-- /carousel-inner -->
							</div> <!-- /thumbcarousel -->
						</div> 
					</div>
					
					
					<div class="modal-footer">
						<button type="button" class="btn btn-default printbtn" id="" onclick="PrintElem('getpassprint')">{{ trans('app.Print')}} </button>
						<a href="" class="prints"><button type="button" class="btn btn-default">{{ trans('app.Close')}}</button></a>
				    </div>



<style>
	.right_side .table_row, .member_right .table_row {
		border-bottom: 1px solid #dedede;
		float: left;
		width: 100%;
		padding: 1px 0px 4px 2px;
		
	}
	.member_right{border: 1px solid #dedede;
		margin-left: 9px;}
	.table_row .table_td {
	padding: 8px 8px !important;
	
	}
	.report_title {
		float: left;
		font-size: 20px;
		margin-bottom: 10px;
		padding-top: 10px;
		width: 100%;
	}
	.b-detail__head-title {
		border-left: 4px solid #2A3F54;
		padding-left: 15px;
	text-transform: capitalize;
	
	}

	.b-detail__head-price {
		width: 100%;
		float: right;
		text-align: center;
	}
	.b-detail__head-price-num {
	padding: 4px 34px;
		font: 700 23px 'PT Sans',sans-serif;
		
	}

	.thumb img{
	border-radius: 0px;
	}


	.item .thumb {
		width: 23%;
	cursor: pointer;
	float: left;
	border:1px solid;
	margin: 3px;
	
	}
	.item .thumb img {
	width: 100%;
	height: 80px;
	}
	.item img {
	width:435px;

	}
	.carousel-inner-1{
		margin-top: 16px;
	}
	.carousel-inner>.item>a>img, .carousel-inner>.item>img, .img-responsive, .thumbnail a>img, .thumbnail>img{height:300px; width:100%;}
	.shiptitleright{
		float: right;
	}
	ul.bar_tabs>li.active { background:#fff !important;}

</style>


					<!-- Scripts starting -->		
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script>
$(document).ready(function()
{  
 	var m = <?php echo $available; ?>;
  
  	for(var i=0 ; i< m.length ; i++) 
  	{
    	$('<div class="item"><img src="'+m[i]+'"><div class="carousel-caption"></div>   </div>').appendTo('.carousel-inner');
	 	
	 	$('<div class="item"> <div data-target="#carousel" data-slide-to="'+i+'" class="thumb"><img src="'+m[i]+'"></div></div>').appendTo('.carousel-inner-1');
    
    	$('<li data-target="#carousel-example-generic" data-slide-to="'+i+'"></li>').appendTo('.carousel-indicators')
  	}
  
  	$('#thumbcarousel .item').first().addClass('active');
  	$('.item').first().addClass('active');
  	$('.carousel-indicators > li').first().addClass('active');
  	$('#carousel-example-generic').carousel();
});
</script>