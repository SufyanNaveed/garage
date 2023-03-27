 @extends('layouts.app')
@section('content')
<?php Session::put('post_vehicle_image',''); ?>

<!-- page content starting -->	
	<div class="right_col" role="main">
		<div class="page-title">
			<div class="nav_menu">
				<nav>
					<div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"> </i><span class="titleup">&nbsp; {{ trans('app.Gate Pass')}}</span></a>
					</div>
					  @include('dashboard.profile')
				</nav>
			</div>
		</div>

		<div class="x_content">
			<ul class="nav nav-tabs bar_tabs" role="tablist">
				@can('gatepass_view')
					<li role="presentation" class=""><a href="{!! url('/gatepass/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i>{{ trans('app.Gatepass List')}}</span></a></li>
				@endcan
				@can('gatepass_edit')
					<li role="presentation" class="active"><a href="{!! url('/gatepass/list/edit/'.$gatepass->id) !!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i><b>{{ trans('app.Edit Gatepass')}}</b></span></a></li>
				@endcan
			</ul>
		</div>

		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_content">
						<form id="demo-form2" action="upadte/{{$gatepass->id}}" method="post" enctype="multipart/form-data" data-parsley-validate   class="form-horizontal form-label-left input_mask">
									 
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							
							<div class="col-md-12 col-xs-12 col-sm-12 space">
								<h4><b>{{ trans('app.Customer Information')}}</b></h4>
								<p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
							</div>

							<div class="col-md-12 col-sm-6 col-xs-12">
								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('jobcard') ? ' has-error' : '' }} my-form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="jobcard">{{ trans('app.JobCard No. ') }} <label class="color-danger">*</label> 
								
									</label>
									<div class="col-md-9 col-sm-9 col-xs-12">
										<select name="jobcard"  class="form-control" id="selectjobcard" url="{!!url('/gatepass/gatedata')!!}" required>
											
											@if(!empty($jobno))
												@foreach($jobno as $jobnos)
												<option value="{{$jobnos->job_card}}" <?php if($jobnos->job_card == $gatepass->jobcard_id){echo"selected";};?>>{{$jobnos->job_card }}</option>
												@endforeach
												@endif
										</select>
									</div>
								</div>
							
								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('gatepass_no') ? ' has-error' : '' }} my-form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="gatepass_no">{{ trans('app.Gate_no') }} <label class="color-danger">*</label>
									</label>
									<div class="col-md-9 col-sm-9 col-xs-12">
										<input type="text" id="gatepass_no" name="gatepass_no"  class="form-control"  
										value="{{$gatepass->gatepass_no}}" placeholder="{{ trans('app.Auto Generated Gate Pass Number')}}"  readonly/>
									</div>
								</div>
							</div>

							<div class="col-md-12 col-sm-6 col-xs-12">
								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('firstname') ? ' has-error' : '' }} my-form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="firstname">{{ trans('app.First Name') }} <label class="color-danger">*</label> 
									</label>
								
									<div class="col-md-9 col-sm-9 col-xs-12">
									  <input type="text"  id="customer" name="Customername" value="{{$gatepass->name}}" placeholder="{{ trans('app.Enter First Name')}}"  class="form-control" readonly >
									</div>
								</div>
							 
								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('lastname') ? ' has-error' : '' }} my-form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="lastname">{{ trans('app.Last Name') }} <label class="color-danger">*</label>
									</label>
									<div class="col-md-9 col-sm-9 col-xs-12">
										<input type="text" id="lastname" name="lastname" value="{{$gatepass->lastname}}" placeholder="{{ trans('app.Enter Last Name')}}" class="form-control" readonly>
									</div>
								</div>
							</div>

							<div class="col-md-12 col-sm-6 col-xs-12">
								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }} my-form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">{{ trans('app.Email') }} <label class="color-danger">*</label></label>
									<div class="col-md-9 col-sm-9 col-xs-12">
										<input type="text"  id="email" name="email" value="{{$gatepass->email}}" placeholder="{{ trans('app.Enter Email')}}" class="form-control " readonly>
									</div>
								</div>

								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('mobile') ? ' has-error' : '' }} my-form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="mobile">{{ trans('app.Mobile No') }} <label class="color-danger" >*</label>
									</label>
									<div class="col-md-9 col-sm-9 col-xs-12">
									  <input type="text"  id="mobile" name="mobile" value="{{$gatepass->mobile_no}}" placeholder="{{ trans('app.Enter Mobile No')}}"  class="form-control" readonly >
									</div>
								</div>
							</div>

	 
							<div class="col-md-12 col-xs-12 col-sm-12 space">
								<h4><b>{{ trans('app.Vehicle Information')}}</b></h4>
								<p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
							</div>

							<div class="col-md-12 col-sm-6 col-xs-12">
								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('model_name') ? ' has-error' : '' }} my-form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="model_name">{{ trans('app.Vehicle Name') }} <label class="color-danger" >*</label>
									</label>
									<div class="col-md-9 col-sm-9 col-xs-12">
									  <input type="text"  id="vehicle" name="vehiclename" value="{{$gatepass->modelname}}"placeholder="{{ trans('app.Enter Vehicle Name')}}" class="form-control" readonly >
									</div>
								</div>

								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('veh_type') ? ' has-error' : '' }} my-form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="veh_type">{{ trans('app.Vehicle Type') }} <label class="color-danger" >*</label>
									</label>
									<div class="col-md-9 col-sm-9 col-xs-12">
									  <input type="text"  id="veh_type" name="veh_type" value="{{$gatepass->vehicle_type}}"placeholder="{{ trans('app.Enter Vehicle Type')}}" class="form-control" readonly >
									</div>
								</div>
							</div>

							<div class="col-md-12 col-sm-6 col-xs-12">
								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('chassis') ? ' has-error' : '' }}">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="chassis">{{ trans('app.Chassis') }} </label>
									<div class="col-md-9 col-sm-9 col-xs-12">
									  <input type="text" id="chassis" name="chassis" value="{{$gatepass->chassisno}}" placeholder="{{ trans('app.Enter Chassis No.')}}"  class="form-control" readonly >
									</div>
								</div>

								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('kms') ? ' has-error' : '' }} my-form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kms">{{ trans('app.KMs.Run') }} <label class="color-danger" >*</label>
									</label>
									<div class="col-md-9 col-sm-9 col-xs-12">
									  <input type="text" id="kms" name="kms" value="{{$gatepass->kms_run}}" placeholder="{{ trans('app.Enter Kms. Run')}}" class="form-control jobcard" maxlength="10" readonly >
									</div>
								</div>
							</div>

							
							<div class="col-md-12 col-xs-12 col-sm-12 space">
								<h4><b>{{ trans('app.Other Information')}}</b></h4>
								<p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
							</div>

							<div class="col-md-12 col-sm-6 col-xs-12">
								<div class="col-md-6 col-sm-6 col-xs-12 form-group {{ $errors->has('out_date') ? ' has-error' : '' }} my-form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12 currency" for="out_date">{{ trans('app.Vehicle Out Date') }} <label class="color-danger" >*</label>
									</label>
									<div class="col-md-9 col-sm-9 col-xs-12 input-group date datepicker">
										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
										<input type="text"  id="outdate_gatepass" name="out_date" autocomplete="off" value="<?php  echo date( getDateFormat().' H:i:s',strtotime($gatepass->service_out_date));?>" placeholder="{{ trans('app.Enter Vehicle Out Date')}}" class="form-control gatepassOutdate" onkeypress="return false;" required >
									</div>
								</div>
							</div>

							<div class="col-md-12 col-xs-12 col-sm-12 space">
								<h4><b>{{ trans('app.Vehicle Images')}}</b></h4>
								<p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
							</div>

							<!-- Vehical images  -->
							<div class="col-md-6 col-sm-12 col-xs-12 form-group my-form-group">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<span> <h5 style="margin-left: 10px;"> {{ trans('app.Select Multiple Images')}} </h5> </span>
									</div>
										<div class="form-group col-md-10 col-sm-12 col-xs-12">
											<!--<input type="file"  name="image[]"  class="form-control imageclass" id="images" onchange="preview_images();"  data-max-file-size="5M" multiple />-->
											<div class="col-md-2 col-sm-2 col-xs-12 addremove">
												<button type="button" class="btn btn-default" data-target="#responsive-modal-images-model" data-toggle="modal"> Choose Files</button>
											</div><br><br>
											<div class="row" id="image_preview">
												@if(!empty($images1))
													@foreach($images1 as $images2)
															<div class="col-md-4 col-sm-4 col-xs-12 removeimage delete_image" id="image_remove_<?php echo $images2->id; ?>"  imgaeid="{{$images2->id}}" delete_image="{!! url('gatepass/delete/getImages')!!}">
																<a href=""><img src="{{ url('public/gatepass/'.$images2->image) }}"  width="100px" height="60px"> 
																<p class="text">{{ trans('app.Remove')}}</p> </a>
															</div>
													@endforeach
												@endif
											</div>
										</div>
								<div class="row classimage" id="image_preview"></div>
									
							</div>
							<div class="form-group col-md-12 col-sm-12 col-xs-12">
								<div class="col-md-12 col-sm-12 col-xs-12 text-center">
									<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
									<button type="submit" class="btn btn-success">{{ trans('app.Update')}}</button>
								</div>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Images Upload -->
	<div class="col-md-6">
			<div id="responsive-modal-images-model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
							<h4 class="modal-title">Images Upload</h4>
						</div>
						<div class="modal-body">
						<form method="post" action="{{url('/gatepass/vehicle_images')}}" enctype="multipart/form-data" class="dropzone" id="dropzoneFrom">
							@csrf
						</form>   
						</div>
					</div>
				</div>
			</div>
		</div>
	<!-- End Images Upload -->
<!-- /page content -->
<style>
	.removeimage{float:left;    padding: 5px; height: 70px;}
	.removeimage .text {
		position:relative;
		bottom: 45px;
		display:block;
		left: 20px;
		font-size:18px;
		color:red;
		visibility:hidden;
	}
	.removeimage:hover .text {
		visibility:visible;
	}
</style>

<!-- Scripts starting -->
<script src="{{ URL::asset('build/js/jquery.min.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
	
<script>
$(document).ready(function()
{
	Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("#dropzoneFrom", {
        url: "upload.php", // Set the url for your upload script location
        paramName: "file", // The name that will be used to transfer the file
        maxFiles: 10,
        acceptedFiles:".png,.jpg,.gif,.bmp,.jpeg",
        maxFilesize: 10, // MB
        addRemoveLinks: false,
        accept: function(file, done) {
            if (file.name == "wow.jpg") {
                done("Naha, you don't.");
            } else {
                var html = '<div class="col-md-2">'+
                    '<img src="upload/'+file.name+'" class="img-thumbnail" width="175" height="175" style="height:175px;" />'+
                    '<button type="button" class="btn btn-link remove_image" id="'+file.name+'">Remove</button>'+
                '</div>';
                $('#preview').html(html);
                console.log(file.name);
                done();
                myDropzone = this;
                var _this = this;
                _this.removeAllFiles();
            }
        }
    });
	
	/*datetimepicker*/
    $('.datepicker').datetimepicker({
        format: "<?php echo getDatetimepicker(); ?>",
		autoclose:1,
    });



	$('body').on('change','#selectjobcard',function(){
		
		var jobcard = $(this).val();		
		var url=$(this).attr('url');
		
		$.ajax({
			type: 'GET',
			url: url,
			data : {jobcard:jobcard},
			success: function (data)
			{	
				var gaterecord = jQuery.parseJSON(data);
							
				$('#customer').attr('value',gaterecord.name);
				$('#lastname').attr('value',gaterecord.lastname);
				$('#email').attr('value',gaterecord.email);
				$('#mobile').attr('value',gaterecord.mobile_no);
				$('#vehicle').attr('value',gaterecord.modelname);
				$('#veh_type').attr('value',gaterecord.vehicle_type);
				$('#chassis').attr('value',gaterecord.chassisno);
				$('#kms').attr('value',gaterecord.kms_run);
			}
		});
	});


	/*If date field have value then error msg and has error class should remove*/
	$('body').on('change','.gatepassOutdate',function(){

		var outDateValue = $(this).val();

		if (outDateValue != null) {
			$('#outdate_gatepass-error').css({"display":"none"});
		}

		if (outDateValue != null) {
			$(this).parent().parent().removeClass('has-error');
		}
	});


	$(".imageclass").click(function(){
        $(".classimage").empty();
    });

	function preview_images() 
	{
	 	var total_file=document.getElementById("images").files.length;
	 
	 	for(var i=0;i<total_file;i++)
	 	{			 
	  		$('#image_preview').append("<div class='col-md-3 col-sm-3 col-xs-12' style='padding:5px;'><img class='uploadImage' src='"+URL.createObjectURL(event.target.files[i])+"' width='100px' height='60px'> </div>");
	 	}
	}
	

	/*new image append*/
	$("#add_new_images").click(function()
	{
		var image_id = $("#tab_images > tbody > tr").length;		
		var url = $(this).attr('url');
		var msg43 = "{{ trans('app.An error occurred :')}}";

		$.ajax({
            type: 'GET',
            url: url,
            data : {image_id:image_id},
            success: function (response)
            {
            	$("#tab_images > tbody").append(response);
            	return false;
            },
            error: function(e) {
            	alert(msg43 + " " + e.responseText);
            	console.log(e);
            }
       	});
	});


	$('body').on('click','.delete_image',function()
	{
	
		var delete_image = $(this).attr('imgaeid');
		var url = $(this).attr('delete_image');
          
		$.ajax({
			type: 'GET',
			url: url,
			data : {delete_image:delete_image},
			success: function (response)
			{	
				$('div#image_preview div#image_remove_'+delete_image).remove();
			},
			error: function(e) {
				alert(msg100 + " " + e.responseText);
				console.log(e);
			}
       	});
		return false;
	});

});
</script>

<!-- Form field validation -->
{!! JsValidator::formRequest('App\Http\Requests\StoreGatepassAddEditFormRequest', '#demo-form2'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>

@endsection