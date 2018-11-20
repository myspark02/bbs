@extends('layouts.master')
@section('content')
<form action="{{route('remind.store')}}" 
			method="POST" role="form" class="form__auth">
	@csrf		
	<div class="page-header">
      <h4>
        {{ __('messages.passwords.title_reminder') }}
      </h4>
      <p class="text-muted">
        {{ __('messages.passwords.desc_reminder') }}
      </p>
    </div>

	<div class="form-group">
		<input type="email" name="email" 
			placeholder="{{trans('auth.form.email')}}" 
			value="{{old('email')}}"
			class="for-control" autofocus>
		<span class="form-error">
			@foreach($errors->get('email') as $error)
				<span class="form-error">{{$error}}</span>
			@endforeach
		</span>
	</div>
	<button class="btn btn-primary btn-lg btn-block" type="submit">
      {{ __('messages.passwords.send_reminder') }}
    </button>		
</form>
@endsection