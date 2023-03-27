@extends('layouts.app')
@section('content')
<style type='text/css'>
  .ui-datepicker-calendar,.ui-datepicker-month { display: none; }​
</style>
<?php Session::put('pre_vehicle_image',''); ?>
<!-- page content -->
	<div class="right_col" role="main">
		<div class="page-title">
			<div class="nav_menu">
				<nav>
					<div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp; {{ trans('app.Vehicle')}}</span></a>
					</div>
					 @include('dashboard.profile')
				</nav>
			</div>
		</div>
		<div class="x_content">
			<ul class="nav nav-tabs bar_tabs" role="tablist">
				@can('vehicle_view')
					<li role="presentation" class=""><a href="{!! url('/vehicle/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i>{{ trans('app.Vehicle List')}}</a></li>
				@endcan

				@can('vehicle_add')
					<li role="presentation" class="active"><a href="{!! url('/vehicle/registration')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i><b>{{ trans('Customer Registration')}}</b></a></li>
				@endcan
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_content">
						<form id="vehicleAdd-Form" action="{{ url('/vehicle/store') }}" method="post" enctype="multipart/form-data"  class="form-horizontal upperform vehicleAddForm">
							<input type="hidden" name="_token" value="{{csrf_token()}}">

							<div class="form-group" style="margin-top:20px;">
								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Number Plate')}} <label class="color-danger">*</label></label>
									<div class="col-md-2 col-sm-2 col-xs-12">
										<select class="form-control select_number_plate" name="number_plate"
										 vehicalnumberurl="{!! url('/vehicle/vehicalnumberplate') !!}" required>
											<option value="">{{ trans('app.Number Plate')}}</option>
										 @if(!empty($vehical_number))
											@foreach($vehical_number as $vehicalnumber)
												<option value="{{$vehicalnumber->number_plate}}">{{ $vehicalnumber->number_plate }}</option>
											@endforeach
										@endif
									    </select>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-12 addremove">
										<button type="button" class="btn btn-default" data-target="#responsive-modal-vehi-plate-number" data-toggle="modal">{{ trans('app.Add Or Remove')}}</button>
									</div>
								</div>

								<div class="my-form-group">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Customer Name')}} <label class="color-danger">*</label></label>
											<div class="col-md-3 col-sm-3 col-xs-12">
												<select name="Customername" id="sup_id" class="form-control select_vhi select_customer_auto_search" cus_url = "{!! url('service/get_vehi_name') !!}" required>
												<option value="">{{ trans('app.Select Customer')}}</option>
												@if(!empty($customer))
													@foreach($customer as $customers)
													<option value="{{$customers->id}}" >{{ getCustomerName($customers->id)}}</option>
													@endforeach
												@endif
												</select>
											</div>
											<div class="col-md-1 col-sm-1 col-xs-12 addremove customerAddRemove">
												<button type="button" data-toggle="modal"     data-target="#mymodal" class="btn btn-default openmodel">{{ trans('app.Add')}}</button>
											</div>
										</div>
							</div>

							<div class="form-group" style="margin-top:20px;">
								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Vehicle Type')}} <label class="color-danger">*</label></label>
									<div class="col-md-2 col-sm-2 col-xs-12">
										 <select class="form-control select_vehicaltype" name="vehical_id"
										 vehicalurl="{!! url('/vehicle/vehicaltypefrombrand') !!}" required>
											<option value="">{{ trans('app.Select Vehicle Type')}}</option>
										 @if(!empty($vehical_type))
											@foreach($vehical_type as $vehical_types)
												<option value="{{ $vehical_types->id }}">{{ $vehical_types->vehicle_type }}</option>
											@endforeach
										@endif
									    </select>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-12 addremove">
										<button type="button" class="btn btn-default" data-target="#responsive-modal" data-toggle="modal">{{ trans('app.Add Or Remove')}}</button>
									</div>
								</div>

								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Chasic No')}} <label class="color-danger"></label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="chasicno"  value="{{ old('chasicno') }}" placeholder="{{ trans('app.Enter ChasicNo')}}" maxlength="30" class="form-control chassis_no">
									</div>
								</div>
							</div>

						    <div class="form-group">
								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Vehicle Brand')}} <label class="color-danger">*</label></label>
									<div class="col-md-2 col-sm-2 col-xs-12">
										<select class="form-control   select_vehicalbrand" name="vehicabrand" >
											<option value="">Select Vehical Brand</option>
										 </select>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-12 addremove">
										<button type="button" class="btn btn-default" data-target="#responsive-modal-brand" data-toggle="modal">{{ trans('app.Add Or Remove')}}</button>
									</div>
								</div>

								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Model Years')}} <label class="color-danger"></label></label>
									<div class="col-md-4 col-sm-4 col-xs-12 input-group date" id="myDatepicker2">
										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
										<input type="text" id="modelyear" name="modelyear" autocomplete="off"  class="form-control"/>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Fuel Type')}} <label class="color-danger">*</label></label>
									<div class="col-md-2 col-sm-2 col-xs-12">
										<select class="form-control select_fueltype" id="fueltype" name="fueltype" required >
											<option value="">{{ trans('app.Select fuel type')}} </option>
												@if(!empty($fuel_type))
													@foreach($fuel_type as $fuel_types)
														<option value="{{ $fuel_types->id }}">{{ $fuel_types->fuel_type }}</option>
													@endforeach
												@endif
										</select>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-12 addremove">
										<button type="button" class="btn btn-default" data-target="#responsive-modal-fuel" data-toggle="modal">{{ trans('app.Add Or Remove')}}</button>
									</div>
								</div>

								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.No of Grear')}} <label class="text-danger"></label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text" id="gearno" name="gearno"  value="{{ old('gearno') }}" placeholder="{{ trans('app.Enter No of Gear')}}" maxlength="5" class="form-control no_of_gear">
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Model Name')}} <label class="color-danger">*</label></label>
									<div class="col-md-2 col-sm-2 col-xs-12">
										<select class="form-control model_addname" name="modelname" required>
											<option value="">{{ trans('app.Select Model Name')}}</option>
										@if(!empty($model_name))
											@foreach ($model_name as $model_names)
											<option value="{{ $model_names->model_name }}">{{ $model_names->model_name }}</option>
											@endforeach
										@endif
										</select>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-12 addremove">
										<button type="button" class="btn btn-default" data-target="#responsive-modal-vehi-model" data-toggle="modal">{{ trans('app.Add Or Remove')}}</button>
									</div>
								</div>

								<div class="{{ $errors->has('price') ? ' has-error' : '' }} my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">
									{{ trans('app.Price' )}} (<?php echo getCurrencySymbols(); ?>) <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="price"  value="{{ old('price') }}" placeholder="{{ trans('app.Enter Price')}}" class="form-control price_is" maxlength="10" required>
										<!-- @if ($errors->has('price'))
										   <span class="help-block">
											   <strong>{{ $errors->first('price') }}</strong>
										   </span>
										@endif -->
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="{{ $errors->has('odometerreading') ? ' has-error' : '' }}">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Odometer Reading')}} <label class="text-danger"></label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="odometerreading"  value="{{ old('odometerreading') }}" placeholder="{{ trans('app.Enter Odometer Reading')}}" maxlength="20"  class="form-control odometer_read">
									</div>
								</div>

								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Date Of Manufacturing')}} <label class="text-danger"></label></label>
									<div class="col-md-4 col-sm-4 col-xs-12 input-group date datepicker">
										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
										<input type="text" id="dom" name="dom" autocomplete="off" class="form-control" placeholder="<?php echo getDatepicker();?>" onkeypress="return false;" />
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Gear Box')}} <label class="text-danger"></label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="gearbox"  value="{{ old('gearbox') }}" placeholder="{{ trans('app.Enter Grear Box')}}" maxlength="30" class="form-control gear_box">
									</div>
								</div>

								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Gear Box No')}}</label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="gearboxno"  value="{{ old('gearboxno') }}" placeholder="{{ trans('app.Enter Gearbox No')}}" maxlength="30" class="form-control gear_box_no">
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Engine No')}} <label class="text-danger"></label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="engineno"  value="{{ old('engineno') }}" placeholder="{{ trans('app.Enter Engine No')}}" maxlength="30" class="form-control engine_no">
									</div>
								</div>

								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Engine Size')}} <label class="text-danger"></label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="enginesize"  value="{{ old('enginesize') }}" placeholder="{{ trans('app.Enter Engine Size')}}" maxlength="30" class="form-control engine_size">
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Key No')}} <label class="text-danger"></label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="keyno"  value="{{ old('keyno') }}" placeholder="{{ trans('app.Enter Key No')}}" maxlength="30" class="form-control key_no">
									</div>
								</div>
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Engine')}} <label class="text-danger"></label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="engine"  value="{{ old('engine') }}" placeholder="{{ trans('app.Enter Engine')}}" maxlength="30" class="form-control engineField">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="my-form-group">
	                              	<label class="control-label col-md-2 col-sm-2 col-xs-12" for="branch">{{ trans('app.Branch')}} <label class="color-danger">*</label></label>

	                              	<div class="col-md-4 col-sm-4 col-xs-12">
	                                	<select class="form-control  select_branch" name="branch">
	                                  	@foreach ($branchDatas as $branchData)
	                                    	<option value="{{ $branchData->id }}">{{$branchData->branch_name }}</option>
	                                  	@endforeach
	                                	</select>
	                              	</div>
                            	</div>
							</div>
							<div class=" col-md-12 col-sm-12 col-xs-12 form-group" style="padding:5px 0px 5px 0px">
							</div>
							<div class="form-group">

							<!-- Vehical images  -->
									<div class="col-md-6 col-sm-12 col-xs-12 form-group  my-form-group">
										<div class="col-md-6 col-sm-6 col-xs-6">
											<h2>{{ trans('app.Vehicle Description')}} </h2>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6" style="padding-bottom: 33px;">
											<button type="button" id="add_new_description" class="btn btn-default newadd" url="{!! url('vehicle/add/getDescription')!!}">{{ trans('app.Add New')}}
											</button>
										</div>
										<div class="form-group col-md-12 col-sm-12 col-xs-12">
											<table class="table table-bordered addtaxtype"  id="tab_decription_detail" align="center">
												<thead>
													<tr>
														<th class="all">{{ trans('app.Description')}}</th>
														<th class="all">{{ trans('app.Action')}}</th>
													</tr>
												</thead>
												<tbody id="tab_decription_info">
													<tr id="row_id_1">
														<td>
															<textarea name="description[]" class="form-control" maxlength="100" id="tax_1" ></textarea>
														</td>
														<td>
															<span class="" data-id="1"><i class="fa fa-trash"></i> {{ trans('app.Delete')}}</span>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>

						<!--vehicle color-->
								<div class="col-md-6 col-sm-12 col-xs-12 form-group ">
									<div class="col-md-6 col-sm-6 col-xs-6" style="padding-left:0px;">
										<h2>{{ trans('app.Vehicle Color')}} </h2></span>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-6" style="padding-bottom: 33px;">
										<button type="button" id="add_new_color" class="btn btn-default newadd" url="{!! url('vehicle/add/getcolor')!!}">{{ trans('app.Add New')}}
										</button>
									</div>
									<div class="form-group col-md-12 col-sm-12 col-xs-12" style="padding-bottom:5px">
										<table class="table table-bordered addtaxtype"  id="tab_color" align="center">
											<thead>
												<tr>
													<th class="all">{{ trans('app.Colors')}}</th>
													<th>{{ trans('app.Action')}}</th>
												</tr>
											</thead>
											<tbody id="color_tbody">
												<tr id="color_id_1">
													<td>
														<select name="color[]" class="form-control color" id="tax_1" data-id="1">
															<option value="">{{ trans('app.Select Color')}}</option>
															@if(!empty($color))
																@foreach($color as $colors)
																	<option value="{{ $colors->id }}">{{ $colors->color }}</option>
																@endforeach
															@endif
														</select>
													</td>
													<td>
														<span class="" data-id="1"><i class="fa fa-trash"></i> {{ trans('app.Delete')}}</span>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div class="form-group">

							<!-- Vehicle Description  -->
							<div class="col-md-6 col-sm-12 col-xs-12 form-group">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<h2>{{ trans('app.Vehicle Images')}} (Pre Service)</h2>
											<span> <h5 style="margin-left: 10px;"> {{ trans('app.Select Multiple Images')}} </h5> </span>
									</div>
										<div class="form-group col-md-10 col-sm-12 col-xs-12">
											<!-- <input type="file"  name="image[]"  class="form-control imageclass" id="images" onchange="preview_images();"  data-max-file-size="5M" multiple />-->
											<div class="col-md-2 col-sm-2 col-xs-12 addremove">
												<button type="button" class="btn btn-default" data-target="#responsive-modal-images-model" data-toggle="modal"> Choose Files</button>
											</div>
										</div>
										<div class="row classimage" id="image_preview"></div>

								</div>							
									
							</div>

					<!-- Start Custom Field, (If register in Custom Field Module)  -->
							@if(!empty($tbl_custom_fields))
								<div class="col-md-12 col-xs-12 col-sm-12 space">
									<h4><b>{{ trans('app.Custom Fields')}}</b></h4>
									<p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
								</div>
								<?php
									$subDivCount = 0;
								?>
								@foreach($tbl_custom_fields as $myCounts => $tbl_custom_field)
									<?php
										if($tbl_custom_field->required == 'yes')
										{
											$required="required";
											$red="*";
										}else{
											$required="";
											$red="";
										}

										$subDivCount++;
									?>

									@if($myCounts%2 == 0)
										<div class="col-md-12 col-sm-6 col-xs-12">
									@endif

									<div class="form-group col-md-6 col-sm-6 col-xs-12 error_customfield_main_div_{{$myCounts}}">

										<label class="control-label col-md-4 col-sm-4 col-xs-12" for="account-no">{{$tbl_custom_field->label}} <label class="color-danger">{{$red}}</label></label>
										<div class="col-md-8 col-sm-8 col-xs-12">
										@if($tbl_custom_field->type == 'textarea')
											<textarea  name="custom[{{$tbl_custom_field->id}}]" class="form-control textarea_{{$tbl_custom_field->id}} textarea_simple_class common_simple_class common_value_is_{{$myCounts}}" placeholder="{{ trans('app.Enter')}} {{$tbl_custom_field->label}}" maxlength="100" isRequire="{{$required}}" type="textarea" fieldNameIs="{{ $tbl_custom_field->label }}" rows_id="{{$myCounts}}" {{$required}}></textarea>

											<span id="common_error_span_{{$myCounts}}" class="help-block error-help-block color-danger" style="display: none"></span>
										@elseif($tbl_custom_field->type == 'radio')

											<?php
												$radioLabelArrayList = getRadiolabelsList($tbl_custom_field->id)
											?>
											@if(!empty($radioLabelArrayList))
												<div style="margin-top: 5px;">
												@foreach($radioLabelArrayList as $k => $val)
													<input type="{{$tbl_custom_field->type}}"  name="custom[{{$tbl_custom_field->id}}]" value="{{$k}}" <?php if($k == 0) {echo "checked"; } ?>>{{$val}} &nbsp;
												@endforeach
												</div>
											@endif
										@elseif($tbl_custom_field->type == 'checkbox')

											<?php
												$checkboxLabelArrayList = getCheckboxLabelsList($tbl_custom_field->id);
												$cnt = 0;
											?>

											@if(!empty($checkboxLabelArrayList))
												<div class="required_checkbox_parent_div_{{$tbl_custom_field->id}}" style="margin-top: 5px;">
												@foreach($checkboxLabelArrayList as $k => $val)
													<input type="{{$tbl_custom_field->type}}" name="custom[{{$tbl_custom_field->id}}][]" value="{{$val}}" isRequire="{{$required}}" fieldNameIs="{{ $tbl_custom_field->label }}" custm_isd="{{$tbl_custom_field->id}}" class="checkbox_{{$tbl_custom_field->id}} required_checkbox_{{$tbl_custom_field->id}} checkbox_simple_class common_value_is_{{$myCounts}} common_simple_class" rows_id="{{$myCounts}}" > {{ $val }} &nbsp;
												<?php $cnt++; ?>
												@endforeach
												<span id="common_error_span_{{$myCounts}}" class="help-block error-help-block color-danger" style="display: none"></span>
												</div>
												<input type="hidden" name="checkboxCount" value="{{$cnt}}">
											@endif
										@elseif($tbl_custom_field->type == 'textbox')
											<input type="{{$tbl_custom_field->type}}"  name="custom[{{$tbl_custom_field->id}}]"  class="form-control textDate_{{$tbl_custom_field->id}} textdate_simple_class common_value_is_{{$myCounts}} common_simple_class" placeholder="{{ trans('app.Enter')}} {{$tbl_custom_field->label}}" maxlength="30" isRequire="{{$required}}" fieldNameIs="{{ $tbl_custom_field->label }}" rows_id="{{$myCounts}}" {{ $required }}>

											<span id="common_error_span_{{$myCounts}}" class="help-block error-help-block color-danger" style="display:none"></span>
										@elseif($tbl_custom_field->type == 'date')
											<input type="{{$tbl_custom_field->type}}"  name="custom[{{$tbl_custom_field->id}}]"  class="form-control textDate_{{$tbl_custom_field->id}} date_simple_class common_value_is_{{$myCounts}} common_simple_class" placeholder="{{ trans('app.Enter')}} {{$tbl_custom_field->label}}" maxlength="30" isRequire="{{$required}}" fieldNameIs="{{ $tbl_custom_field->label }}" rows_id="{{$myCounts}}" {{ $required }} onkeydown="return false">

											<span id="common_error_span_{{$myCounts}}" class="help-block error-help-block color-danger" style="display:none"></span>

										@endif

										</div>
									</div>
									@if($myCounts%2 != 0)
										</div>
									@endif
								@endforeach
								<?php
									if ($subDivCount%2 != 0) {
										echo "</div>";
									}
								?>
							@endif
						<!-- End Custom Field -->

							<div class="form-group col-md-12 col-sm-12 col-xs-12">
								<div class="col-md-12 col-sm-12 col-xs-12 text-center">
									<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
									<button type="submit" class="btn btn-success vehicleAddSubmitButton">{{ trans('app.Submit')}}</button>
								</div>
							</div>
						</form>
					</div>

		   <!-- Vehicle Type  -->
					<div class="col-md-6">
						<div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
										<h4 class="modal-title"> {{ trans('app.Add Vehicle Type')}}</h4>
									</div>
									<div class="modal-body">
									    <form name="" class="form-horizontal formaction" action="" method="">
											<table class="table vehical_type_class"  align="center" style="width:40em">
												<thead>
													<tr>
														<td class="text-center"><strong>{{ trans('app.Vehicle Type')}}</strong></td>
														<td class="text-center"><strong>{{ trans('app.Action')}}</strong></td>
													</tr>
												</thead>
												<tbody>
													@if(!empty($vehical_type))
													@foreach ($vehical_type as $vehical_types)
													<tr class="del-{{ $vehical_types->id }}">
														<td class="text-center ">{{ $vehical_types->vehicle_type }}</td>
														<td class="text-center">
															<button type="button" vehicletypeid="{{ $vehical_types->id }}"
															deletevehical="{!! url('/vehicle/vehicaltypedelete') !!}" class="btn btn-danger btn-xs deletevehicletype">X</button>
														</td>
													</tr>
													@endforeach
													@endif
												</tbody>
											</table>
											<div class="col-md-8 form-group data_popup">
												<label>{{ trans('app.Vehicle Type:')}} <span class="color-danger">*</span></label>
												<input type="text" class="form-control vehical_type" name="vehical_type" id="vehical_type" placeholder="{{ trans('app.Enter Vehicle Type')}}" maxlength="20" required />
											</div>
											<div class="col-md-4 form-group data_popup" style="margin-top:24px;">

												<button type="button" class="btn btn-success vehicaltypeadd" id="vehicleTypeSubmit"
												url="{!! url('/vehicle/vehicle_type_add') !!}" >{{ trans('app.Submit')}}</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				<!-- End  Vehicle Type  -->

				<!-- Vehicle Brand -->
					<div class="col-md-6">
						<div id="responsive-modal-brand" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
										<h4 class="modal-title">{{ trans('app.Add Vehicle Brand')}}</h4>
									</div>
									<div class="modal-body">
									    <form class="form-horizontal" action="" method="">
											<table class="table vehical_brand_class"  align="center" style="width:40em">
												<thead>
													<tr>
														<td class="text-center"><strong>{{ trans('app.Vehicle Brand')}}</strong></td>
														<td class="text-center"><strong>{{ trans('app.Action')}}</strong></td>
													</tr>
												</thead>
												<tbody>
													@if(!empty($vehical_brand))
													@foreach ($vehical_brand as $vehical_brands)
													<tr class="del-{{ $vehical_brands->id}}" >
													<td class="text-center ">{{ $vehical_brands->vehicle_brand }}</td>
													<td class="text-center">

													<button type="button" brandid="{{ $vehical_brands->id }}"
													deletevehicalbrand="{!! url('/vehicle/vehicalbranddelete') !!}" class="btn btn-danger btn-xs deletevehiclebrands">X</button>
													</td>
													</tr>
													@endforeach
													@endif
												</tbody>
											</table>
											<div class="col-md-8 form-group data_popup">
												<label>{{ trans('app.Vehicle Type:')}} <span class="color-danger">*</span></label>
												<select class="form-control  vehical_id" name="vehical_id" id="vehicleTypeSelect" vehicalurl="{!! url('/vehicle/vehicalformtype') !!}" required >
													<option>{{ trans('app.Select Vehicle Type')}}</option>
														 @if(!empty($vehical_type))
															@foreach($vehical_type as $vehical_types)
																<option value="{{ $vehical_types->id }}">{{ $vehical_types->vehicle_type }}</option>
															@endforeach
														@endif
												</select>
											</div>
											<div class="col-md-8 form-group data_popup">
												<label>{{ trans('app.Vehicle Brand:')}} <span class="color-danger">*</span></label>
												<input type="text" class="form-control vehical_brand" name="vehical_brand" id="vehical_brand" placeholder="{{ trans('app.Enter Vehicle brand')}}" maxlength="25" required />
											</div>
											<div class="col-md-4 form-group data_popup" style="margin-top:24px;">

												<button type="button" class="btn btn-success vehicalbrandadd "
												   vehiclebrandurl="{!! url('/vehicle/vehicle_brand_add') !!}">{{ trans('app.Submit')}}</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				<!-- End Vehicle Brand -->

				<!-- Fuel Type -->
					<div class="col-md-6">
						<div id="responsive-modal-fuel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
										<h4 class="modal-title">{{ trans('app.Add Fuel Type')}}</h4>
									</div>
									<div class="modal-body">
									    <form class="form-horizontal" action="" method="post">
											<table class="table fuel_type_class"  align="center" style="width:40em">
												<thead>
													<tr>
														<td class="text-center"><strong>{{ trans('app.Fuel Type')}}</strong></td>
														<td class="text-center"><strong>{{ trans('app.Action')}}</strong></td>
													</tr>
												</thead>
												<tbody>
													@if(!empty($fuel_type))
													@foreach ($fuel_type as $fuel_types)
													<tr class="del-{{ $fuel_types->id }} data_of_type" >
													<td class="text-center ">{{ $fuel_types->fuel_type }}</td>
													<td class="text-center">

													<button type="button" fuelid="{{ $fuel_types->id }}"
													deletefuel="{!! url('/vehicle/fueltypedelete') !!}" class="btn btn-danger btn-xs fueldeletes">X</button>
													</td>
													</tr>
													@endforeach
													@endif
												</tbody>
											</table>
											<div class="col-md-8 form-group data_popup">
												<label>{{ trans('app.Fuel Type:')}} <span class="color-danger">*</span></label>
												<input type="text" class="form-control fuel_type" name="fuel_type" id="fuel_type" placeholder="{{ trans('app.Enter Fuel Type')}}" maxlength="20" required />
											</div>
											<div class="col-md-4 form-group data_popup" style="margin-top:24px;">

												<button type="button" class="btn btn-success fueltypeadd"
												fuelurl="{!! url('/vehicle/vehicle_fuel_add') !!}">{{ trans('app.Submit')}}</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				<!-- end Fuel Type -->

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
									<form method="post" action="{{url('/vehicle/vehicle_images')}}" enctype="multipart/form-data" class="dropzone" id="dropzoneFrom">
										@csrf
									</form>   
									</div>
								</div>
							</div>
						</div>
					</div>
				<!-- End Images Upload -->
				
				<!-- Model Name -->
					<div class="col-md-6">
						<div id="responsive-modal-vehi-model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
										<h4 class="modal-title">{{ trans('app.Add Model Name')}}</h4>
									</div>
									<div class="modal-body">
										<form class="form-horizontal" action="" method="post">
											<table class="table vehi_model_class"  align="center" style="width:40em">
												<thead>
													<tr>
														<td class="text-center"><strong>{{ trans('app.Model Name')}}</strong></td>
														<td class="text-center"><strong>{{ trans('app.Action')}}</strong></td>
													</tr>
												</thead>
												<tbody>

													@if(!empty($model_name))
													@foreach ($model_name as $model_names)
													<tr class="mod-{{ $model_names->id }}" >
													<td class="text-center ">{{ $model_names->model_name }}</td>
													<td class="text-center">

													<button type="button" modelid="{{ $model_names->id }}"
													deletemodel="{!! url('/vehicle/vehicle_model_delete') !!}" class="btn btn-danger btn-xs modeldeletes">X</button>
													</td>
													</tr>
													@endforeach
													@endif
												</tbody>
											</table>
											<div class="col-md-8 form-group data_popup">
												<label>{{ trans('app.Model Name :')}} <span class="color-danger">*</span></label>
												<input type="text" class="form-control vehi_modal_name" name="model_name" id="model_name" placeholder="{{ trans('app.Enter Model Name')}}" maxlength="20" required />
											</div>
											<div class="col-md-4 form-group data_popup" style="margin-top:24px;">

												<button type="button" class="btn btn-success vehi_model_add"
												modelurl="{!! url('/vehicle/vehicle_model_add') !!}">{{ trans('app.Submit')}}</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				<!-- End Model Name -->

				<!-- Model Name Plate-->
					<div class="col-md-6">
						<div id="responsive-modal-vehi-plate-number" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
										<h4 class="modal-title">{{ trans('app.Number Plate')}}</h4>
									</div>
									<div class="modal-body">
										<form class="form-horizontal" action="" method="post">

											<div class="col-md-8 form-group data_popup">
												<label>Add Number Plate<span class="color-danger">*</span></label>
												<input type="text" class="form-control vehicle_plate_number" name="vehicle_number_plate" id="vehicle_number_plate" placeholder="{{ trans('app.Enter Number Plate')}}" maxlength="20" required />
											</div>
											<div class="col-md-4 form-group data_popup" style="margin-top:24px;">

												<button type="button" class="btn btn-success vehi_number_add"
												modelurl="{!! url('/vehicle/vehicle_number_plate_add') !!}">{{ trans('app.Submit')}}</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				<!-- End Model Plate -->
				<!--customer add model -->
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="exampleModalLabel">Customer Details</h4>
							</div>
							<div class="row massage hide addcustomermsg">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="checkbox checkbox-success checkbox-circle">
										<label for="checkbox-10 colo_success"> {{trans('app.Successfully Submitted')}}  </label>
									</div>
								</div>
							</div>

							<div class="modal-body">
								<div class="x_content">
									<form id="formcustomer" action="" method="POST" name="formcustomer" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left input_mask">

										<div class="col-md-12 col-xs-12 col-sm-12 space">
											<h4><b>{{ trans('app.Personal Information')}}</b></h4>
											<p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
										</div>

										<div class="col-md-6 col-sm-6 col-xs-12 form-group">
											<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">{{ trans('app.First Name') }} <label class="color-danger">*</label> </label>
											<div class="col-md-8 col-sm-8 col-xs-12">
											<input type="text" id="firstname" name="firstname"  class="form-control"
											value="{{ old('firstname') }}" placeholder="{{ trans('app.Enter First Name')}}" maxlength="25"  required />
											<span class="color-danger" id="errorlfirstname"></span>
											</div>
										</div>

										<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('lastname') ? ' has-error' : '' }}">
											<label class="control-label col-md-4 col-sm-4 col-xs-12" for="last-name">{{ trans('app.Last Name') }} <label class="color-danger">*</label></label>
											<div class="col-md-8 col-sm-8 col-xs-12">
												<input type="text" id="lastname" name="lastname" placeholder="{{ trans('app.Enter Last Name')}}" value="{{ old('lastname') }}" maxlength="25"
												class="form-control" required>
												<span class="color-danger" id="errorllastname"></span>
											</div>
										</div>

										<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('displayname') ? ' has-error' : '' }} ">
											<label class="control-label col-md-4 col-sm-4 col-xs-12" for="display-name">{{ trans('app.Display Name')}}</label>
											<div class="col-md-8 col-sm-8 col-xs-12">
												<input type="text" id="displayname" name="displayname" placeholder="{{ trans('app.Enter Display Name')}}" value="{{ old('displayname') }}" class="form-control" maxlength="25">
												<span class="color-danger" id="errorldisplayname"></span>
											</div>
										</div>

										<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('company_name') ? ' has-error' : '' }} ">
											<label class="control-label col-md-4 col-sm-4 col-xs-12" for="display-name">{{ trans('app.Company Name')}}</label>
											<div class="col-md-8 col-sm-8 col-xs-12">
												<input type="text" id="company_name" name="company_name" placeholder="{{ trans('app.Enter Company Name')}}" value="{{ old('company_name') }}" class="form-control" maxlength="25">
												<span class="color-danger" id="errorlcompanyName"></span>
											</div>
										</div>

										<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
											<label class="control-label col-md-4 col-sm-4 col-xs-12"> {{ trans('app.Gender')}} <label class="color-danger">*</label></label>
											<div class="col-md-8 col-sm-8 col-xs-12 gender">
												<input type="radio" class="gender" name="gender" value="0" checked>{{ trans('app.Male')}}
												<input type="radio" class="gender" name="gender" value="1" > {{ trans('app.Female')}}

											</div>
										</div>

										<div class="col-md-6 col-sm-6 col-xs-12 form-group {{ $errors->has('dob') ? ' has-error' : '' }}">
											<label class="control-label col-md-4 col-sm-4 col-xs-12">{{ trans('app.Date Of Birth')}}</label>
											<div class="col-md-8 col-sm-8 col-xs-12 input-group date datepickercustmore">
												<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
												<input type="text" id="datepicker" autocomplete="off" class="form-control" placeholder="<?php echo getDatepicker();?>"  name="dob" value="{{ old('dob') }}" onkeypress="return false;" />
											</div>
											<span class="color-danger" id="errorldatepicker"></span>
										</div>

										<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
											<label class="control-label col-md-4 col-sm-4 col-xs-12" for="Email">{{ trans('app.Email') }} <label class="color-danger">*</label></label>
											<div class="col-md-8 col-sm-8 col-xs-12">
												<input type="text" id="email" name="email" placeholder="{{ trans('app.Enter Email')}}" value="{{ old('email') }}" class="form-control" maxlength="50" required>
												<span class="color-danger" id="errorlemail"></span>
											</div>
										</div>

										<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
											<label class="control-label col-md-4 col-sm-4 col-xs-12" for="Password">{{ trans('app.Password') }} <label class="color-danger">*</label></label>
											<div class="col-md-8 col-sm-8 col-xs-12">
												<input type="password" id="password" name="password" placeholder="{{ trans('app.Enter Password')}}" class="form-control col-md-7 col-xs-12" maxlength="20" required>
												<span class="color-danger" id="errorlpassword"></span>
											</div>
										</div>

										<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
											<label class="control-label col-md-4 col-sm-4 col-xs-12 currency" style="padding-right: 0px;"for="Password">{{ trans('app.Confirm Password') }} <label class="color-danger">*</label></label>
											<div class="col-md-8 col-sm-8 col-xs-12">
												<input type="password" id="password_confirmation"  name="password_confirmation" placeholder="{{ trans('app.Enter Confirm Password')}}" class="form-control col-md-7 col-xs-12" maxlength="20" required>
												<span class="color-danger" id="errorlpassword_confirmation"></span>
											</div>
										</div>

										<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('mobile') ? ' has-error' : '' }}">
											<label class="control-label col-md-4 col-sm-4 col-xs-12" for="mobile">{{ trans('app.Mobile No') }} <label class="color-danger" >*</label></label>
											<div class="col-md-8 col-sm-8 col-xs-12">
												<input type="text" id="mobile" name="mobile" placeholder="{{ trans('app.Enter Mobile No')}}" value="{{ old('mobile') }}" class="form-control" maxlength="16" minlength="6" required >
												<span class="color-danger" id="errorlmobile"></span>
											</div>
										</div>

										<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('landlineno') ? ' has-error' : '' }}">
											<label class="control-label col-md-4 col-sm-4 col-xs-12" for="landline-no">{{ trans('app.Landline No') }} </label>
											<div class="col-md-8 col-sm-8 col-xs-12">
												<input type="text" id="landlineno" name="landlineno" placeholder="{{ trans('app.Enter LandLine No')}}"  value="{{ old('landlineno') }}" class="form-control">
												<span class="color-danger" id="errorllandlineno"></span>
											</div>
										</div>

										<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
											<label class="control-label col-md-4 col-sm-4 col-xs-12" for="image">
											{{ trans('app.Image')}} </label>
											<div class="col-md-8 col-sm-8 col-xs-12">
												<input type="file" id="image" name="image" value="{{ old('image') }}" class="form-control " >
											</div>
										</div>

										<div class="col-md-12 col-xs-12 col-sm-12 space">
										<h4><b>{{ trans('app.Address')}}</b></h4>
										<p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
										</div>

										<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
											<label class="control-label col-md-4 col-sm-4 col-xs-12" for="Country">{{ trans('app.Country')}} <label class="color-danger">*</label></label>
											<div class="col-md-8 col-sm-8 col-xs-12">
											<select class="form-control  select_country" id="country_id" name="country_id" countryurl="{!! url('/getstatefromcountry') !!}" required>
												<option value="">{{ trans('app.Select Country')}}</option>
													@foreach ($country as $countrys)
													<option value="{{ $countrys->id }}">{{$countrys->name }}</option>
													@endforeach
												</select>
												<span class="color-danger" id="errorlcountry_id"></span>
											</div>
										</div>

										<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
											<label class="control-label col-md-4 col-sm-4 col-xs-12" for="State ">{{ trans('app.State') }} </label>
											<div class="col-md-8 col-sm-8 col-xs-12">
												<select class="form-control  state_of_country" id="state_id" name="state_id"  stateurl="{!! url('/getcityfromstate') !!}">
												</select>
											</div>
										</div>

										<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
											<label class="control-label col-md-4 col-sm-4 col-xs-12" for="Town/City">{{ trans('app.Town/City')}}</label>
											<div class="col-md-8 col-sm-8 col-xs-12">
												<select class="form-control city_of_state" id="city" name="city">
												</select>
											</div>
										</div>

										<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
											<label class="control-label col-md-4 col-sm-4 col-xs-12" for="Address">{{ trans('app.Address') }} <label class="color-danger">*</label></label>
											<div class="col-md-8 col-sm-8 col-xs-12">
											<textarea class="form-control" id="address" name="address" maxlength="100" required>{{ old('address') }}</textarea>
												<span class="color-danger" id="errorladdress"></span>
											</div>
										</div>

										<input type="hidden" name="_token" value="{{ csrf_token()}}">
										<div class="form-group col-md-12 col-sm-12 col-xs-12">
											<div class="col-md-12 col-sm-12 col-xs-12 text-center">
												<a class="btn btn-primary" data-dismiss="modal">{{ trans('app.Cancel')}}</a>
												<button type="submit" class="btn btn-success addcustomer">{{ trans('app.Submit')}}</button>
											</div>
										</div>
									</form>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>

				</div>
			</div>
		</div>
	</div>
<!-- /page content -->


<!-- Scripts starting -->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
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
	
	$('#myDatepicker2').datetimepicker({
       format: "yyyy",
		autoclose: 2,
		minView: 4,
		startView: 4,
    });

    var msg14= "{{ trans('app.Please enter only alphanumeric data')}}";
	var msg15 = "{{ trans('app.Only blank space not allowed')}}";
	var msg16 = "{{ trans('app.This Record is Duplicate')}}";

	/*vehicle type*/
	$('.vehicaltypeadd').click(function(){

	 	var vehical_type= $('.vehical_type').val();
	 	var url = $(this).attr('url');

    	var msg13 = "{{ trans('app.Please enter vehicle type')}}";

    	function define_variable()
		{
			return {
				vehicle_type_value: $('.vehical_type').val(),
				vehicle_type_pattern: /^[a-zA-Z0-9\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s]+$/,
				vehicle_type_pattern2: /^[a-zA-Z0-9\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s]*$/
			};
		}

		var call_var_vehicletypeadd = define_variable();

        if(vehical_type == ""){
            swal(msg13);
        }
        else if (!call_var_vehicletypeadd.vehicle_type_pattern.test(call_var_vehicletypeadd.vehicle_type_value))
		{
			$('.vehical_type').val("");
			swal(msg14);
		}
        else if(!vehical_type.replace(/\s/g, '').length){
			$('.vehical_type').val("");
        	swal(msg15);
        }
        else if (!call_var_vehicletypeadd.vehicle_type_pattern2.test(call_var_vehicletypeadd.vehicle_type_value))
		{
			$('.vehical_type').val("");
			swal(msg34);
		}
        else{
			$.ajax({
				type:'GET',
				url:url,

	   			data :{vehical_type:vehical_type},

	   			//Form submit at a time only one for vehicleTypeAdd
	   			beforeSend : function () {
	 				$(".vehicaltypeadd").prop('disabled', true);
	 			},

	   			success:function(data)
	   			{
		   			var newd = $.trim(data);

		   			var classname = 'del-'+newd;

		   			if (newd == '01')
		   			{
			   			swal(msg16);
		   			}
		   			else
		   			{
		   				$('.vehical_type_class').append('<tr class="'+classname+'"><td class="text-center">'+vehical_type+'</td><td class="text-center"><button type="button" vehicletypeid='+data+' deletevehical="{!! url('/vehicle/vehicaltypedelete') !!}" class="btn btn-danger btn-xs deletevehicletype">X</button></a></td><tr>');

						$('.select_vehicaltype').append('<option value='+data+'>'+vehical_type+'</option>');
						$('.vehical_type').val('');

						$('.vehical_id').append('<option value='+data+'>'+vehical_type+'</option>');
							$('.vehical_type').val('');
			   		}

			   		//Form submit at a time only one for vehicleTypeAdd
			   		$(".vehicaltypeadd").prop('disabled', false);
					return false;
		   		},
	 		});
		}
	});


	var msg1 = "{{ trans('app.Are You Sure?')}}";
    var msg2 = "{{ trans('app.You will not be able to recover this data afterwards!')}}";
    var msg3 = "{{ trans('app.Cancel')}}";
    var msg4 = "{{ trans('app.Yes, delete!')}}";
    var msg5 = "{{ trans('app.Done!')}}";
    var msg6 = "{{ trans('app.It was succesfully deleted!')}}";
    var msg7 = "{{ trans('app.Cancelled')}}";
    var msg8 = "{{ trans('app.Your data is safe')}}";

	/*vehical Type delete*/
	$('body').on('click','.deletevehicletype',function()
	{

		var vtypeid = $(this).attr('vehicletypeid');
		var url = $(this).attr('deletevehical');

		swal({
		    title: msg1,
            text: msg2,
            type: "warning",
            showCancelButton: true,
            cancelButtonText: msg3,
            cancelButtonColor: "#C1C1C1",
            confirmButtonColor: "#297FCA",
            confirmButtonText: msg4,
            closeOnConfirm: false
        },
        function(isConfirm)
        {
			if (isConfirm) {
				$.ajax({
					type:'GET',
					url:url,
					data:{vtypeid:vtypeid},
					success:function(data){
						$('.del-'+vtypeid).remove();
						$(".select_vehicaltype option[value="+vtypeid+"]").remove();
						swal(msg5, msg6,"success");
					}
				});
			}else{
				swal(msg7, msg8, "error");
			}
		})
	});


	/*vehical brand*/
	$('.vehicalbrandadd').click(function()
	{

    	var vehical_id = $('.vehical_id').val();
		var vehical_brand= $('.vehical_brand').val();
		var url = $(this).attr('vehiclebrandurl');

		var msg17 = "{{ trans('app.Please first select vehicle type')}}";
		var msg18 = "{{ trans('app.Please enter vehicle brand')}}";

		function define_variable()
		{
			return {
				vehicle_brand_value: $('.vehical_brand').val(),
				vehicle_brand_pattern: /^[a-zA-Z0-9\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s]+$/,
				vehicle_brand_pattern2: /^[a-zA-Z0-9\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s]*$/
			};
		}

		var call_var_vehiclebrandadd = define_variable();

		if ($("#vehicleTypeSelect")[0].selectedIndex <= 0) {

			swal(msg17);
		}
		else
		{
			if(vehical_brand == ""){
	            swal(msg18);
	        }
	        else if (!call_var_vehiclebrandadd.vehicle_brand_pattern.test(call_var_vehiclebrandadd.vehicle_brand_value))
			{
				$('.vehical_brand').val("");
				swal(msg4);

			}
	        else if(!vehical_brand.replace(/\s/g, '').length){
	       		// var str = "    ";
				$('.vehical_brand').val("");
	        	swal(msg25);
	        }
	        else if (!call_var_vehiclebrandadd.vehicle_brand_pattern2.test(call_var_vehiclebrandadd.vehicle_brand_value))
			{
				$('.vehical_brand').val("");
				swal(msg34);

			}
	        else{
				$.ajax({
			   		type:'GET',
			   		url:url,

			   		data :{vehical_id:vehical_id, vehical_brand:vehical_brand},

			   		//Form submit at a time only one for vehicleBrandAdd
		   			beforeSend : function () {
		 				$(".vehicalbrandadd").prop('disabled', true);
		 			},

			   		success:function(data)
               		{
			       		var newd = $.trim(data);
				   		var classname = 'del-'+newd;

			    		if (newd == "01")
			       		{
			 	     		swal(msg16);
				   		}
				   		else
				   		{
					   		$('.vehical_brand_class').append('<tr class="'+classname+'"><td class="text-center">'+vehical_brand+'</td><td class="text-center"><button type="button" brandid='+data+' deletevehicalbrand="{!! url('vehicle/vehicalbranddelete') !!}" class="btn btn-danger btn-xs deletevehiclebrands">X</button></a></td><tr>');

							$('.select_vehicalbrand').append('<option value='+data+'>'+vehical_brand+'</option>');

							$('.vehical_brand').val('');
						}

						//Form submit at a time only one for vehicleBrandAdd
						$(".vehicalbrandadd").prop('disabled', false);
						return false;
			   		},

		 		});
			}
		}
	});


	/*vehical brand delete*/
	$('body').on('click','.deletevehiclebrands',function()
	{

		var vbrandid = $(this).attr('brandid');
		var url = $(this).attr('deletevehicalbrand');

		swal({
            title: msg1,
            text: msg2,
            type: "warning",
            showCancelButton: true,
            cancelButtonText: msg3,
            cancelButtonColor: "#C1C1C1",
            confirmButtonColor: "#297FCA",
            confirmButtonText: msg4,
            closeOnConfirm: false
        },
        function(isConfirm){
			if (isConfirm) {
				$.ajax({
					type:'GET',
					url:url,
					data:{vbrandid:vbrandid},
					success:function(data){
						$('.del-'+vbrandid).remove();
						$(".select_vehicalbrand option[value="+vbrandid+"]").remove();
						swal(msg5, msg6,"success");
					}
				});
			}else{
				swal(msg7, msg8, "error");
			}
		})
	});


	$('.fueltypeadd').click(function()
	{

	 	var fuel_type = $('.fuel_type').val();
	 	var url = $(this).attr('fuelurl');

	 	var msg21 = "{{ trans('app.Please enter fuel type')}}";

    	function define_variable()
		{
			return {
				vehicle_fuel_value: $('.fuel_type').val(),
				vehicle_fuel_pattern: /^[a-zA-Z0-9\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s]+$/,
				vehicle_fuel_pattern2: /^[a-zA-Z0-9\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s]*$/
			};
		}

		var call_var_vehiclefueladd = define_variable();

        if(fuel_type == ""){
            swal(msg21);
        }
        else if (!call_var_vehiclefueladd.vehicle_fuel_pattern.test(call_var_vehiclefueladd.vehicle_fuel_value))
		{
			$('.fuel_type').val("");
			swal(msg14);

		}
        else if(!fuel_type.replace(/\s/g, '').length){
       		// var str = "    ";
			$('.fuel_type').val("");
        	swal(msg15);
        }
        else if (!call_var_vehiclefueladd.vehicle_fuel_pattern2.test(call_var_vehiclefueladd.vehicle_fuel_value))
		{
			$('.fuel_type').val("");
			swal(msg34);

		}
        else{
			$.ajax({
		   		type:'GET',
		   		url:url,

		   		data :{fuel_type:fuel_type},

		   		//Form submit at a time only one for fuelType
	   			beforeSend : function () {
	 				$(".fueltypeadd").prop('disabled', true);
	 			},

		   		success:function(data)
		   		{
			       var newd = $.trim(data);
				   var classname = 'del-'+newd;

			   		if(newd == '01')
			   		{
				   		swal(msg16);
			   		}
			   		else
			   		{
			    		$('.fuel_type_class').append('<tr class="'+classname+'"><td class="text-center">'+fuel_type+'</td><td class="text-center"><button type="button" fuelid='+data+' deletefuel="{!! url('/vehicle/fueltypedelete') !!}" class="btn btn-danger btn-xs fueldeletes">X</button></a></td><tr>');

							$('.select_fueltype').append('<option value='+data+'>'+fuel_type+'</option>');

							$('.fuel_type').val('');
			   		}

			   		//Form submit at a time only one for fuelType
					$(".fueltypeadd").prop('disabled', false);
					return false;
		   		},

			});
		}
	});


	/*Fuel  Type delete*/
	$('body').on('click','.fueldeletes',function()
	{
		var fueltypeid = $(this).attr('fuelid');
		var url = $(this).attr('deletefuel');

		swal({
            title: msg1,
            text: msg2,
            type: "warning",
            showCancelButton: true,
            cancelButtonText: msg3,
            cancelButtonColor: "#C1C1C1",
            confirmButtonColor: "#297FCA",
            confirmButtonText: msg4,
            closeOnConfirm: false
	    },
	    function(isConfirm){
			if (isConfirm) {
				$.ajax({
					type:'GET',
					url:url,
					data:{fueltypeid:fueltypeid},
					success:function(data)
					{
						$('.del-'+fueltypeid).remove();
						$(".select_fueltype option[value="+fueltypeid+"]").remove();
						swal(msg5, msg6,"success");
					}
				});
			}else{
				swal(msg7, msg8, "error");
			}
		})
	});

    $('.vehi_number_add').click(function(){
		var plate_number = $('.vehicle_plate_number').val();
		console.log(plate_number);
		var model_url = $(this).attr('modelurl');

		var msg9 = "{{ trans('app.Please enter plate number')}}";
		function define_variable()
		{
			return {
				vehicle_plate_number: $('.vehicle_plate_number').val(),
				vehicle_plate_pattern: /^[a-zA-Z0-9\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s]+$/,
				vehicle_plate_pattern2: /^[a-zA-Z0-9\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s]*$/
			};
		}

		var call_var_vehiclenumberladd = define_variable();
		if(plate_number == ""){
        	swal(msg9);
    	}
        else if (!call_var_vehiclenumberladd.vehicle_plate_pattern.test(call_var_vehiclenumberladd.vehicle_plate_number))
		{
			$('.vehicle_plate_number').val("");
			swal(msg14);
		}
        else if(!plate_number.replace(/\s/g, '').length){
			$('.vehicle_plate_number').val("");
        	swal(msg15);
        }
        else if (!call_var_vehiclenumberladd.vehicle_plate_pattern2.test(call_var_vehiclenumberladd.vehicle_plate_number))
		{
			$('.vehicle_plate_number').val("");
			swal(msg34);
		}
		else{
			//$('.vehicle_plate_number').val();
			$('.select_number_plate').append(`<option value="${plate_number}" selected="selected">${plate_number}</option>`);
			$('.vehicle_plate_number').val("");
		}

	});
	/*Add Vehicle Model*/
	$('.vehi_model_add').click(function()
	{
		var model_name = $('.vehi_modal_name').val();
		var model_url = $(this).attr('modelurl');

		var msg9 = "{{ trans('app.Please enter model name')}}";

		function define_variable()
		{
			return {
				vehicle_model_value: $('.vehi_modal_name').val(),
				vehicle_model_pattern: /^[a-zA-Z0-9\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s]+$/,
				vehicle_model_pattern2: /^[a-zA-Z0-9\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s]*$/
			};
		}

		var call_var_vehiclemodeladd = define_variable();

        if(model_name == ""){
        	swal(msg9);
    	}
        else if (!call_var_vehiclemodeladd.vehicle_model_pattern.test(call_var_vehiclemodeladd.vehicle_model_value))
		{
			$('.vehi_modal_name').val("");
			swal(msg14);
		}
        else if(!model_name.replace(/\s/g, '').length){
			$('.vehi_modal_name').val("");
        	swal(msg15);
        }
        else if (!call_var_vehiclemodeladd.vehicle_model_pattern2.test(call_var_vehiclemodeladd.vehicle_model_value))
		{
			$('.vehi_modal_name').val("");
			swal(msg34);
		}
		else{
			$.ajax({
				type:'GET',
				url:model_url,
				data:{model_name:model_name},

				//Form submit at a time only one for addVehicleModel
	   			beforeSend : function () {
	 				$(".vehi_model_add").prop('disabled', true);
	 			},

				success:function(data)
				{
					var newd = $.trim(data);
					var classname = 'mod-'+newd;

					if(newd == '01')
					{
						swal(msg16);
					}
					else
					{
						$('.vehi_model_class').append('<tr class="'+classname+'"><td class="text-center">'+model_name+'</td><td class="text-center"><button type="button" modelid='+data+' deletemodel="{!! url('/vehicle/vehicle_model_delete') !!}" class="btn btn-danger btn-xs modeldeletes">X</button></a></td><tr>');

						/*$('.model_addname').append('<option value='+model_name+'>'+model_name+'</option>');*/
						$('.model_addname').append("<option value='"+model_name+"'>"+model_name+"</option>");
						$('.vehi_modal_name').val('');
					}

					//Form submit at a time only one for addVehicleModel
					$(".vehi_model_add").prop('disabled', false);
					return false;
				},
			});
		}
	});

	/*Delete vehicle model*/
	$('body').on('click','.modeldeletes',function()
	{

		var mod_del_id = $(this).attr('modelid');
		var del_url = $(this).attr('deletemodel');

		swal({
			title: msg1,
            text: msg2,
            type: "warning",
            showCancelButton: true,
            cancelButtonText: msg3,
            cancelButtonColor: "#C1C1C1",
            confirmButtonColor: "#297FCA",
            confirmButtonText: msg4,
            closeOnConfirm: false
		},
		function(isConfirm){
			if (isConfirm)
			{
				$.ajax({

					type:'GET',
					url:del_url,
					data:{mod_del_id:mod_del_id},
					success:function(data)
					{
						$('.mod-'+mod_del_id).remove();
						$(".model_addname option[value="+mod_del_id+"]").remove();
						swal(msg5, msg6,"success");
					}
				});
			}
			else
			{
				swal(msg7, msg8, "error");
			}
		})
	});


	$('.vehicle_select_number_plate').change(function()
	{
		var number_plate = $(this).val();
		var url = $(this).attr('vehicalnumberurl');

		$.ajax({
			type:'GET',
			url: url,
			data:{ vehical_id:number_plate },
			success:function(response){
				$('.select_vehicaltype').html(response);
			}
		});
	});

	/*vehical Type from brand*/
	$('.select_vehicaltype').change(function()
	{
		vehical_id = $(this).val();
		var url = $(this).attr('vehicalurl');

		$.ajax({
			type:'GET',
			url: url,
			data:{ vehical_id:vehical_id },
			success:function(response){
				$('.select_vehicalbrand').html(response);
			}
		});
	});

	var msg100 = "{{ trans('app.An error occurred :')}}";

	/*Vehical Description*/
	$("#add_new_description").click(function()
	{

		var row_id = $("#tab_decription_detail > tbody > tr").length;
		var url = $(this).attr('url');

		$.ajax({
            type: 'GET',
			url: url,
			data : {row_id:row_id},
			beforeSend: function() {
				$("#add_new_description").prop('disabled', true); // disable button
			},
			success: function (response)
			{
				$("#tab_decription_detail > tbody").append(response.html);
				$("#add_new_description").prop('disabled', false); // enable button
				return false;
			},
            error: function(e)
            {
            	alert(msg100 + " " + e.responseText);
                console.log(e);
            }
       	});
	});


	$('body').on('click','.delete_description',function()
	{
		var row_id = $(this).attr('data-id');

		$('table#tab_decription_detail tr#row_id_'+row_id).remove();
		return false;
	});


	/*vehical color*/
	$("#add_new_color").click(function()
	{
		var color_id = $("#tab_color > tbody > tr").length;
		var url = $(this).attr('url');

		$.ajax({
			type: 'GET',
			url: url,
			data : {color_id:color_id},
			beforeSend: function() {
				$("#add_new_color").prop('disabled', true); // disable button
			},
			success: function (response)
			{
				$("#tab_color > tbody").append(response.html);
				$("#add_new_color").prop('disabled', false); // disable button
				return false;
			},
            error: function(e) {
            	alert(msg42 + " " + e.responseText);
            	console.log(e);
            }
       	});
	});


	$('body').on('click','.remove_color',function(){

		var color_id = $(this).attr('data-id');

		$('table#tab_color tr#color_id_'+color_id).remove();
		return false;
	});


    // Basic
    $('.dropify').dropify();

    // Translated
    $('.dropify-fr').dropify({
        messages: {
            default: 'Glissez-déposez un fichier ici ou cliquez',
            replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
            remove:  'Supprimer',
            error:   'Désolé, le fichier trop volumineux'
        }
    });

    // Used events
    var drEvent = $('#input-file-events').dropify();

    drEvent.on('dropify.beforeClear', function(event, element){
        return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
    });

    drEvent.on('dropify.afterClear', function(event, element){
        alert('File deleted');
    });

    drEvent.on('dropify.errors', function(event, element){
        console.log('Has Errors');
    });

    var drDestroy = $('#input-file-to-destroy').dropify();
    drDestroy = drDestroy.data('dropify')

    $('#toggleDropify').on('click', function(e){
        e.preventDefault();
        if (drDestroy.isDropified()) {
        	drDestroy.destroy();
        } else {
        	drDestroy.init();
        }
    })

    /*images show in multiple in for loop*/
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


	$('body').on('click','.trash_accounts',function(){

		var image_id = $(this).attr('data-id');

		$('table#tab_images tr#image_id_'+image_id).fadeOut();
		return false;
	});


    $('.datepicker').datetimepicker({
       	format: "<?php echo getDatepicker(); ?>",
		autoclose: 1,
		minView: 2,
    });


    /*If put firstly any white space then clear textbox*/
    $('body').on('keyup', '.vehical_type', function(){

      	var vehical_typeVal = $(this).val();

      	if (!vehical_typeVal.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

    $('body').on('keyup', '.vehical_brand', function(){

      	var vehical_brandVal = $(this).val();

      	if (!vehical_brandVal.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

    $('body').on('keyup', '.fuel_type', function(){

      	var fuel_typeVal = $(this).val();

      	if (!fuel_typeVal.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

   	$('body').on('keyup', '.vehi_modal_name', function(){

      	var vehi_modal_nameVal = $(this).val();

      	if (!vehi_modal_nameVal.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});



   	$('body').on('keyup', '.chassis_no', function(){

      	var chasicno1 = $(this).val();

      	if (!chasicno1.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

   	$('body').on('keyup', '.no_of_gear', function(){

      	var gearno1 = $(this).val();

      	if (!gearno1.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

    $('body').on('keyup', '.price_is', function(){

      	var price1 = $(this).val();

      	if (!price1.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

    $('body').on('keyup', '.odometer_read', function(){

      	var odometerreading1 = $(this).val();

      	if (!odometerreading1.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

    $('body').on('keyup', '.gear_box', function(){

      	var gearbox1 = $(this).val();

      	if (!gearbox1.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

   	$('body').on('keyup', '.gear_box_no', function(){

      	var vehi_modal_nameVal = $(this).val();

      	if (!vehi_modal_nameVal.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

   	$('body').on('keyup', '.engine_no', function(){

      	var engineno1 = $(this).val();

      	if (!engineno1.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

    $('body').on('keyup', '.engine_size', function(){

      	var enginesize1 = $(this).val();

      	if (!enginesize1.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

    $('body').on('keyup', '.engineField', function(){

      	var engine1 = $(this).val();

      	if (!engine1.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

   	$('body').on('keyup', '.key_no', function(){

      	var keyno1 = $(this).val();

      	if (!keyno1.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

   	/* $('body').on('keyup', '.number_plate', function(){

      	var number_plate = $(this).val();

      	if (!number_plate.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	}); */



    /*Custom Field manually validation*/
	var msg31 = "{{ trans('app.field is required')}}";
	var msg32 = "{{ trans('app.Only blank space not allowed')}}";
	var msg33 = "{{ trans('app.Special symbols are not allowed.')}}";
	var msg34 = "{{ trans('app.At first position only alphabets are allowed.')}}";

	/*Form submit time check validation for Custom Fields */
	$('body').on('click','.vehicleAddSubmitButton',function(e){
		$('#vehicleAdd-Form input, #vehicleAdd-Form select, #vehicleAdd-Form textarea').each(

		    function(index)
		    {
		        var input = $(this);

		        if (input.attr('name') == "number_plate" || input.attr('name') == "vehical_id" || input.attr('name') == "vehicabrand" || input.attr('name') == "fueltype" || input.attr('name') == "modelname"  || input.attr('name') == "price") {
		        	if (input.val() == "")
		        	{
		        		return false;
		        	}
		        }
		        else if (input.attr('isRequire') == 'required')
		        {
		        	var rowid = (input.attr('rows_id'));
			        var labelName = (input.attr('fieldnameis'));

		        	if (input.attr('type') == 'textbox' || input.attr('type') == 'textarea')
			        {
			        	if (input.val() == '' || input.val() == null)
			        	{
			        		$('.common_value_is_'+rowid).val("");
				    		$('#common_error_span_'+rowid).text(labelName + " : " + msg31);
				    		$('#common_error_span_'+rowid).css({"display":""});
							$('.error_customfield_main_div_'+rowid).addClass('has-error');
			        		e.preventDefault();
			        		return false;
			        	}
			        	else if (!input.val().replace(/\s/g, '').length)
			        	{
				    		$('.common_value_is_'+rowid).val("");
				    		$('#common_error_span_'+rowid).text(labelName + " : " + msg32);
				    		$('#common_error_span_'+rowid).css({"display":""});
							$('.error_customfield_main_div_'+rowid).addClass('has-error');
			        		e.preventDefault();
			        		return false;
			        	}
			        	else if(!input.val().match(/^[a-zA-Z\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F][a-zA-Z0-9\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s\.\-\_]*$/))
			        	{
			        		$('.common_value_is_'+rowid).val("");
				    		$('#common_error_span_'+rowid).text(labelName + " : " + msg33);
				    		$('#common_error_span_'+rowid).css({"display":""});
							$('.error_customfield_main_div_'+rowid).addClass('has-error');
			        		e.preventDefault();
			        		return false;
			        	}
			        }
			        else if (input.attr('type') == 'checkbox')
			        {
			        	var ids = input.attr('custm_isd');
						if($(".required_checkbox_" + ids).is(':checked'))
						{
							$('#common_error_span_'+rowid).css({"display":"none"});
							$('.error_customfield_main_div_'+rowid).removeClass('has-error');
							$('.required_checkbox_parent_div_'+ids).css({"color":""});
							$('.error_customfield_main_div_'+ids).removeClass('has-error');
						}
						else
						{
				    		$('#common_error_span_'+rowid).text(labelName + " : " + msg31);
				    		$('#common_error_span_'+rowid).css({"display":""});
				    		$('.error_customfield_main_div_'+rowid).addClass('has-error');
				    		$('.required_checkbox_'+ids).css({"outline":"2px solid #a94442"});
				    		$('.required_checkbox_parent_div_'+ids).css({"color":"#a94442"});
							e.preventDefault();
							return false;
						}
			        }
			        else if (input.attr('type') == 'date')
		    		{
		    			if (input.val() == '' || input.val() == null)
			        	{
			        		$('.common_value_is_'+rowid).val("");
				    		$('#common_error_span_'+rowid).text(labelName + " : " + msg31);
				    		$('#common_error_span_'+rowid).css({"display":""});
							$('.error_customfield_main_div_'+rowid).addClass('has-error');
							e.preventDefault();
				        	return false;
			        	}
			        	else
			        	{
			        		$('#common_error_span_'+rowid).css({"display":"none"});
							$('.error_customfield_main_div_'+rowid).removeClass('has-error');
			        	}
			    	}
		        }
		        else if (input.attr('isRequire') == "")
		        {
		        	//Nothing to do
		        }
		    }
		);
	});


	/*Anykind of input time check for validation for Textbox, Date and Textarea*/
	$('body').on('keyup','.common_simple_class',function(){

		var rowid = $(this).attr('rows_id');
        var valueIs = $('.common_value_is_'+rowid).val();
        var requireOrNot = $('.common_value_is_'+rowid).attr('isrequire');
        var labelName = $('.common_value_is_'+rowid).attr('fieldnameis');
        var inputTypes = $('.common_value_is_'+rowid).attr('type');

		if (requireOrNot != "")
		{
			if (inputTypes != 'radio' && inputTypes != 'checkbox' && inputTypes != 'date')
		    {
		    	if (valueIs == "")
		    	{
		    		$('.common_value_is_'+rowid).val("");
		    		$('#common_error_span_'+rowid).text(labelName + " : " + msg31);
		    		$('#common_error_span_'+rowid).css({"display":""});
					$('.error_customfield_main_div_'+rowid).addClass('has-error');
		    	}
		    	else if (valueIs.match(/^\s+/))
		    	{
		    		$('.common_value_is_'+rowid).val("");
		    		$('#common_error_span_'+rowid).text(labelName + " : " + msg34);
		    		$('#common_error_span_'+rowid).css({"display":""});
					$('.error_customfield_main_div_'+rowid).addClass('has-error');
		    	}
		    	else if(!valueIs.match(/^[a-zA-Z\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F][a-zA-Z0-9\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s\.\-\_]*$/))
		    	{
		    		$('.common_value_is_'+rowid).val("");
		    		$('#common_error_span_'+rowid).text(labelName + " : " + msg33);
		    		$('#common_error_span_'+rowid).css({"display":""});
					$('.error_customfield_main_div_'+rowid).addClass('has-error');
		    	}
		    	else
		    	{
					$('#common_error_span_'+rowid).css({"display":"none"});
					$('.error_customfield_main_div_'+rowid).removeClass('has-error');
		    	}
		    }
		    else if (inputTypes == 'date')
		    {
		    	if (valueIs != "")
		    	{
					$('#common_error_span_'+rowid).css({"display":"none"});
					$('.error_customfield_main_div_'+rowid).removeClass('has-error');
		    	}
		    	else
		    	{
		    		$('.common_value_is_'+rowid).val("");
		    		$('#common_error_span_'+rowid).text(labelName + " : " + msg31);
		    		$('#common_error_span_'+rowid).css({"display":""});
					$('.error_customfield_main_div_'+rowid).addClass('has-error');
		    	}
		    }
		    else
		    {
		    	//alert("Yes i am radio and checkbox");
		    }
		}
		else
		{
			if (inputTypes != 'radio' && inputTypes != 'checkbox' && inputTypes != 'date')
		    {
		    	if (valueIs != "")
		    	{
		    		if (valueIs.match(/^\s+/))
			    	{
			    		$('.common_value_is_'+rowid).val("");
			    		$('#common_error_span_'+rowid).text(labelName + " : " + msg34);
			    		$('#common_error_span_'+rowid).css({"display":""});
						$('.error_customfield_main_div_'+rowid).addClass('has-error');
			    	}
			    	else if(!valueIs.match(/^[a-zA-Z\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F][a-zA-Z0-9\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s\.\-\_]*$/))
			    	{
			    		$('.common_value_is_'+rowid).val("");
			    		$('#common_error_span_'+rowid).text(labelName + " : " + msg33);
			    		$('#common_error_span_'+rowid).css({"display":""});
						$('.error_customfield_main_div_'+rowid).addClass('has-error');
			    	}
			    	else
			    	{
						$('#common_error_span_'+rowid).css({"display":"none"});
						$('.error_customfield_main_div_'+rowid).removeClass('has-error');
			    	}
		    	}
		    	else
		    	{
		    		$('#common_error_span_'+rowid).css({"display":"none"});
					$('.error_customfield_main_div_'+rowid).removeClass('has-error');
		    	}
		    }
		}
	});


	/*For required checkbox checked or not*/
	$('body').on('click','.checkbox_simple_class',function(){

		var rowid = $(this).attr('rows_id');
        var requireOrNot = $('.common_value_is_'+rowid).attr('isrequire');
        var labelName = $('.common_value_is_'+rowid).attr('fieldnameis');
        var inputTypes = $('.common_value_is_'+rowid).attr('type');
        var custId = $('.common_value_is_'+rowid).attr('custm_isd');

		if (requireOrNot != "")
		{
			if($(".required_checkbox_" + custId).is(':checked'))
			{
				$('.required_checkbox_'+custId).css({"outline":""});
				$('.required_checkbox_'+custId).css({"color":""});
				$('#common_error_span_'+rowid).css({"display":"none"});
				$('.required_checkbox_parent_div_'+custId).css({"color":""});
				$('.error_customfield_main_div_'+rowid).removeClass('has-error');
			}
			else
			{
	    		$('#common_error_span_'+rowid).text(labelName + " : " + msg31);
	    		$('.required_checkbox_'+custId).css({"outline":"2px solid #a94442"});
	    		$('.required_checkbox_'+custId).css({"color":"#a94442"});
	    		$('#common_error_span_'+rowid).css({"display":""});
	    		$('.required_checkbox_parent_div_'+custId).css({"color":"#a94442"});
				$('.error_customfield_main_div_'+rowid).addClass('has-error');
			}
		}
	});


	$('body').on('change','.date_simple_class',function(){

		var rowid = $(this).attr('rows_id');
		var valueIs = $('.common_value_is_'+rowid).val();
        var requireOrNot = $('.common_value_is_'+rowid).attr('isrequire');
        var labelName = $('.common_value_is_'+rowid).attr('fieldnameis');
        var inputTypes = $('.common_value_is_'+rowid).attr('type');
        var custId = $('.common_value_is_'+rowid).attr('custm_isd');

		if (requireOrNot != "")
		{
			if (valueIs != "")
			{
				$('#common_error_span_'+rowid).css({"display":"none"});
				$('.error_customfield_main_div_'+rowid).removeClass('has-error');
			}
			else
			{
				$('#common_error_span_'+rowid).text(labelName + " : " + msg31);
	    		$('#common_error_span_'+rowid).css({"display":""});
				$('.error_customfield_main_div_'+rowid).addClass('has-error');
			}
		}
	});
});
</script>
<script>
$(document).ready(function()
{
	/*customer add*/
	$('body').on('click','.openmodel',function(){
		$('#myModal').modal();
	});
	var msg100 = "{{ trans('app.An error occurred :')}}";

    $("#formcustomer").on('submit',(function(event) {

		function define_variable()
		{
			return {
			firstname:$("#firstname").val(),
			lastname:$("#lastname").val(),
			//datepicker:$("#datepicker").val(),
			displayname:$("#displayname").val(),
			company_name:$("#company_name").val(),
			email:$("#email").val(),
			password:$("#password").val(),
			password_confirmation:$("#password_confirmation").val(),
			mobile:$("#mobile").val(),
			landlineno:$("#landlineno").val(),
			image:$("#image").val(),
			country_id:$( "#country_id option:selected" ).val(),
			state_id:$( "#state_id option:selected" ).val(),
			city:$( "#city option:selected" ).val(),
			address:$( "#address" ).val(),
			name_pattern:/^[a-zA-Z\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s]+$/,
			name_pattern2: /^[a-zA-Z\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s]*$/,
			company_patt:/^[a-zA-Z0-9\u0621-\u064A\u00C0-\u017F\u0600-\u06FF\u0750-\u077F\uFB50-\uFDFF\uFE70-\uFEFF\u2E80-\u2FD5\u3190-\u319f\u3400-\u4DBF\u4E00-\u9FCC\uF900-\uFAAD\u0900-\u097F\s]*$/,
			lenghtLimit:/^[0-9]{6,16}$/,
			mobile_pattern:/^[- +()]*[0-9][- +()0-9]*$/,
			email_pattern:/^([a-zA-Z0-9_\.\-\+\'])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
			};
		}

		event.preventDefault();
		var call_var_customeradd = define_variable();
		var errro_msg = [];
		//first name
		if(call_var_customeradd.firstname == "")
		{
			var msg = "{{ trans('app.First name is required.')}}";
			$('#errorlfirstname').html(msg);
			errro_msg.push(msg);
			return false;
		}
		else
		{
			$('#errorlfirstname').html("");
			errro_msg = [];
		}

		if (!call_var_customeradd.name_pattern.test(call_var_customeradd.firstname))
		{
			var msg = "{{ trans('app.First name is only alphabets and space.')}}";
			$("#firstname").val("");
			$('#errorlfirstname').html(msg);
			errro_msg.push(msg);
			return false;
		}
		else
		{
			$('#errorlfirstname').html("");
			errro_msg = [];
		}

		if(!call_var_customeradd.firstname.replace(/\s/g, '').length){

        	var msg = "{{ trans('app.Only blank space not allowed')}}";
        	$("#firstname").val("");
			$('#errorlfirstname').html(msg);
			errro_msg.push(msg);
			return false;
        }
        else{
			$('#errorlfirstname').html("");
			errro_msg = [];
		}

		if (!call_var_customeradd.name_pattern2.test(call_var_customeradd.firstname))
		{
			var msg = "{{ trans('app.At first position only alphabets are allowed.')}}";
			$("#firstname").val("");
			$('#errorlfirstname').html(msg);
			errro_msg.push(msg);
			return false;
		}
		else
		{
			$('#errorlfirstname').html("");
			errro_msg = [];
		}

		//last name
		if(call_var_customeradd.lastname == "")
		{
			var msg = "{{ trans('app.Last name is required.')}}";
			$('#errorllastname').html(msg);
			errro_msg.push(msg);
			return false;
		}
		else
		{
			$('#errorllastname').html("");
			errro_msg = [];
		}
		if (!call_var_customeradd.name_pattern.test(call_var_customeradd.lastname))
		{
			var msg = "{{ trans('app.Last name is only alphabets and space.')}}";
			$('#errorllastname').html(msg);
			errro_msg.push(msg);
			return false;
		}
		else
		{
			$('#errorllastname').html("");
			errro_msg = [];
		}

		if(!call_var_customeradd.lastname.replace(/\s/g, '').length){

			var msg = "{{ trans('app.Only blank space not allowed')}}";
        	$("#lastname").val("");
			$('#errorllastname').html(msg);
			errro_msg.push(msg);
			return false;
        }
        else{
			$('#errorllastname').html("");
			errro_msg = [];
		}

		if (!call_var_customeradd.name_pattern2.test(call_var_customeradd.lastname))
		{
			var msg = "{{ trans('app.At first position only alphabets are allowed.')}}";
			$('#errorllastname').html(msg);
			errro_msg.push(msg);
			return false;
		}
		else
		{
			$('#errorllastname').html("");
			errro_msg = [];
		}


		//Display name
		if (call_var_customeradd.displayname != "") {

			if (!call_var_customeradd.name_pattern.test(call_var_customeradd.displayname))
			{
				var msg = "{{ trans('app.Display name is only alphabets and space.')}}";
				$("#displayname").val("");
				$('#errorldisplayname').html(msg);
				errro_msg.push(msg);
				return false;
			}
			else if(!call_var_customeradd.displayname.replace(/\s/g, '').length){

				var msg = "{{ trans('app.Only blank space not allowed')}}";
	        	$("#displayname").val("");
				$('#errorldisplayname').html(msg);
				errro_msg.push(msg);
				return false;
	        }
	        else if (!call_var_customeradd.name_pattern2.test(call_var_customeradd.displayname))
			{
				var msg = "{{ trans('app.At first position only alphabets are allowed.')}}";
				$("#displayname").val("");
				$('#errorldisplayname').html(msg);
				errro_msg.push(msg);
				return false;
			}
			else
			{
				$('#errorldisplayname').html("");
				errro_msg = [];
			}
		}
		else
		{
			$('#errorldisplayname').html("");
			errro_msg = [];
		}


		//Company name
		if (call_var_customeradd.company_name != "") {

			if(!call_var_customeradd.company_name.replace(/\s/g, '').length){

				var msg = "{{ trans('app.Only blank space not allowed')}}";
	        	$("#company_name").val("");
				$('#errorlcompanyName').html(msg);
				errro_msg.push(msg);
				return false;
	        }
			else if (!call_var_customeradd.company_patt.test(call_var_customeradd.company_name))
			{
				var msg = "{{ trans('app.Only alphanumeric, space, dot, @, _, and - are allowed.')}}";
				$("#company_name").val("");
				$('#errorlcompanyName').html(msg);
				errro_msg.push(msg);
				return false;
			}
			else if (!call_var_customeradd.name_pattern2.test(call_var_customeradd.company_name))
			{
				var msg = "{{ trans('app.At first position only alphabets are allowed.')}}";
				$("#company_name").val("");
				$('#errorlcompanyName').html(msg);
				errro_msg.push(msg);
				return false;
			}
			else
			{
				$('#errorlcompanyName').html("");
				errro_msg = [];
			}
		}
		else
		{
			$('#errorlcompanyName').html("");
			errro_msg = [];
		}

		//Date of birth
		/*if(call_var_customeradd.datepicker == "")
		{
			var msg = "{{ trans('app.Date is required.')}}";
			$('#errorldatepicker').html(msg);
			errro_msg.push(msg);
			return false;
		}
		else
		{
			$('#errorldatepicker').html("");
			errro_msg = [];
		}*/

		//Email
		if(call_var_customeradd.email == "")
		{
			var msg = "{{ trans('app.Email is required.')}}";
			$('#errorlemail').html(msg);
			errro_msg.push(msg);
			return false;
		}
		else
		{
			$('#errorlemail').html("");
			errro_msg = [];
		}

		if(!call_var_customeradd.email.replace(/\s/g, '').length){

			var msg = "{{ trans('app.Only blank space not allowed')}}";
        	$("#email").val("");
			$('#errorlemail').html(msg);
			errro_msg.push(msg);
			return false;
        }
        else{
			$('#errorlfirstname').html("");
			errro_msg = [];
		}

		if (!call_var_customeradd.email_pattern.test(call_var_customeradd.email))
		{
			var msg = "{{ trans('app.Please enter a valid email address. Like : sales@dasinfomedia.com')}}";
			$('#errorlemail').html(msg);
			errro_msg.push(msg);
			return false;
		}
		else
		{
			$('#errorlemail').html("");
			errro_msg = [];
		}


		//Password
		if(call_var_customeradd.password == "")
		{
			var msg = "{{ trans('app.Password is required.')}}";
			$('#errorlpassword').html(msg);
			errro_msg.push(msg);
			return false;
		}
		else
		{
			$('#errorlpassword').html("");
			errro_msg = [];
		}
		//Confirm Password
		if(call_var_customeradd.password_confirmation == "")
		{
			var msg = "{{ trans('app.Confirm password is required.')}}";
			$('#errorlpassword_confirmation').html(msg);
			errro_msg.push(msg);
			return false;
		}
		else
		{
			$('#errorlpassword_confirmation').html("");
			errro_msg = [];
		}

		//same Password and password_confirmation
		if(call_var_customeradd.password != call_var_customeradd.password_confirmation)
		{
			var msg = "{{ trans('app.Password and Confirm Password does not match.')}}";
			$('#errorlpassword_confirmation').html(msg);
			errro_msg.push(msg);
			return false;
		}
		else
		{
			$('#errorlpassword').html("");
			errro_msg = [];
		}

		//Mobile number
		if(call_var_customeradd.mobile == "")
		{
			var msg = "{{ trans('app.Contact number is required.')}}";
			$('#errorlmobile').html(msg);
			errro_msg.push(msg);
			return false;
		}
		else
		{
			$('#errorlmobile').html("");
			errro_msg = [];
		}
		if (!call_var_customeradd.mobile_pattern.test(call_var_customeradd.mobile))
		{
			var msg = "{{ trans('app.Contact number must be number, plus, minus and space only.')}}";
			$("#mobile").val("");
			$('#errorlmobile').html(msg);
			errro_msg.push(msg);
			return false;
		}
		else
		{
			$('#errorlmobile').html("");
			errro_msg = [];
		}

		if(!call_var_customeradd.mobile.replace(/\s/g, '').length){

			var msg = "{{ trans('app.Only blank space not allowed')}}";
        	$("#mobile").val("");
			$('#errorlmobile').html(msg);
			errro_msg.push(msg);
			return false;
        }
		else
		{
			$('#errorlmobile').html("");
			errro_msg = [];
		}

		//LandLine number
		if(call_var_customeradd.landlineno != "")
		{
			if (!call_var_customeradd.mobile_pattern.test(call_var_customeradd.landlineno))
			{
				var msg = "{{ trans('app.Landline number must be number, plus, minus and space only.')}}";
				$("#landlineno").val("");
				$('#errorllandlineno').html(msg);
				errro_msg.push(msg);
				return false;
			}
			else if(!call_var_customeradd.lenghtLimit.test(call_var_customeradd.landlineno)) {
				var msg = "{{ trans('app.Landline number between 6 to 16 digits only')}}";
				$("#landlineno").val("");
				$('#errorllandlineno').html(msg);
				errro_msg.push(msg);
				return false;
			}
			else if(!call_var_customeradd.landlineno.replace(/\s/g, '').length){

				var msg = "{{ trans('app.Only blank space not allowed')}}";
	        	$("#landlineno").val("");
				$('#errorllandlineno').html(msg);
				errro_msg.push(msg);
				return false;
	        }
			else
			{
				$('#errorllandlineno').html("");
				errro_msg = [];
			}
		}
		else
		{
			$('#errorllandlineno').html("");
			errro_msg = [];
		}

		//Country
		if(call_var_customeradd.country_id == "")
		{
			var msg = "{{ trans('app.Country field is required.')}}";
			$('#errorlcountry_id').html(msg);
			errro_msg.push(msg);
			return false;
		}
		else
		{
			$('#errorlcountry_id').html("");
			errro_msg = [];
		}
		//Address
		if(call_var_customeradd.address == "")
		{
			var msg = "{{ trans('app.Address field is required.')}}";
			$('#errorladdress').html(msg);
			errro_msg.push(msg);
			return false;
		}
		else
		{
			$('#errorladdress').html("");
			errro_msg = [];
		}

		if(!call_var_customeradd.address.replace(/\s/g, '').length){

			var msg = "{{ trans('app.Only blank space not allowed')}}";
        	$("#address").val("");
			$('#errorladdress').html(msg);
			errro_msg.push(msg);
			return false;
        }
        else{
			$('#errorladdress').html("");
			errro_msg = [];
		}

		if(errro_msg =="")
		{
		   	var firstname =$('#firstname').val();
		   	var lastname =$('#lastname').val();
		   	var displayname =$('#displayname').val();
		   	var company_name =$('#company_name').val();
		   	var gender  = $(".gender:checked").val();
		   	var dob  = $("#datepicker").val();
		   	var email  = $("#email").val();
		   	var password  = $("#password").val();
		   	var mobile  = $("#mobile").val();
		   	var landlineno  = $("#landlineno").val();
		   	var image  = $("#image").val();
		   	var country_id  = $( "#country_id option:selected" ).val();
		   	var state_id  = $( "#state_id option:selected" ).val();
		   	var city  = $( "#city option:selected" ).val();
		   	var address  = $( "#address" ).val();

		   	$.ajax({
			   	type: 'POST',
			   	url: '{!!url('service/customeradd')!!}',
			    data: new FormData(this),
				headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
				contentType: false,
				cache: false,
				processData:false,

			   	success:function(data)
			   	{
			   		$('.select_vhi').append('<option value='+data['customerId']+'>'+data['customer_fullname']+'</option>');

				   	/*var firstname =$('#firstname').val();
				   	$('.select_vhi').append('<option value='+data+'>'+firstname+'</option>');*/

				   	var firstname = $('#firstname').val('');
				   	var lastname =$('#lastname').val('');
				   	var displayname =$('#displayname').val('');
				   	var gender  = $(".gender:checked").val('');
				   	var dob  = $("#datepicker").val('');
				   	var email  = $("#email").val('');
				   	var password  = $("#password").val('');
				   	var mobile  = $("#mobile").val('');
				   	var landlineno  = $("#landlineno").val('');
				   	var image  = $("#image").val('');
				   	var country_id  = $( "#country_id option:selected" ).val('');
				   	var state_id  = $( "#state_id option:selected" ).val('');
				   	var city  = $( "#city option:selected" ).val('');
				   	var address  = $( "#address" ).val('');
				   	var company_name  = $( "#company_name" ).val('');
					$(".addcustomermsg").removeClass("hide");

				   	$('.hidden_customer_id').val(data['customerId']);
			   	},
			    error: function(e) {
                 	alert(msg100 + " " + e.responseText);
                    console.log(e);
                }
		   });
		}
	}));

	/*customer model state to city*/
	$('.select_country').change(function(){
		countryid = $(this).val();
		var url = $(this).attr('countryurl');
		$.ajax({
			type:'GET',
			url: url,
			data:{ countryid:countryid },
			success:function(response){
				$('.state_of_country').html(response);
			}
		});
	});


	$('body').on('change','.state_of_country',function(){
		stateid = $(this).val();

		var url = $(this).attr('stateurl');
		$.ajax({
			type:'GET',
			url: url,
			data:{ stateid:stateid },
			success:function(response){
				$('.city_of_state').html(response);
			}
		});
	});

});

$('.select_number_plate').change(function()
	{
		var number_plate = $(this).val();
		if(number_plate!==""){
			var url = $(this).attr('vehicalnumberurl');
		$.ajax({
			type:'GET',
			url: url,
			data:{ vehical_id:number_plate },
			success:function(response){
				response=JSON.parse(response);
				console.log(response.vehicleInfo);
				$('.select_vehicaltype').val(response.vehicleInfo.vehicletype_id);
				$('#sup_id').val(response.vehicleInfo.customer_id);
				$('.chassis_no').val(response.vehicleInfo.chassisno);
				$('#modelyear').val(response.vehicleInfo.modelyear);
				$('#fueltype').val(response.vehicleInfo.fuel_id);
				$('#gearno').val(response.vehicleInfo.nogears);
				$('.model_addname').val(response.vehicleInfo.modelname);
				$('.price_is').val(response.vehicleInfo.price);
				$('.odometer_read').val(response.vehicleInfo.odometerreading);
				$('.gear_box').val(response.vehicleInfo.gearbox);
				$('.gear_box_no').val(response.vehicleInfo.gearboxno);
				$('.engine_no').val(response.vehicleInfo.engineno);
				$('.engine_size').val(response.vehicleInfo.enginesize);
				$('.engine_size').val(response.vehicleInfo.enginesize);
				$('.key_no').val(response.vehicleInfo.keyno);
				$('.engineField').val(response.vehicleInfo.engine);
				$('#dom').val(response.vehicleInfo.dom);
				$('.select_vehicaltype').trigger('change');
				if(response.selected_color.length > 0 ){
					$('#color_tbody').empty();
					var trHtml=getColorHtml(response.selected_color,response.all_color);
					$('#color_tbody').append(trHtml);
				}
				if(response.vehicle_description.length > 0 ){
					$('#tab_decription_info').empty();
					var descpHtml=getDescpHtml(response.vehicle_description);
					$('#tab_decription_info').append(descpHtml);
				}
				if(response.images1.length > 0 ){
					$('#image_preview').empty();
					var imageHtml=getImageHtml(response.images1);
					$('#image_preview').append(imageHtml);
				}


			}
		});
		}

	});

	function getColorHtml(selectedColor,all_color)
	{
		var tableHtml='';
		var c=1;
		var selected="";
		var remove_color="";
		for (let i = 0; i < selectedColor.length; i++) {
			if(i==0){
				remove_color="";
			}else{
				remove_color='remove_color';
			}
			tableHtml +='<tr id="color_id_'+c+'"><td><select name="color[]" class="form-control color" id="tax_'+c+'" data-id="'+c+'"><option value="">Select Color</option>';
					if(all_color!=""){
						for (let b = 0; b < all_color.length; b++) {
							if(selectedColor[i]['color']==all_color[b]['id']){
								selected="selected";
							}
							tableHtml+='<option value="'+all_color[b]['id']+'" '+selected+' >'+all_color[b]['color']+'</option>';
						}
					}

			tableHtml+='</select></td><td><span class="'+remove_color+'" style="cursor: pointer;" data-id='+c+'><i class="fa fa-trash"></i>Delete</span></td></tr>';
		c++;
	}
		return tableHtml;
	}

	function getDescpHtml(selectedDescp)
	{
		var descpHtml='';
		var d=1;
		var selected="";
		var delete_description="";
		for (let i = 0; i < selectedDescp.length; i++) {
			if(i==0){
				delete_description="";
			}else{
				delete_description='delete_description';
			}
			descpHtml+='<tr id="row_id_'+d+'"><td>';
				descpHtml+='<textarea name="description[]" class="form-control" maxlength="100" id="tax_'+d+'" >'+selectedDescp[i]['vehicle_description']+'</textarea>';
				descpHtml+='</td><td>';
				descpHtml+='<span class="'+delete_description+'" style="cursor: pointer;" data-id="'+d+'"><i class="fa fa-trash"></i>Delete</span></td></tr>';
		d++;}
		return descpHtml;
	}

	function getImageHtml(images)
	{
		var imageUrl='@php echo url('public/vehicle/') @endphp';
		var imgHtml='';
		var d=1;
		var delete_description="";
		for (let i = 0; i < images.length; i++) {

			imgHtml+='<div class="col-md-4 col-sm-4 col-xs-12 removeimage delete_image" id="image_remove_'+images[i]['id']+'"  imgaeid="'+images[i]['id']+'" ><a href=""><img src="'+imageUrl+'/'+images[i]['image']+'"  width="100px" height="60px">';
			imgHtml+='</a></div>';

	d++;}
		return imgHtml;
	}

</script>
<!-- Form field validation -->
{!! JsValidator::formRequest('App\Http\Requests\VehicleAddEditFormRequest', '#vehicleAdd-Form'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>

<!-- Form submit at a time only one -->
<script type="text/javascript">
    /*$(document).ready(function () {
        $('.vehicleAddSubmitButton').removeAttr('disabled'); //re-enable on document ready
    });
    $('.vehicleAddForm').submit(function () {
        $('.vehicleAddSubmitButton').attr('disabled', 'disabled'); //disable on any form submit
    });

    $('.vehicleAddForm').bind('invalid-form.validate', function () {
      $('.vehicleAddSubmitButton').removeAttr('disabled'); //re-enable on form invalidation
    });*/
</script>

@endsection