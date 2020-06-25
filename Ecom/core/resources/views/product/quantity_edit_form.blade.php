<!-- Product Quantity Starts -->
<h2 class="card-inside-title">
    Product Quantity
    <small>Edit item Count, Quantity, Unit, Price, Offer here</small>
</h2>
<div id="quantity">
    <table class="table table-responsive" id="product_quantity_table">
        <tbody>

            @if($productQuantities)
            @foreach($productQuantities as $indexKey => $productQuantity)
            <tr>
                <td>
                    @php $index = $indexKey @endphp
                    <input type="hidden" name="quantity_id[{{$index}}]" value="{{ $productQuantity->quantity_id }}">
                    <br />
                    <div class="row clearfix">
                        <div class="col-sm-2">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input min="1" type="number" class="form-control"
                                        name="items_multiplier[{{$index}}]"
                                        value="{{ $productQuantity->items_multiplier }}" required>
                                    <label class="form-label">Product Count*</label>
                                </div>
                                <div class="help-info">The number of items</div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <input min="0.1" type="number" class="form-control"
                                        name="product_quantity[{{$index}}]"
                                        value="{{ $productQuantity->product_quantity }}" required>
                                    <label class="form-label">Product Quantity*</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2" id="unit_dropdown">
                            <div class="form-group">
                                <select class="form-control show-tick selectUnit" name="unit_id[{{$index}}]"
                                    id="unit_dropdown_sel" required>
                                    <option value="">Select Unit*</option>
                                    @foreach($units as $indexKey => $unit)
                                    <option value="{{ $unit->unit_id }}" @if ($unit->unit_id ==
                                        $productQuantity->unit_id)
                                        selected="selected"
                                        @endif
                                        >
                                        {{ $unit->unit_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <input min="0" type="number" class="form-control" name="product_price[{{$index}}]"
                                        value="{{ $productQuantity->product_price }}" equired>
                                    <label class="form-label">Product Price*</label>
                                </div>
                                <div class="help-info">Add final price(without offer)</div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <input min="0" type="number" class="form-control"
                                        name="product_offer_percent[{{$index}}]"
                                        value="{{ $productQuantity->product_offer_percent }}" required>
                                    <label class="form-label">Product Offer(%)</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="checkbox" name="quantity_in_stock[{{$index}}]"
                                    id="quantity_in_stock_{{ $index }}" class="filled-in"
                                    {{ ($productQuantity->in_stock == 1) ? 'checked' : '' }}>
                                <label for="quantity_in_stock_{{ $index }}">In Stock</label>
                            </div>
                        </div>
                        {{--
                        <div class="col-sm-2">
                            <button type="button" name="add" id="add" class="btn bg-teal waves-effect">Add More</button>
                        </div>
                        --}}
                    </div>
                </td>
            </tr>
            @endforeach @endif

        </tbody>
    </table>
</div>
<!-- Product Quantity Ends -->
