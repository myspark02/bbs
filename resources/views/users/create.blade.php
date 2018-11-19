@extends('layouts.master')
@section('content')
 <form action="{{route('users.store')}}" method="POST" class="form__auth">
 	@csrf
 	<div class="form-group {{$errors->has('name')?'has-error':''}}">
 		<input type="text" name="name" class="form-control" placeholder="이름" value="{{old('name')}}"
 			autofocus="true">
 			{!! $errors->first('name', '<span class="form-error">:message</span>')!!}
 	</div>
 	<div class="form-group {{$errors->has('email')?'has-error':''}}">
 		<input type="email" name="email" class="form-control" 
 			placeholder="이메일" value="{{old('email')}}"
 			autofocus="true">
 			{!! $errors->first('email', '<span class="form-error">:message</span>')!!}
 	</div>
 	<div class="form-group {{$errors->has('password')?'has-error':''}}">
 		<input type="password" name="password" class="form-control" 
 			placeholder="password" value="{{old('password')}}"
 			autofocus="true">
 			{!! $errors->first('password', '<span class="form-error">:message</span>')!!}
 	</div>
 	<div class="form-group {{$errors->has('password_confirmation')?'has-error':''}}">
 		<input type="password" name="password_confirmation" class="form-control" 
 			placeholder="" value="{{old('password_confirmation')}}"
 			autofocus="true">
 			{!! $errors->first('password_confirmation', '<span class="form-error">:message</span>')!!}
 	</div>
 	<div class="form-group">
 		<button class="btn btn-primary btn-lg btn-block" type="submit">가입하기</button>
 	</div>
 </form>
@endsection