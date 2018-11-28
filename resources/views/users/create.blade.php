@extends('layouts.master')
@section('content')
 <form action="{{route('users.store')}}" method="POST" class="form__auth">
 	@csrf
 	<div class="form-group {{$errors->has('name')?'has-error':''}}">
 		<input type="text" name="name" class="form-control col-md-8 offset-md-1" placeholder="이름" value="{{old('name')}}"
 			autofocus="true">
 			{!! $errors->first('name', '<span class="form-error">:message</span>')!!}
 	</div>
 	<div class="form-group {{$errors->has('email')?'has-error':''}} row">
 		<input type="email" name="email" id='email' class="form-control col-md-6 offset-md-1" 
 			placeholder="이메일" value="{{old('email')}}"
 			autofocus="true" >
 			{!! $errors->first('email', '<span class="form-error">:message</span>')!!}
 		<button id="checkDup" type="button" class="form-control col-md-1 btn btn-warning">중복체크</button>	
 		<span id="dupmsg" class="col-md-1"></span>	
 	</div>
 	<div class="form-group {{$errors->has('password')?'has-error':''}}">
 		<input type="password" name="password" class="form-control  col-md-8 offset-md-1" 
 			placeholder="password" value="{{old('password')}}"
 			autofocus="true">
 			{!! $errors->first('password', '<span class="form-error">:message</span>')!!}
 	</div>
 	<div class="form-group {{$errors->has('password_confirmation')?'has-error':''}}">
 		<input type="password" name="password_confirmation" class="form-control  col-md-8 offset-md-1" 
 			placeholder="password confirm" value="{{old('password_confirmation')}}"
 			autofocus="true">
 			{!! $errors->first('password_confirmation', '<span class="form-error">:message</span>')!!}
 	</div>
 	<div class="form-group">
 		<button class="btn btn-primary btn-lg btn-block  col-md-8 offset-md-1" type="submit">가입하기</button>
 	</div>
 </form>
@endsection

@section('script')
<script>
$('#checkDup').on('click', function(){
			var email = $('#email').val();
		//alert('email:'+email);
			$.ajax({
			type:'GET',
			url: '{{route('user.email')}}?email='+email,
			success: function(data) {
				//alert(data);
				$('#dupmsg').text("");
				if(data=='true') {
					$('#dupmsg').text("이미 사용중");
				} else {
					$('#dupmsg').text("사용가능");
				}
			}
		});
	});
</script>
@endsection



