		<div class="row">
		 <div class="col-xs-11">
						@if(!empty(Session::get('platformcdi'))) 
						 <a href="{{route('home', Session::get('platformcdi')) }}" class="btn btn-default btn-circle btn-lg" ><i class="fa fa-home"></i></a>
						@else
						 <a href="{{route('home', 'cdi') }}" class="btn btn-default btn-circle btn-lg" ><i class="fa fa-home"></i></a>
						@endif
		 </div>
		</div>