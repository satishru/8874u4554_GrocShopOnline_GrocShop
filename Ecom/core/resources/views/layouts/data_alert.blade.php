	@if(Session::has('alert'))
	  <div class="alert bg-green alert-dismissible" role="alert">
	    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	    {{ Session::get('alert') }}
	    @php
	    Session::forget('alert');
	    @endphp
	  </div>
	@endif