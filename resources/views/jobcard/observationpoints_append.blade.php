<?php foreach ($data as $datas) { ?>
             <tr class="obs_point_data" id="<?php echo "row_id_delete_".$i; ?>">
				<td>
					<input type="text"  name="product2[category][]" class="form-control" value="<?php echo $datas->checkout_subpoints;?>" readonly="true">
					<input type="hidden" name="pro_id_delete" class="del_pro_<?php echo $i;?>" id="del_pro_<?php echo $i;?>" value="<?php echo $datas->id;?>">
				</td>
					
				<td>
					<input type="text" name="product2[sub_points][]" class="form-control" value="<?php echo $datas->checkout_point;?>" readonly="true">
				</td>
					
				<td>
					<select name="product2[product_id][]" class="form-control product_ids product1s_{{$i}}"  url="{{ url('/jobcard/getprice') }}" row_did="{{$i}}" id="product1s_{{$i}}" qtyappend="" required >
						<option value="">{{ trans('app.Select Product')}}</option>
							<?php  foreach($product as $products)
							{ 
								if($products->id == $datas->product_id)
								{
									$is_select = "selected";
								}
								else
								{
									$is_select = "";
								}
							?>	
								<option value="<?php echo $products->id;?>"  <?php echo $is_select; ?> ><?php echo $products->name;?></option> 
						<?php } ?> 										
					</select>
				</td>
				
				<td>
					<input type="text" name="product2[price][]" value="<?php if(!empty($data)){ echo $datas->price; } ?>" value="<?php echo $products->price; ?>" class="form-control prices rate product1_<?php echo $i; ?> product1_<?php echo $i; ?> price_<?php echo $i; ?>" id="product1_<?php echo $i; ?>" row_id="{{$i}}" maxlength="8" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">		
					<span id="purchase_price_error_msg_<?php echo $i; ?>" style="color:red;"></span>
				</td>
				
				<td> 
					<input type="number" min="0" oninput="this.value = Math.abs(this.value)" name="product2[qty][]" class="form-control qtyt qnt_<?php echo $i; ?> <?php echo "qty_".$i; ?>" row_id1="<?php echo $i; ?>" value="<?php if(!empty($data)){ echo $datas->quantity; } ?>"  url="<?php echo url('/jobcard/gettotalprice') ?>" id="<?php echo "qty_".$i; ?>" style="width:100%;float:left;" required >
					<span class="unit_<?php echo $i; ?>"></span>
				</td>
				
				<td>
					<input type="text" name="product2[total][]" value="<?php if(!empty($data)){ echo $datas->total_price; } ?>" value="0" class="form-control total1 total1_<?php echo $i; ?>" id="total1_<?php echo $i; ?>"  readonly="true"/>
				</td>
					
				<td>
					{{ trans('app.Yes:')}} <input type="radio" name="yesno_[]<?php echo $i;?>" class="yes_no" value="1" <?php if($datas->chargeable == 1) { echo "checked"; } ?> style=" height:13px; width:20px; margin-right:5px;" >
						
					{{ trans('app.No:')}} <input type="radio" name="yesno_[]<?php echo $i;?>" class="yes_no" value="0" <?php if($datas->chargeable == 0) { echo "checked"; } ?> style="height:13px; width:20px;">
				</td>
				<td>
					<textarea name="product2[comment][]" class="form-control" maxlength="250">{{$datas->category_comments }}</textarea> 
				</td>
				<td class="text-center">
					<i class="fa fa-trash fa-2x delete" style="cursor: pointer;" data_id_trash = "<?php echo $i; ?>" delete_data_url=" <?php echo url('/jobcard/delete_on_reprocess') ?>" service_id="<?php echo $s_id; ?>"></i>
					<input type="hidden" name="obs_id[]" class="form-control" value="<?php echo $datas->id;?>">
				</td>
			</tr>

			<?php } ?>
