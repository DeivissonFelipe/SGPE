@if ($breadcrumbs)
	<ol class="breadcrumb">
		@foreach ($breadcrumbs as $breadcrumb)
			@if ($breadcrumb->url && !$breadcrumb->last)
				<li><a href="{{ $breadcrumb->url }}"><i class="fa fa-dashboard"></i> {{ $breadcrumb->title }}</a></li>
			@else
				<li class="active"><i class="fa fa-dashboard"></i> {{ $breadcrumb->title }}</li>
			@endif
		@endforeach
	</ol>
@endif
