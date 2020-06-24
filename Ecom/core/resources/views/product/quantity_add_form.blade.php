<!-- Product Quantity Starts -->
@if(!isset($is_show_quantity) || !$is_show_quantity)
<h2 class="card-inside-title">
	<!-- Product Quantity -->
	<small>Add item Count, Quantity, Unit, Price, Offer here</small>
</h2>
@endif
<input type="hidden" name="quantity_id" value="{{ $value ?? '' }}" >
<div id="quantity">
	<table class="table table-responsive" id="product_quantity_table">
		<tbody>
			<tr>
				<td>
					<br/>
					<div class="row clearfix">
						<div class="col-sm-2">
							<div class="form-group form-float">
								<div class="form-line">
									<input min="1" type="number" class="form-control" name="items_multiplier[0]" value="1" required>
									<label class="form-label">Product Count<span class="col-pink">*</span></label>
								</div>
								<div class="help-info">The number of items</div>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group form-float">
								<div class="form-line focused">
									<input min="0.1" type="number" class="form-control" name="product_quantity[0]" required>
									<label class="form-label">Product Quantity<span class="col-pink">*</span></label>
								</div>
							</div>
						</div>
						<div class="col-sm-2" id="unit_dropdown">
							<div class="form-group">
								<select class="form-control show-tick selectPick selectUnit" name="unit_id[0]" id="unit_dropdown_sel" required>
									<option value="">Select Unit<span class="col-pink">*</span></option>
									@foreach($units as $indexKey => $unit)
									<option value="{{ $unit->unit_id }}">
										{{ $unit->unit_name }}
									</option> 
									@endforeach 
								</select>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group form-float">
								<div class="form-line focused">
									<input min="0" type="number" class="form-control" name="product_price[0]" required>
									<label class="form-label">Product Price<span class="col-pink">*</span></label>
								</div>
								<div class="help-info">Add final price(without offer)</div>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group form-float">
								<div class="form-line focused">
									<input min="0" type="number" class="form-control" name="product_offer_percent[0]" value="0" required>
									<label class="form-label">Product Offer(%)</label>
								</div>
							</div>
						</div>
						<div class="col-sm-2">
							<button type="button" name="add" id="add" class="btn bg-green waves-effect">+</button>
						</div>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<!-- Product Quantity Ends -->