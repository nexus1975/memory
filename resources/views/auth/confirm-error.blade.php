@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
                            <div class="panel-heading">Sorry, but we cannot confirm your operation!</div>
                            <div class="panel-body">Your token <b>{{ $token }}</b> is not working.</div>
                        </div>
                </div>
        </div>
</div>
@endsection