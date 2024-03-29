@extends('layouts.app')
@section('content')
<style>
.step{color:#5A738E !important;}
.invalid-feedback{color:red;}
</style>

<!-- page content -->
	<div class="right_col" role="main">

		<div class="page-title">
			  <div class="nav_menu">
				<nav>
					<div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"> </i><span class="titleup">&nbsp; {{ trans('app.Quotation')}}</span></a>
					</div>
					  @include('dashboard.profile')
				</nav>
			  </div>
		</div>
		<div class="x_content">
			<ul class="nav nav-tabs bar_tabs" role="tablist">
				@can('quotation_view')
					<li role="presentation" class=""><a href="{!! url('/quotation/list')!!}"><span class="visible-xs"></span> <i class="fa fa-list fa-lg">&nbsp;</i>{{ trans('app.Quotation List')}}</a></li>
				@endcan
				@can('quotation_add')
					<li role="presentation" class="active"><a href="{!! url('/quotation/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i><b>{{ trans('app.Add Quotation')}}</b></a></li>
				@endcan
			</ul>
		</div>

		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_content">
						<div class="panel panel-default">
							<!-- <div class="panel-heading step titleup">{{ trans('app.Step - 1 : Add Service Details...')}}</div> -->
								<form id="QuotationAdd-Form" method="post" action="{{ url('/quotation/store') }}" enctype="multipart/form-data"  class="form-horizontal upperform serviceAddForm" border="10">

									<div class="form-group">
										<div class="my-form-group">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Quotation Number')}} <label class="color-danger">*</label></label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text" id="jobno" name="jobno" class="form-control" value="{{ $code }}" readonly>
											</div>
										</div>

										<div class="my-form-group">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Customer Name')}} <label class="color-danger">*</label></label>
											<div class="col-md-3 col-sm-3 col-xs-12">
												<select name="Customername" id="sup_id" class="form-control select_vhi select_customer_auto_search" cus_url = "{!! url('service/get_vehi_name') !!}" required>
												<option value="">{{ trans('app.Select Customer')}}</option>
												@if(!empty($customer))
													@foreach($customer as $customers)
													<option value="{{$customers->id}}" @php echo $vehicalInfo!="" && $vehicalInfo->customer_id==$customers->id ? 'selected' : ''  @endphp >{{ getCustomerName($customers->id)}}</option>
													@endforeach
												@endif
												</select>
											</div>
											<div class="col-md-1 col-sm-1 col-xs-12 addremove customerAddRemove">
												<button type="button" data-toggle="modal" data-target="#mymodal" class="btn btn-default openmodel">{{ trans('app.Add')}}</button>
											</div>
										</div>
									</div>

								    <div class="form-group" style="margin-top: 20px;">
										<div class="my-form-group">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Vehicle Name')}} <label class="color-danger">*</label></label>
											<div class="col-md-3 col-sm-3 col-xs-12">
												  <select  name="vehicalname" class="form-control modelnameappend" id="vhi" required>
													<option value="">{{ trans('app.Select vehicle Name')}}</option>
													@if($vehicalInfo!="")
													<option value="{{$vehicalInfo->id}}" selected="selected">{{ $vehicalInfo->modelname}}</option>
													@endif
														<!-- Option comes from Controller -->
												  </select>
											 </div>
											<div class="col-md-1 col-sm-1 col-xs-12 addremove">
												<button type="button" data-toggle="modal"     data-target="#vehiclemymodel" class="btn btn-default vehiclemodel">{{ trans('app.Add')}}</button>
											</div>
										</div>

										<div class="my-form-group">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Date">{{ trans('app.Date')}} <label class="color-danger">*</label></label>
											<div class="col-md-4 col-sm-4 col-xs-12 input-group date datepicker">
												<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
												<input type='text' class="form-control" name="date" autocomplete="off" id='p_date' placeholder="<?php echo getDatepicker();  echo " hh:mm:ss"?>"  value="{{ old('date') }}" onkeypress="return false;"  required  />
											</div>
										</div>
									</div>

									<div class="form-group" style="margin-top: 15px;">
										<!-- <div class="">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="number_plate">{{ trans('app.Number Plate')}}</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text" name="number_plate" id="number_plate" placeholder="{{ trans('app.Enter Number Plate') }}"  value="{{ old('number_plate') }}" maxlength="15" class="form-control" >
											</div>
										</div> -->

										<!-- <div class="my-form-group">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Assign To')}} <label class="color-danger">*</label></label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<select id="AssigneTo" name="AssigneTo"  class="form-control" required>
													<option value="">-- {{ trans('app.Select Assign To')}} --</option>
													@if(!empty($employee))
													@foreach($employee as $employees)
													<option value="{{$employees->id}}">{{ $employees->name }}</option>
													@endforeach
													@endif
												</select>
											</div>
										</div> -->

										<div class="my-form-group">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Title')}}</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text" name="title" placeholder="{{ trans('app.Enter Title')}}"  value="{{ old('title') }}" maxlength="50" class="form-control titalQuotation" >
											</div>
										</div>

										<div class="my-form-group">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Repair Category')}} <label class="color-danger">*</label></label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<select name="repair_cat"  class="form-control" required>
													<option value="">{{ trans('app.-- Select Repair Category--')}}</option>
													<option value="breakdown">{{ trans('app.Breakdown') }}</option>
													<option value="booked vehicle">{{ trans('app.Booked Vehicle') }}</option>
													<option value="repeat job">{{ trans('app.Repeat Job') }}</option>
													<option value="customer waiting">{{ trans('app.Customer Waiting') }}</option>
												</select>
											</div>
										</div>
									</div>

									<div class="form-group" style="margin-top: 15px;">								<div class="my-form-group">
											<label class="control-label col-md-2 col-sm-2 col-xs-12">{{ trans('app.Service Type')}} <label class="color-danger">*</label></label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<label class="radio-inline"><input type="radio" name="service_type" id="free"  value="free" required>{{ trans('app.Free')}}</label>
												<label class="radio-inline"><input type="radio" name="service_type" checked id="paid"  value="paid" required>{{ trans('app.Paid')}}</label>
											</div>
										</div>

										<div class="my-form-group">
											<div id="dvCharge" style="" class="has-feedback {{ $errors->has('charge') ? ' has-error' : '' }}">
												<label class="control-label col-md-2 col-sm-2 col-xs-12 currency" for="last-name">{{ trans('app.Fix Service Charge')}} (<?php echo getCurrencySymbols(); ?>) <label class="color-danger">*</label></label>
												<div class="col-md-4 col-sm-4 col-xs-12">
													<input type="text"  id="charge_required" name="charge" class="form-control fixServiceCharge"  placeholder="{{ trans('app.Enter Fix Service Charge')}}"  value="{{ old('charge') }}" maxlength="8">
													@if ($errors->has('charge'))
													   <span class="help-block">
														   <strong>{{ $errors->first('charge') }}</strong>
													   </span>
													 @endif
												</div>
											</div>
										</div>
									</div>

									<div class="form-group" style="margin-top: 15px;">
										<div class="my-form-group">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="details">{{ trans('app.Details')}}</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<textarea class="form-control" name="details" id="details" maxlength="100">{{ old('details')}}</textarea>
											</div>
										</div>

									<!-- MOt Test Checkbox Start-->
										<div class="">
											<label class="control-label col-md-2 col-sm-2 col-xs-12 motTextLabel" for="" >{{ trans('app.MOT Test') }}</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="checkbox" name="motTestStatusCheckbox" id="motTestStatusCheckbox" style="height:20px; width:20px; margin-right:5px; position: relative; top: 1px; margin-bottom: 12px;">
											</div>
										</div>
									<!-- MOt Test Checkbox End-->
									</div>


								<!-- Wash Bay Feature -->
									<div class="form-group" style="">
										<div class="">
											<label class="control-label col-md-2 col-sm-2 col-xs-12 washbayLabel" for="washbay">{{ trans('app.Wash Bay')}} <label class="text-danger"></label></label>
											<div class="col-md-4 col-sm-4 col-xs-12 washbayInputDiv">
												<input type="checkbox" name="washbay" id="washBay" class="washBayCheckbox" {{ old('washbay') ? 'checked' : '' }} style="height:20px; width:20px; margin-right:5px; position: relative; top: 1px; margin-bottom: 12px;">
											</div>
										</div>

										<div id="washBayCharge" hidden="true" style="" class="has-feedback {{ $errors->has('washBayCharge') ? ' has-error' : '' }}">
											<label class="control-label col-md-2 col-sm-2 col-xs-12 currency" for="washBayCharge">{{ trans('app.Wash Bay Charge')}} (<?php echo getCurrencySymbols(); ?>) <label class="color-danger">*</label></label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text"  id="washBayCharge_required" name="washBayCharge" class="form-control washbay_charge_textbox"  placeholder="{{ trans('app.Enter Wash Bay Charge')}}"  value="{{ old('washBayCharge') }}" maxlength="10">

												<span id="washbay_error_span" class="help-block error-help-block color-danger" style="display:none"></span>
											</div>
										</div>
									</div>
								<!-- Wash Bay Feature -->


									<div class="form-group" style="margin-top: 15px;">
									<!-- Tax field start -->
									@if(!empty($tax))
										<div class="">
											<label class="control-label col-md-2 col-sm-2 col-xs-12" for="cus_name">{{ trans('app.Tax') }}</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<table>
													<tbody>
													@foreach($tax as $taxes)
														<tr>
															<td>
																<input type="checkbox" id="tax" class="checkbox-inline check_tax sele_tax myCheckbox" name="Tax[]" value="<?php
																echo $taxes->id;?>" taxrate="{{$taxes->tax}}" taxName="{{$taxes->taxname}}" style="height:20px; width:20px; margin-right:5px; position: relative; top: 6px; margin-bottom: 12px;" >
																<?php
																echo $taxes->taxname.'&nbsp'.$taxes->tax; ?>%
															</td>
														</tr>
													@endforeach
													</tbody>
												</table>
											</div>
										</div>
										@endif
									<!-- New Tax field End-->

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


						<!-- ************* MOT Module Starting ************* -->
								<br/><br/>
								<div class="col-md-12 col-sm-12 col-xs-12 motMainPart" style="display: none">
									<div class="col-md-9 col-sm-8 col-xs-8">
										<h3>{{ trans('app.MOT Test') }}</h3>
									</div>
								</div>

								<div class="col-md-12 col-xs-12 col-sm-12 panel-group motMainPart-1" style="display: none">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" href="#collapse2" class="observation_Plus2" style="color:#5A738E"><i class=" glyphicon glyphicon-plus"></i> {{ trans('app.MOT Test View') }}</a>
											</h4>
										</div>
										<div id="collapse2" class="panel-collapse collapse">
											<div class="panel-body">

											<!-- Step:1 Starting -->
												<div class=" col-md-12 col-xs-12 col-sm-12 panel-group pGroup">
													<div class="panel panel-default">
														<div class="panel-heading pHeading">
															<h4 class="panel-title">
																<a data-toggle="collapse" href="#collapse3" class="observation_Plus3" style="color:#5A738E"><i class="plus-minus glyphicon glyphicon-plus"></i> {{ trans('app.Step 1: Fill MOT Details') }}</a>
															</h4>
														</div>
														<div id="collapse3" class="panel-collapse collapse">
															<div class="panel-body">
																<div class=" col-md-12 col-xs-12 col-sm-12 panel-group pGroupInsideStep1">

																	<div class="row text-center">
																		<div class="col-md-3">
																			<h5 class="boldFont">{{ trans('app.OK = Satisfactory') }}</h5>
																		</div>
																		<div class="col-md-3">
																			<h5 class="boldFont">{{ trans('app.X = Safety Item Defact') }}</h5>
																		</div>
																		<div class="col-md-3">
																			<h5 class="boldFont">{{ trans('app.R = Repair Required') }}</h5>
																		</div>
																		<div class="col-md-3">
																			<h5 class="boldFont">{{ trans('app.NA = Not Applicable') }}</h5>
																		</div>
																	</div>

														<!-- Inside Cab  Starting -->
																	<div class="panel panel-default">
																		<div class="panel-heading pHeadingInsideStep1">
																			<h4 class="panel-title">
																				<a data-toggle="collapse" href="#collapse5" class="observation_Plus3" style="color:#5A738E"><i class="plus-minus glyphicon glyphicon-plus"></i> {{ trans('app.Inside Cab') }}</a>
																			</h4>
																		</div>
																		<div id="collapse5" class="panel-collapse collapse">
																			<div class="panel-body">


													@php
														$a = $b = '';
														$count = count($inspection_points_library_data);
														$count = $count/2;
													@endphp

								@foreach($inspection_points_library_data as $key => $inspection_library)

											@if($inspection_library->inspection_type == 1)

															@if( $key % 2 != 1 )
															<?php
																	$a .= "<tr>
																		<td>$inspection_library->code</td>
																		<td>$inspection_library->point</td>
																		<td>
																		<select name=inspection[$inspection_library->id] data-id='$inspection_library->id' class='common'  id='$inspection_library->code'>
																    		<option value='ok'>OK</option>
																    		<option value='x'>X</option>
																    		<option value='r'>R</option>
																    		<option value='na'>NA</option>
																  		</select>
																  		</td></tr>";
																?>
															@else
																<?php
																	$b .= "<tr>
																		<td>$inspection_library->code</td>
																		<td>$inspection_library->point</td>
																		<td>
																		<select name=inspection[$inspection_library->id] data-id='$inspection_library->id' class='common' id='$inspection_library->code'>
																    	<option value='ok'>OK</option>
																    	<option value='x'>X</option>
																    	<option value='r'>R</option>
																    	<option value='na'>NA</option>
																  		</select>
																  		</td>
																  		</tr>";
																?>
															@endif
											@endif
									@endforeach

																				<div class="col-md-6">
																					<table class="table">
																						<thead class="thead-dark">
																						<tr>
																							<th><b>{{ trans('app.Code') }}</b></th>
																							<th><b>{{ trans('app.Inspection Details') }}</b></th>
																							<th><b>{{ trans('app.Answer') }}</b></th>
																						</tr>
																						</thead>
																						<?php echo $a; ?>
																					</table>
																				</div>
																				<div class="col-md-6">
																					<table class="table">
																						<thead class="thead-dark smallDisplayTheadHiddenInsideCab">
																						<tr>
																							<th><b>{{ trans('app.Code') }}</b></th>
																							<th><b>{{ trans('app.Inspection Details') }}</b></th>
																							<th><b>{{ trans('app.Answer') }}</b></th>
																						</tr>
																						</thead>
																						<?php echo $b; ?>
																					</table>
																				</div>


																			</div>
																		</div>
																	</div>
														<!-- Inside Cab  Ending -->

																</div>

													<!-- Ground Level and Under Vehicle  Starting -->
																<div class=" col-md-12 col-xs-12 col-sm-12 panel-group pGroupInsideStep1">
																	<div class="panel panel-default">
																		<div class="panel-heading pHeadingInsideStep1">
																			<h4 class="panel-title">
																				<a data-toggle="collapse" href="#collapse6" class="observation_Plus3" style="color:#5A738E"><i class="plus-minus glyphicon glyphicon-plus"></i> {{ trans('app.Ground Level and Under Vehicle') }}</a>
																			</h4>
																		</div>
																		<div id="collapse6" class="panel-collapse collapse">
																			<div class="panel-body">
													@php
														$a = $b = '';
														$count = count($inspection_points_library_data);
														$count = $count/2;
													@endphp

								@foreach($inspection_points_library_data as $key => $inspection_library)

											@if($inspection_library->inspection_type == 2)

															@if( $key % 2 != 0 )
																<?php
																	$a .= "<tr>
																		<td>$inspection_library->code</td>
																		<td>$inspection_library->point</td>
																		<td>
																		<select name=inspection[$inspection_library->id] data-id='$inspection_library->id' class='common'  id='$inspection_library->code'>
																    		<option value='ok'>OK</option>
																    		<option value='x'>X</option>
																    		<option value='r'>R</option>
																    		<option value='na'>NA</option>
																  		</select>
																  		</td></tr>";
																?>
															@else
																<?php
																	$b .= "<tr>
																		<td>$inspection_library->code</td>
																		<td>$inspection_library->point</td>
																		<td>
																		<select name=inspection[$inspection_library->id] data-id='$inspection_library->id' class='common'  id='$inspection_library->code'>
																    	<option value='ok'>OK</option>
																    	<option value='x'>X</option>
																    	<option value='r'>R</option>
																    	<option value='na'>NA</option>
																  		</select>
																  		</td>
																  		</tr>";
																?>
															@endif
											@endif
									@endforeach

																				<div class="col-md-6">
																					<table class="table">
																						<thead class="thead-dark">
																						<tr>
																							<th><b>{{ trans('app.Code') }}</b></th>
																							<th><b>{{ trans('app.Inspection Details') }}</b></th>
																							<th><b>{{ trans('app.Answer') }}</b></th>
																						</tr>
																					</thead>
																						<?php echo $a; ?>
																					</table>
																				</div>
																				<div class="col-md-6">
																					<table class="table">
																						<thead class="thead-dark smallDisplayTheadHiddenGroundLevel">
																						<tr>
																							<th><b>{{ trans('app.Code') }}</b></th>
																							<th><b>{{ trans('app.Inspection Details') }}</b></th>
																							<th><b>{{ trans('app.Answer') }}</b></th>
																						</tr>
																						</thead>
																						<?php echo $b; ?>
																					</table>
																				</div>


																			</div>
																		</div>
																	</div>
																</div>
													<!-- Ground Level and Under Vehicle Ending -->

															</div>
														</div>
													</div>
												</div>
										<!-- Step 1: Ending -->

										<!-- Step 2: Show Filled MOT Details Starting -->
												<div class=" col-md-12 col-xs-12 col-sm-12 panel-group pGroup">
													<div class="panel panel-default">
														<div class="panel-heading pHeading">
															<h4 class="panel-title">
																<a data-toggle="collapse" href="#collapse4" class="observation_Plus3" style="color:#5A738E"><i class="plus-minus glyphicon glyphicon-plus"></i> {{ trans('app.Step 2: Show Filled MOT Details') }}</a>
															</h4>
														</div>
														<div id="collapse4" class="panel-collapse collapse">
															<div class="panel-body">

																<table class="table">
																	<thead class="thead-dark">
																		<tr>
																			<th><b>{{ trans('app.Code') }}</b></th>
																			<th><b>{{ trans('app.Inspection Details') }}</b></th>
																			<th><b>{{ trans('app.Answer') }}</b></th>
																		<tr>
																	</thead>

											@foreach($inspection_points_library_data as $key => $value)
													<thead>
														<tr style="display: none;" id="tr_{{$value->id}}">
															<td id="">
																{{ $value->id }}
															</td>
															<td id="">
																{{ $value->point }}
															</td>
															<td id="row_{{$value->id}}" class="text-uppercase">  </td>
														</tr>
													</thead>
											@endforeach
																</table>

															</div>
														</div>
													</div>
												</div>
								<!--Step 2: Show Filled MOT Details Ending -->

											</div>
										</div>
									</div>
								</div>

						<!-- ************* MOT Module Ending ************* -->




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
														<label><input type="{{$tbl_custom_field->type}}"  name="custom[{{$tbl_custom_field->id}}]" value="{{$k}}" <?php if($k == 0) {echo "checked"; } ?>>{{$val}}</label> &nbsp;
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
															<label><input type="{{$tbl_custom_field->type}}" name="custom[{{$tbl_custom_field->id}}][]" value="{{$val}}" isRequire="{{$required}}" fieldNameIs="{{ $tbl_custom_field->label }}" custm_isd="{{$tbl_custom_field->id}}" class="checkbox_{{$tbl_custom_field->id}} required_checkbox_{{$tbl_custom_field->id}} checkbox_simple_class common_value_is_{{$myCounts}} common_simple_class" rows_id="{{$myCounts}}" > {{ $val }}</label> &nbsp;
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

									<input type="hidden" name="_token" value="{{csrf_token()}}">

									<div class="form-group">
										<div class="col-md-12 col-sm-12 col-xs-12 text-center">
											<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
											<button type="submit" class="btn btn-success quotationSubmitButton">{{ trans('app.Submit')}}</button>
										</div>
									</div>
								</form>
						</div>
					</div>
				</div>
			</div>
		</div>

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


		<!-- vehicle model -->
		<div class="modal fade" id="vehiclemymodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="exampleModalLabel">Vehicle Details</h4>
					</div>

					<div class="row massage hide addvehiclemsg">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="checkbox checkbox-success checkbox-circle">
								<label for="checkbox-10 colo_success"> {{trans('app.Successfully Submitted')}}  </label>
							</div>
						</div>
					</div>

					<div class="modal-body">
						<form  action="" method="post" enctype="multipart/form-data"  class="form-horizontal upperform">
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<input type="hidden" name="customer_id" value="" class="hidden_customer_id">
							<div class="form-group" style="margin-top:20px;">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Vehicle Type')}} <label class="color-danger">*</label></label>
									<div class="col-md-3 col-sm-3 col-xs-12">
										<select class="form-control select_vehicaltype" id="vehical_id1" name="vehical_id"
										 vehicalurl="{!! url('/vehicle/vehicaltypefrombrand') !!}" required>
											<option value="">{{ trans('app.Select Vehicle Type')}}</option>
										 	@if(!empty($vehical_type))
												@foreach($vehical_type as $vehical_types)
													<option value="{{ $vehical_types->id }}">{{ $vehical_types->vehicle_type }}</option>
												@endforeach
											@endif
									    </select>
										<span class="color-danger" id="errorlvehical_id1"></span>
									</div>
									<div class="col-md-1 col-sm-1 col-xs-12 addremove">
										<button type="button" class="btn btn-default" data-target="#responsive-modal" data-toggle="modal">{{ trans('app.Add')}}</button>
									</div>
								</div>

								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Chasic No')}}</label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="chasicno" id="chasicno1" value="{{ old('chasicno') }}" placeholder="{{ trans('app.Enter ChasicNo')}}" maxlength="30" class="form-control">
										<span class="color-danger" id="errorlchasicno1"></span>
									</div>
								</div>
							</div>

						    <div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Vehicle Brand')}}<label class="color-danger">*</label></label>
									<div class="col-md-3 col-sm-3 col-xs-12">
										<select class="form-control   select_vehicalbrand" id="vehicabrand1" name="vehicabrand" >
											<option value="">Select Vehical Brand</option>
										 </select>
										 <span class="color-danger">
											<strong id="errorlvehicabrand1" ></strong>
										</span>
									</div>
									<div class="col-md-1 col-sm-1 col-xs-12 addremove">
										<button type="button" class="btn btn-default" data-target="#responsive-modal-brand" data-toggle="modal">{{ trans('app.Add')}}</button>
									</div>
								</div>

								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Model Years')}}</label>
									<div class="col-md-4 col-sm-4 col-xs-12 input-group date" id="myDatepicker2">
										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
										<input type="text"  name="modelyear" id="modelyear1"  class="form-control"/>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Fuel Type')}}</label>
									<div class="col-md-3 col-sm-3 col-xs-12">
										<select class="form-control select_fueltype" id="fueltype1" name="fueltype" >
											<option value="">{{ trans('app.Select fuel type')}} </option>
												@if(!empty($fuel_type))
													@foreach($fuel_type as $fuel_types)
														<option value="{{ $fuel_types->id }}">{{ $fuel_types->fuel_type }}</option>
													@endforeach
												@endif
										</select>
									</div>
									<div class="col-md-1 col-sm-1 col-xs-12 addremove">
										<button type="button" class="btn btn-default" data-target="#responsive-modal-fuel" data-toggle="modal">{{ trans('app.Add')}}</button>
									</div>
								</div>

								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.No of Grear')}}</label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="gearno" id="gearno1" value="{{ old('gearno') }}" placeholder="{{ trans('app.Enter No of Gear')}}" maxlength="5" class="form-control">
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Model Name')}} <label class="color-danger">*</label></label>
									<div class="col-md-3 col-sm-3 col-xs-12">
										<select class="form-control model_addname" id="modelname1" name="modelname" required>
											<option value="">{{ trans('app.Select Model Name')}}</option>
										@if(!empty($model_name))
											@foreach ($model_name as $model_names)
											<option value="{{ $model_names->model_name }}">{{ $model_names->model_name }}</option>
											@endforeach
										@endif
										</select>
										<span class="color-danger" id="errorlmodelname1"></span>
									</div>
									<div class="col-md-1 col-sm-1 col-xs-12 addremove">
										<button type="button" class="btn btn-default" data-target="#responsive-modal-vehi-model" data-toggle="modal">{{ trans('app.Add')}}</button>
									</div>
								</div>

								<div class="{{ $errors->has('price') ? ' has-error' : '' }}">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">
									{{ trans('app.Price' )}} (<?php echo getCurrencySymbols(); ?>) <label class="color-danger">*</label> </label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="price" id="price1"  value="{{ old('price') }}" placeholder="{{ trans('app.Enter Price')}}" class="form-control" maxlength="10">
										<span class="color-danger" id="ppe"></span>
										@if ($errors->has('price'))
										   <span class="help-block">
											   <strong>{{ $errors->first('price') }}</strong>
										   </span>
										@endif
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="{{ $errors->has('odometerreading') ? ' has-error' : '' }}">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Odometer Reading')}} </label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="odometerreading" id="odometerreading1" value="{{ old('odometerreading') }}" placeholder="{{ trans('app.Enter Odometer Reading')}}" maxlength="20"  class="form-control">
									</div>
								</div>

								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Date Of Manufacturing')}} </label>
									<div class="col-md-4 col-sm-4 col-xs-12 input-group date datepicker1">
										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
										<input type="text"  name="dom" id="dom1" class="form-control" placeholder="<?php echo getDatepicker();?>" onkeypress="return false;" />
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Gear Box')}}</label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="gearbox" id="gearbox1" value="{{ old('gearbox') }}" placeholder="{{ trans('app.Enter Grear Box')}}" maxlength="30" class="form-control">
									</div>
								</div>

								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Gear Box No')}}</label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="gearboxno" id="gearboxno1" value="{{ old('gearboxno') }}" placeholder="{{ trans('app.Enter Gearbox No')}}" maxlength="30" class="form-control" >
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Engine No')}}</label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="engineno"  id="engineno1" value="{{ old('engineno') }}" placeholder="{{ trans('app.Enter Engine No')}}" maxlength="30" class="form-control">
										<span class="color-danger" id="errorlengineno1"></span>
									</div>
								</div>

								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Engine Size')}}</label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="enginesize" id="enginesize1" value="{{ old('enginesize') }}" placeholder="{{ trans('app.Enter Engine Size')}}" maxlength="30" class="form-control" >
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Key No')}} </label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="keyno"  id="keyno1" value="{{ old('keyno') }}" placeholder="{{ trans('app.Enter Key No')}}" maxlength="30" class="form-control">
									</div>
								</div>

								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Engine')}} </label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="engine" id="engine1" value="{{ old('engine') }}" placeholder="{{ trans('app.Enter Engine')}}" maxlength="30" class="form-control">
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Number Plate')}} <label class="text-danger"></label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text" id="number_plate"  name="number_plate"  value="{{ old('number_plate') }}" placeholder="{{ trans('app.Enter Number Plate')}}" maxlength="30" class="form-control">
									</div>
								</div>

								<div class="my-form-group">
	                              	<label class="control-label col-md-2 col-sm-2 col-xs-12" for="branch">{{ trans('app.Branch')}} <label class="color-danger">*</label></label>

	                              	<div class="col-md-4 col-sm-4 col-xs-12">
	                                	<select class="form-control  select_branch_vehicle" id="
	                                	select_branch_vehicle" name="branch_vehicle">
	                                  	@foreach ($branchDatas as $branchData)
	                                    	<option value="{{ $branchData->id }}">{{$branchData->branch_name }}</option>
	                                  	@endforeach
	                                	</select>
	                              	</div>
                            	</div>
							</div>

							<div class="form-group col-md-12 col-sm-12 col-xs-12">
								<div class="col-md-12 col-sm-12 col-xs-12 text-center">
									<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
									<button type="button" class="btn btn-success addvehicleservice" >{{ trans('app.Submit')}}</button>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

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
												<label>{{ trans('app.Model Name :')}} <span class="text-danger">*</span></label>
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
									    <form class="form-horizontal formaction" action="" method="">
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
												<label>{{ trans('app.Vehicle Type:')}} <span class="text-danger">*</span></label>
												<input type="text" class="form-control vehical_type" name="vehical_type" id="vehical_type" placeholder="{{ trans('app.Enter Vehicle Type')}}" maxlength="20" required />
											</div>
											<div class="col-md-4 form-group data_popup" style="margin-top:24px;">

												<button type="button" class="btn btn-success vehicaltypeadd"
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
												<label>{{ trans('app.Vehicle Type:')}} <span class="text-danger">*</span></label>
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
												<label>{{ trans('app.Vehicle Brand:')}} <span class="text-danger">*</span></label>
												<input type="text" class="form-control vehical_brand" name="vehical_brand" id="vehical_brand" placeholder="{{ trans('app.Enter Vehicle brand')}}" maxlength="25" required />
											</div>
											<div class="col-md-4 form-group data_popup" style="margin-top:24px;">

												<button type="button" class="btn btn-success vehicalbrandadd"
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
												<label>{{ trans('app.Fuel Type:')}} <span class="text-danger">*</span></label>
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
	</div>
<!-- /page content -->


<!-- Scripts starting -->
<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

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



	/*vehical Type from brand*/
	$('.select_vehicaltype').change(function(){
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


	var msg100 = "{{ trans('app.An error occurred :')}}";

	/*vehicle add*/
	$('body').on('click','.addvehicleservice',function(event){

		function define_variable()
		{
			return {
				vehical_id1:$("#vehical_id1").val(),
				chasicno1:$("#chasicno1").val(),
				vehicabrand1:$("#vehicabrand1").val(),
				modelname1:$("#modelname1").val(),
				engineno1:$("#engineno1").val(),
				pp:$('#price1').val(),
				pricePattern:/^[0-9]*$/,
			};
		}

		event.preventDefault();
		var call_var_vehicleadd = define_variable();
		var errro_msg = [];
		//Vehicle type
		if(call_var_vehicleadd.vehical_id1 == "")
		{
			var msg = "Vehical type is required";
			$('#errorlvehical_id1').html(msg);
			errro_msg.push(msg);
			return false;
		}
		else
		{
			$('#errorlvehical_id1').html("");
			errro_msg = [];
		}
		//chasic number
		/*if(call_var_vehicleadd.chasicno1 == "")
		{
			var msg = "Chassis number is required";
			$('#errorlchasicno1').html(msg);
			errro_msg.push(msg);
			return false;
		}
		else
		{
			$('#errorlchasicno1').html("");
			errro_msg = [];
		}*/
		//Vehical brand
		if(call_var_vehicleadd.vehicabrand1 == "")
		{
			var msg = "Vehical brand is required";
			$('#errorlvehicabrand1').html(msg);
			errro_msg.push(msg);
			return false;
		}
		else
		{
			$('#errorlvehicabrand1').html("");
			errro_msg = [];
		}
		//Model name
		if(call_var_vehicleadd.modelname1 == "")
		{
			var msg = "Model name is required";
			$('#errorlmodelname1').html(msg);
			errro_msg.push(msg);
			return false;
		}
		else
		{
			$('#errorlmodelname1').html("");
			errro_msg = [];
		}
		//Engine number
		/*if(call_var_vehicleadd.engineno1 == "")
		{
			var msg = "Engine number is required";
			$('#errorlengineno1').html(msg);
			errro_msg.push(msg);
			return false;
		}
		else
		{
			$('#errorlengineno1').html("");
			errro_msg = [];
		}*/

		//Price
		if(call_var_vehicleadd.pp == "")
		{
			var msg = "Price is required";
			$('#ppe').html(msg);
			errro_msg.push(msg);
			return false;
		}
		else
		{
			$('#ppe').html("");
			errro_msg = [];
		}

		if(!call_var_vehicleadd.pp.replace(/\s/g, '').length){
        	var msg = "Only blank space not allowed";
        	$('#price1').val("");
			$('#ppe').html(msg);
			errro_msg.push(msg);
			return false;
        }
        else{
			$('#ppe').html("");
			errro_msg = [];
		}

		if(!call_var_vehicleadd.pricePattern.test(call_var_vehicleadd.pp)){
        	var msg = "Only numeric data allowed";
        	$('#price1').val("");
			$('#ppe').html(msg);
			errro_msg.push(msg);
			return false;
        }
        else{
			$('#ppe').html("");
			errro_msg = [];
		}

		if(errro_msg == "")
		{
			var vehical_id1 =$('#vehical_id1').val();
			var chasicno1 =$('#chasicno1').val();
			var vehicabrand1 =$('#vehicabrand1').val();
			var modelyear1 =$('#modelyear1').val();
			var fueltype1 =$('#fueltype1').val();
			var gearno1 =$('#gearno1').val();
			var modelname1 =$('#modelname1').val();
			var price1 =$('#price1').val();
			var odometerreading1 =$('#odometerreading1').val();
			var dom1 =$('#dom1').val();
			var gearbox1 =$('#gearbox1').val();
			var gearboxno1 =$('#gearboxno1').val();
			var engineno1 =$('#engineno1').val();
			var enginesize1 =$('#enginesize1').val();
			var keyno1 =$('#keyno1').val();
			var engine1 =$('#engine1').val();
			var numberPlate =$('#number_plate').val();
			var customer_id =$('.hidden_customer_id').val();
			var branch_id_vehicle = $('.select_branch_vehicle').val();

			$.ajax({

				type:'get',
				url:'{!! url('/service/vehicleadd')!!}',
				data:{vehical_id1:vehical_id1,chasicno1:chasicno1,vehicabrand1:vehicabrand1,modelyear1:modelyear1,fueltype1:fueltype1,gearno1:gearno1,modelname1:modelname1,price1:price1,odometerreading1:odometerreading1,dom1:dom1,gearbox1:gearbox1,gearboxno1:gearboxno1,engineno1:engineno1,enginesize1:enginesize1,keyno1:keyno1,engine1:engine1,numberPlate:numberPlate,customer_id:customer_id,branch_id_vehicle:branch_id_vehicle},
				success: function(data){

					var modelname1 =$('#modelname1').val();

					$('.modelnameappend').append('<option value='+data+'>'+modelname1+'</option>');
					var vehical_id1 =$('#vehical_id1').val('');
					var chasicno1 =$('#chasicno1').val('');
					var vehicabrand1 =$('#vehicabrand1').val('');
					var modelyear1 =$('#modelyear1').val('');
					var fueltype1 =$('#fueltype1').val('');
					var gearno1 =$('#gearno1').val('');
					var modelname1 =$('#modelname1').val('');
					var price1 =$('#price1').val('');
					var odometerreading1 =$('#odometerreading1').val('');
					var dom1 =$('#dom1').val('');
					var gearbox1 =$('#gearbox1').val('');
					var gearboxno1 =$('#gearboxno1').val('');
					var engineno1 =$('#engineno1').val('');
					var enginesize1 =$('#enginesize1').val('');
					var keyno1 =$('#keyno1').val('');
					var engine1 =$('#engine1').val('');
					var number_plate =$('#number_plate').val('');
					$(".addvehiclemsg").removeClass("hide");


				},
				error: function(e){
					alert(msg31 + " " + e.responseText);
							console.log(e);
				}
			});
		}
	});


	var msg10 = "{{ trans('app.Please enter only alphanumeric data')}}";
	var msg11 = "{{ trans('app.Only blank space not allowed')}}";
	var msg12 = "{{ trans('app.This Record is Duplicate')}}";

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
			swal(msg10);
		}
        else if(!model_name.replace(/\s/g, '').length){
			$('.vehi_modal_name').val("");
        	swal(msg11);
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

				success:function(data)
				{
					var newd = $.trim(data);
					var classname = 'mod-'+newd;
				if(newd == '01')
				{
					swal(msg12);
				}
				else
				{
					$('.vehi_model_class').append('<tr class="'+classname+'"><td class="text-center">'+model_name+'</td><td class="text-center"><button type="button" modelid='+data+' deletemodel="{!! url('/vehicle/vehicle_model_delete') !!}" class="btn btn-danger btn-xs modeldeletes">X</button></a></td><tr>');
					$('.model_addname').append('<option value="'+model_name+'">'+model_name+'</option>');
					$('.vehi_modal_name').val('');
				}
				},
			});
		}
	});




	$('body').on('click','.modeldeletes',function()
	{
		var mod_del_id = $(this).attr('modelid');
		var del_url = $(this).attr('deletemodel');

		var msg1 = "{{ trans('app.Are You Sure?')}}";
	    var msg2 = "{{ trans('app.You will not be able to recover this data afterwards!')}}";
	    var msg3 = "{{ trans('app.Cancel')}}";
	    var msg4 = "{{ trans('app.Yes, delete!')}}";
	    var msg5 = "{{ trans('app.Done!')}}";
	    var msg6 = "{{ trans('app.It was succesfully deleted!')}}";
	    var msg7 = "{{ trans('app.Cancelled')}}";
	    var msg8 = "{{ trans('app.Your data is safe')}}";

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
						url:del_url,
						data:{mod_del_id:mod_del_id},
						success:function(data)
						{
							$('.mod-'+mod_del_id).remove();
							$(".model_addname option[value="+mod_del_id+"]").remove();
							swal(msg5, msg6,"success");
						}
				});
			}else{
				swal(msg7, msg8, "error");
			}
		})
	});


	/*vehicle type*/
	$('.vehicaltypeadd').click(function()
	{

		var vehical_type= $('.vehical_type').val();
		var url = $(this).attr('url');

		var msg13 = "{{ trans('app.Please enter vehicle type')}}";
		var msg14= "{{ trans('app.Please enter only alphanumeric data')}}";
		var msg15 = "{{ trans('app.Only blank space not allowed')}}";
		var msg16 = "{{ trans('app.This Record is Duplicate')}}";

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
        else
        {
			$.ajax({
				type:'GET',
				url:url,
				data :{vehical_type:vehical_type},
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
			   	},
			});
		}
	});



	/*vehical Type delete*/
	$('body').on('click','.deletevehicletype',function(){

		var vtypeid = $(this).attr('vehicletypeid');
		var url = $(this).attr('deletevehical');

		var msg1 = "{{ trans('app.Are You Sure?')}}";
	    var msg2 = "{{ trans('app.You will not be able to recover this data afterwards!')}}";
	    var msg3 = "{{ trans('app.Cancel')}}";
	    var msg4 = "{{ trans('app.Yes, delete!')}}";
	    var msg5 = "{{ trans('app.Done!')}}";
	    var msg6 = "{{ trans('app.It was succesfully deleted!')}}";
	    var msg7 = "{{ trans('app.Cancelled')}}";
	    var msg8 = "{{ trans('app.Your data is safe')}}";

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
			if (isConfirm)
			{
				$.ajax({
					type:'GET',
					url:url,
					data:{vtypeid:vtypeid},
					success:function(data)
					{
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
		var msg19 = "{{ trans('app.Please enter only alphanumeric data')}}";
		var msg20 = "{{ trans('app.Only blank space not allowed')}}";
		var msg21 = "{{ trans('app.This Record is Duplicate')}}";

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
				swal(msg19);

			}
	        else if(!vehical_brand.replace(/\s/g, '').length){
	       		// var str = "    ";
				$('.vehical_brand').val("");
	        	swal(msg20);
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
				   	success:function(data)
	               	{
				       	var newd = $.trim(data);
					   	var classname = 'del-'+newd;

					   	if (newd == "01")
				       	{
				 	     	swal(msg21);
					   	}
					   	else
					   	{
					   		$('.vehical_brand_class').append('<tr class="'+classname+'"><td class="text-center">'+vehical_brand+'</td><td class="text-center"><button type="button" brandid='+data+' deletevehicalbrand="{!! url('vehicle/vehicalbranddelete') !!}" class="btn btn-danger btn-xs deletevehiclebrands">X</button></a></td><tr>');

							$('.select_vehicalbrand').append('<option value='+data+'>'+vehical_brand+'</option>');

							$('.vehical_brand').val('');
						}
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

		var msg1 = "{{ trans('app.Are You Sure?')}}";
	    var msg2 = "{{ trans('app.You will not be able to recover this data afterwards!')}}";
	    var msg3 = "{{ trans('app.Cancel')}}";
	    var msg4 = "{{ trans('app.Yes, delete!')}}";
	    var msg5 = "{{ trans('app.Done!')}}";
	    var msg6 = "{{ trans('app.It was succesfully deleted!')}}";
	    var msg7 = "{{ trans('app.Cancelled')}}";
	    var msg8 = "{{ trans('app.Your data is safe')}}";

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



  	var today = new Date();
  	var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    var dateTime = date+' '+time;

    $(".datepicker").datetimepicker({
		format: "<?php echo getDatetimepicker(); ?>",
		autoclose:true,
		todayBtn: true,
		startDate : dateTime
    });


    $(".datepickercustmore").datetimepicker({
		format: "<?php echo getDatepicker(); ?>",
		autoclose: 1,
		minView: 2,
		endDate: new Date(),
	});


    $('.datepicker1').datetimepicker({
       format: "<?php echo getDatepicker(); ?>",
		autoclose: 1,
		minView: 2,
    });


    $('#myDatepicker2').datetimepicker({
       format: "yyyy",
		autoclose: 2,
		minView: 4,
		startView: 4,
    });


    $(function() {
        $("input[name='service_type']").click(function () {
            if ($("#paid").is(":checked")) {
                $("#dvCharge").show();
                $("#charge_required").attr('required', true);
            } else {
                $("#dvCharge").hide();
				$("#charge_required").removeAttr('required', false);
            }
        });
    });



	var msg1 = "{{ trans('app.Alert')}}";
	var msg2 = "{{ trans('app.Please select customer!')}}";

	$('body').on('change','.select_vhi',function(){

		var url = $(this).attr('cus_url');
		var cus_id = $(this).val();
		var modelnms = $(this).val();

		$.ajax({

			type:'GET',
			url:url,
			data:{cus_id:cus_id,modelnms:modelnms},
			success:function(response)
			{

				$('.modelnms').remove();
				$('#vhi').append(response);
			}

		});
	});


	$('body').on('click','#vhi',function(){

		var cus_id = $('.select_vhi').val();

		if(cus_id =="")
		{
			swal({
				title: msg1,
				text: msg2

				});
				return false;
		}
	});



	/*If vehicle add when customer is selected otherwise not add vehicle*/
	$('body').on('click','.vehiclemodel',function(){

		var cus_id = $('.select_vhi').val();

		if(cus_id == "")
		{
			swal({
					title: msg1,
					text: msg2
				});
			return false;
		}
		else {
			$('#vehiclemodel').modal();
		}
	});


	$('body').on('change','#vhi',function()
	{
		var vehi_id =  $('.modelnms:selected').val();
		var url = '{{ url('service/getregistrationno')}}';
		$.ajax({
			type:'GET',
			url:url,
			data:{vehi_id:vehi_id},
			success:function(response)
			{
				var res = $.trim(response);
				if(res == "")
				{
					$('#reg_no').val(res);
					$('#reg_no').removeAttr('readonly');
				}
				else
				{
					$('#reg_no').val(res);
					$('#reg_no').attr('readonly',true);
				}
			}
		});
	});




	/*Fuel type*/
	$('.fueltypeadd').click(function(){

		var fuel_type= $('.fuel_type').val();
		var url = $(this).attr('fuelurl');

        var msg21 = "{{ trans('app.Please enter fuel type')}}";
		var msg22 = "{{ trans('app.Please enter only alphanumeric data')}}";
		var msg23 = "{{ trans('app.Only blank space not allowed')}}";
		var msg24 = "{{ trans('app.This Record is Duplicate')}}";
		var msg25 = "{{ trans('app.An error occurred :')}}";

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
			swal(msg22);

		}
        else if(!fuel_type.replace(/\s/g, '').length){
       		// var str = "    ";
			$('.fuel_type').val("");
        	swal(msg23);
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
			   	success:function(data)
			   	{
			       	var newd = $.trim(data);
				   	var classname = 'del-'+newd;

				   	if(newd == '01')
				   	{
					   	swal(msg24);
				   	}
				   	else
				   	{
				    	$('.fuel_type_class').append('<tr class="'+classname+'"><td class="text-center">'+fuel_type+'</td><td class="text-center"><button type="button" fuelid='+data+' deletefuel="{!! url('/vehicle/fueltypedelete') !!}" class="btn btn-danger btn-xs fueldeletes">X</button></a></td><tr>');

						$('.select_fueltype').append('<option value='+data+'>'+fuel_type+'</option>');

						$('.fuel_type').val('');
				   	}
			   	},
			});
		}
	});

	/*Using Slect2 make auto searchable dropdown*/
 	//var sendUrl = '{{ url('service/customer_autocomplete_search') }}';

	/*$('.select_customer_auto_search').select2({
    	ajax: {
        	url: sendUrl,
        	dataType: 'json',
        	delay: 250,
        	processResults: function (data) {
            	return {
                	results: $.map(data, function (item) {
                    	return {
                        	text: item.name +" "+ item.lastname,
                        	id: item.id
                    	};
                	})
            	};
        	},
        	cache: true
    	}
	});*/

   	// Initialize select2
   	$(".select_customer_auto_search").select2();



	/*If date field have value then error msg and has error class remove*/
	$('body').on('change','#p_date',function(){

		var pDateValue = $(this).val();

		if (pDateValue != null) {
			$('#p_date-error').css({"display":"none"});
		}

		if (pDateValue != null) {
			$(this).parent().parent().removeClass('has-error');
		}
	});


	/*If select box have value then error msg and has error class remove*/
	$('#sup_id').on('change',function(){

		var supplierValue = $('select[name=Customername]').val();

		if (supplierValue != null) {
			$('#sup_id-error').css({"display":"none"});

			/*If select customer after customer id assigned to vehicle add form customer_id inputbox*/
			$('.hidden_customer_id').val(supplierValue);
		}

		if (supplierValue != null) {
			$(this).parent().parent().removeClass('has-error');
		}
	});



	/*MOT main Accordian fade in out*/
	var i = 0;
	$('.observation_Plus2').click(function(){
		i = i+1;
		if(i%2!=0){
			$(this).parent().find(".glyphicon-plus:first").removeClass("glyphicon-plus").addClass("glyphicon-minus");

		}else{
			$(this).parent().find(".glyphicon-minus:first").removeClass("glyphicon-minus").addClass("glyphicon-plus");
		}
	});


	/*This for Step:1 and Step:1 Accordion of MoT View*/
	$(function() {
	  	function toggleIcon(e) {
	      	$(e.target)
	          	.prev('.pHeading')
	          	.find(".plus-minus")
	          	.toggleClass('glyphicon-plus glyphicon-minus');
	  	}
	  	$('.pGroup').on('hidden.bs.collapse', toggleIcon);
	  	$('.pGroup').on('shown.bs.collapse', toggleIcon);
	});

	/*This for InsideCab and GroundLevelUnderVehicle Accordion*/
	$(function() {
	  	function toggleIcon(e) {
	      	$(e.target)
	          	.prev('.pHeadingInsideStep1')
	          	.find(".plus-minus")
	          	.toggleClass('glyphicon-plus glyphicon-minus');
	  	}
	  	$('.pGroupInsideStep1').on('hidden.bs.collapse', toggleIcon);
	  	$('.pGroupInsideStep1').on('shown.bs.collapse', toggleIcon);
	});



	/*If MOT check box is checked then show all MOT details otherwise not*/
	$('body').on('click', '#motTestStatusCheckbox', function(){

      	if($('input[name="motTestStatusCheckbox"]').is(':checked'))
		{
			$('.motMainPart').css({"display":""});
			$('.motMainPart-1').css({"display":""});
		}
		else
		{
			$('.motMainPart').css({"display":"none"});
			$('.motMainPart-1').css({"display":"none"});
		}
   	});

	/*For display data from 'InsideCab  And Ground Level Under Vehicle' accordion to Step:2 Accordion*/
	$('.common').change(function(e) {

        var selectBoxValue = $(this,':selected').val();
        var id = $(this).attr('data-id');

        if (selectBoxValue == "r" || selectBoxValue == "x") {
        	$('#tr_'+id).css("display","");
        	$('#row_'+id).html(selectBoxValue);
        }
        else
        {
        	$('#tr_'+id).css("display","none");
        }
	});


	/*Inside fix service text box only enter numbers data*/
	$('.fixServiceCharge').on('keyup', function(){

		var valueIs = $(this).val();

	 	if (/\D/g.test(valueIs))
		{
			$(this).val("");
		}
		else if(valueIs == 0)
		{
			$(this).val("");
		}
	});


	/*If firstly enter any whitespace then clear textbox*/
	$('body').on('keyup', '#firstname', function(){

      	var firstname = $(this).val();

      	if (!firstname.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

   	$('body').on('keyup', '#lastname', function(){

      	var lastname = $(this).val();

      	if (!lastname.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

   	$('body').on('keyup', '#displayname', function(){

      	var displayname = $(this).val();

      	if (!displayname.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

   	$('body').on('keyup', '#company_name', function(){

      	var company_name = $(this).val();

      	if (!company_name.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

   	$('body').on('keyup', '#mobile', function(){

      	var mobile = $(this).val();

      	if (!mobile.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

   	$('body').on('keyup', '#landlineno', function(){

      	var landlineno = $(this).val();

      	if (!landlineno.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

   	$('body').on('keyup', '#address', function(){

      	var address = $(this).val();

      	if (!address.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

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


   	$('body').on('keyup', '#chasicno1', function(){

      	var chasicno1 = $(this).val();

      	if (!chasicno1.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

   	$('body').on('keyup', '#gearno1', function(){

      	var gearno1 = $(this).val();

      	if (!gearno1.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

    $('body').on('keyup', '#price1', function(){

      	var price1 = $(this).val();

      	if (!price1.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

    $('body').on('keyup', '#odometerreading1', function(){

      	var odometerreading1 = $(this).val();

      	if (!odometerreading1.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

    $('body').on('keyup', '#gearbox1', function(){

      	var gearbox1 = $(this).val();

      	if (!gearbox1.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

   	$('body').on('keyup', '#gearboxno1', function(){

      	var vehi_modal_nameVal = $(this).val();

      	if (!vehi_modal_nameVal.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

   	$('body').on('keyup', '#engineno1', function(){

      	var engineno1 = $(this).val();

      	if (!engineno1.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

    $('body').on('keyup', '#enginesize1', function(){

      	var enginesize1 = $(this).val();

      	if (!enginesize1.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

    $('body').on('keyup', '#engine1', function(){

      	var engine1 = $(this).val();

      	if (!engine1.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

   	$('body').on('keyup', '#keyno1', function(){

      	var keyno1 = $(this).val();

      	if (!keyno1.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

   	$('body').on('keyup', '#number_plate', function(){

      	var number_plate = $(this).val();

      	if (!number_plate.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});


   	$('body').on('keyup', '.titalQuotation', function(){

      	var titalQuotation = $(this).val();

      	if (!titalQuotation.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

   	$('body').on('keyup', '#details', function(){

      	var details = $(this).val();

      	if (!details.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

	/*Custom Field manually validation*/
	var msg31 = "{{ trans('app.field is required')}}";
	var msg32 = "{{ trans('app.Only blank space not allowed')}}";
	var msg33 = "{{ trans('app.Special symbols are not allowed.')}}";
	var msg34 = "{{ trans('app.At first position only alphabets are allowed.')}}";

	/*Form submit time check validation for Custom Fields */
	$('body').on('click','.quotationSubmitButton',function(e){
		$('#QuotationAdd-Form input, #QuotationAdd-Form select, #QuotationAdd-Form textarea').each(

		    function(index)
		    {
		        var input = $(this);

		        if (input.attr('name') == "Customername" || input.attr('name') == "vehicalname" || input.attr('name') == "date" || input.attr('name') == "repair_cat" || input.attr('name') == "service_type") {
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


		/*if washbay checkbox is checked then washbay charge textbox is required*/
		var washbay_trans = "{{ trans('app.Wash Bay Charge')}}";
		var washbay_value = $('#washBayCharge_required').val();

		if ($(".washBayCheckbox").is(':checked') == true)
		{
			if (washbay_value == "")
			{
				//alert("is checked true : ");
				$('#washBayCharge').addClass('has-error');
				$('#washbay_error_span').text(washbay_trans + " " + msg31);
				$('#washbay_error_span').css({"display":""});
				e.preventDefault();
			}
		}

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


	/*Wash-bay service charge textbox*/
	var isCheckWashbay = $(".washBayCheckbox").is(':checked');

	if (isCheckWashbay == true)
    {
       	$("#washBayCharge").show();
       	$("#washBayCharge_required").attr('required', true);
    }
    else
    {
        $("#washBayCharge").hide();
		$("#washBayCharge_required").removeAttr('required', false);
    }

	$('.washBayCheckbox').click(function () {

		if ($("#washBay").is(":checked"))
    	{
        	$("#washBayCharge").show();
        	$("#washBayCharge_required").attr('required', true);
        }
        else
        {
           	$("#washBayCharge").hide();
			$("#washBayCharge_required").removeAttr('required', false);
        }
    });


    $('body').on('keyup','.washbay_charge_textbox',function(){

		var washbayVal = $(this).val();
		var numericDataWashbayMsg = "{{ trans('app.Only numeric data allowed.')}}";
		var washbay_trans = "{{ trans('app.Wash Bay Charge')}}";

		if (washbayVal != "")
    	{
        	if(!washbayVal.match(/^[1-9][0-9]*$/))
	    	{
	    		$(this).val("");
	    		$('#washbay_error_span').text(numericDataWashbayMsg);
				$('#washbay_error_span').css({"display":""});
				$('#washBayCharge').addClass('has-error');
	    	}
	    	else
	    	{
				$('#washbay_error_span').css({"display":"none"});
				$('#washBayCharge').removeClass('has-error');
	    	}
        }
        else
        {
           	$('#washBayCharge').addClass('has-error');
			$('#washbay_error_span').text(washbay_trans + " " + msg31);
			$('#washbay_error_span').css({"display":""});
        }
    });

});
</script>


<!-- Form field validation -->
{!! JsValidator::formRequest('App\Http\Requests\StoreQuotationAddEditFormRequest', '#QuotationAdd-Form'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>

<!-- Form submit at a time only one -->
<script type="text/javascript">
    /*$(document).ready(function () {
        $('.serviceSubmitButton').removeAttr('disabled'); //re-enable on document ready
    });
    $('.serviceAddForm').submit(function () {
        $('.serviceSubmitButton').attr('disabled', 'disabled'); //disable on any form submit
    });

    $('.serviceAddForm').bind('invalid-form.validate', function () {
      $('.serviceSubmitButton').removeAttr('disabled'); //re-enable on form invalidation
    });*/
</script>

@endsection