@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
                            <div class="panel-heading">Welcome to Memory Game!</div>
                                <div class="panel-body">
                                    <p>Hello <b>{{ $name }}</b>,</p>
                                    <p>Please check your email account <b>{{ $email }}</b> to confirm your identity.</p>
                                    <p></p>
                                    <p>Complete registration within maximum of 12 hours.</p>
                                    <p></p>                               
                                </div>
                        </div>
                </div>
        </div>
</div>
@endsection