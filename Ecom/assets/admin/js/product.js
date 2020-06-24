
$(document).ready(function() {
  var count=1;
  $(document).on('click', '#add', function() {
		productQuantityField();
	});

	$(document).on('click', '.remove', function() {
		$(this).closest("tr").remove();
		count--;
	});

	function productQuantityField() {
		html_row_start = '<tr class="product_quantity_dyn"><td><br/><div class="row clearfix">';
		html_row_end = '</td></tr></div>';

		html_div_start = '<div class="col-sm-2">'
				    							+'<div class="form-group form-float">';
		html_div_end   =  '</div>'
		    						+'</div>'; 
    //Product Count
		html_input =  html_div_start
		    						+'<div class="form-line focused">'
		    							+'<input min="1" type="number" class="form-control" name="items_multiplier['+count+']" value="1" required>'
		    							+'<label class="form-label">Product Count<span class="col-pink">*</span></label>'
		    						+'</div>'
		    						+'<div class="help-info">The number of items</div>'
		    				  +html_div_end;

		//Product Quantity
		html_input += html_div_start
										+'<div class="form-line focused">'
											+'<input min="0.1" type="number" class="form-control" name="product_quantity['+count+']" required>'
											+'<label class="form-label">Product Quantity<span class="col-pink">*</span></label>'
										+'</div>'
									+html_div_end;

		var unit_options = "";
		$('#unit_dropdown_sel').find('option').each(function() {
		    unit_options += '<option value="'+$(this).val()+'">'+$(this).text()+'</option> ';
		});
		html_input += '<div class="col-sm-2">'
										+'<div class="form-group">'
											+'<select class="form-control selectUnit show-tick" name="unit_id['+count+']" required>'
												+unit_options
											+'</select>'
										+'</div>'
									+'</div>';

		//Product Price
		html_input  +=	html_div_start
			    					+'<div class="form-line focused">'
			    						+'<input min="0" type="number" class="form-control" name="product_price['+count+']" required>'
			    						+'<label class="form-label">Product Price<span class="col-pink">*</span></label>'
			    						+'</div>'
			    					+'<div class="help-info">Add final price(without offer)</div>'
			    				+html_div_end;

		//Product Offer
		html_input +=	html_div_start
			    					+'<div class="form-line focused">'
			    						+'<input min="0" type="number" class="form-control" name="product_offer_percent['+count+']" value="0" required>'
			    						+'<label class="form-label">Product Offer(%)</label>'
			    					+'</div>'
			    				+html_div_end;

		html_input +=	'<div class="col-sm-2">'
			    					+'<button type="button" name="remove" class="btn btn-danger waves-effect remove">X</button>'
			    				+'</div>';	

    html = html_row_start+html_input+html_row_end;
		$('#product_quantity_table tbody').append(html);
    count++;    
		$('.selectUnit').selectpicker('refresh');
	}// End of productQuantityField()
  

	$('#submit_btn').on('click', function(event) {
		event.preventDefault();
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});

		var form = document.getElementById("product_form");
    var formData = new FormData(form);
	 
		$.ajax({
			url:$('#product_form').attr('action'),
			method:'post',
			type:'post',
			data: formData,
			dataType:'json',
			cache: false,
      processData: false,
      contentType: false,
			beforeSend:function() {
				$('#pre_loader').show();
				$('#submit_btn').attr('disabled','disabled');
			},
			success:function(data) {
				$('#pre_loader').hide();
				$('#submit_btn').attr('disabled', false);
				if(data.error) {
					var error_html = '';
					for(var count = 0; count < data.error.length; count++) {
						error_html += '<p>'+data.error[count]+'</p>';
					}
					showNotify(error_html, 'alert-danger');
					$('#call_result').html('<div class="alert bg-red alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+error_html+'</div>');
				} else {
					$("#product_form").trigger("reset");
					showNotify(data.success, 'alert-success');
					$('#call_result').html('<div class="alert bg-green alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.success+'</div>');
				  setTimeout(function(){
			        location.reload();
			    }, 1000);  
				}
			},
			error: function (xhr, text, error) {
				$('#pre_loader').hide();
				$('#submit_btn').attr('disabled', false);
		    showNotify('Error: ' + error, 'alert-danger');
		  }
		})
	});

	$('#update_btn').on('click', function(event) {
		event.preventDefault();
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});

		var form = document.getElementById("product_form");
    var formData = new FormData(form);
	 
		$.ajax({
			url:$('#product_form').attr('action'),
			method:'post',
			type:'post',
			data: formData,
			dataType:'json',
			cache: false,
      processData: false,
      contentType: false,
			beforeSend:function() {
				$('#pre_loader').show();
				$('#update_btn').attr('disabled','disabled');
			},
			success:function(data) {
				$('#pre_loader').hide();
				$('#update_btn').attr('disabled', false);
				if(data.error) {
					var error_html = '';
					for(var count = 0; count < data.error.length; count++) {
						error_html += '<p>'+data.error[count]+'</p>';
					}
					showNotify(error_html, 'alert-danger');
					$('#call_result').html('<div class="alert bg-red alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+error_html+'</div>');
				} else {
					//$("#product_form").trigger("reset");
					showNotify(data.success, 'alert-success');
					$('#call_result').html('<div class="alert bg-green alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.success+'</div>');
				  setTimeout(function() {
				  	window.location.href = $('#product_index_route').val();
			    }, 1000);  
				}
			},
			error: function (xhr, text, error) {
				$('#pre_loader').hide();
				$('#update_btn').attr('disabled', false);
		    showNotify('Error: ' + error, 'alert-danger');
		  }
		})
	});

	$('#submit_quantity_btn').on('click', function(event) {
		event.preventDefault();
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});

		var form = document.getElementById("quantity_add_form");
    var formData = new FormData(form);
	  var formValid = $("#quantity_add_form");
		formValid.validate();
	  if (!formValid.valid()) {
		  return;
		}
		$.ajax({
			url:$('#quantity_add_form').attr('action'),
			method:'post',
			type:'post',
			data: formData,
			dataType:'json',
			cache: false,
      processData: false,
      contentType: false,
			beforeSend:function() {
				$('#pre_loader').show();
				$('#submit_quantity_btn').attr('disabled','disabled');
			},
			success:function(data) {
				$('#pre_loader').hide();
				$('#submit_quantity_btn').attr('disabled', false);
				if(data.error) {
					var error_html = '';
					for(var count = 0; count < data.error.length; count++) {
						error_html += '<p>'+data.error[count]+'</p>';
					}
					showNotify(error_html, 'alert-danger');
					$('#call_result').html('<div class="alert bg-red alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+error_html+'</div>');
				} else {
					$("#quantity_add_form").trigger("reset");
					showNotify(data.success, 'alert-success');
					$('#call_result').html('<div class="alert bg-green alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.success+'</div>');
				  setTimeout(function(){
			        location.reload();
			    }, 1000);  
				}
			},
			error: function (xhr, text, error) {
				$('#pre_loader').hide();
				$('#submit_quantity_btn').attr('disabled', false);
		    showNotify('Error: ' + error, 'alert-danger');
		  }
		})
	});


	function showNotify(textMessage, colorName) {
		 var placementFrom = 'top';
     var placementAlign = 'center'
     var animateEnter = '';
     var animateExit = '';
     var colorName = colorName; 
     var text = textMessage;

     showNotification(colorName, text, placementFrom, placementAlign, animateEnter, animateExit);
	}

});