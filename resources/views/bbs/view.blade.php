@extends('layouts.master')
	@section('title') 
		게시글 상세보기
	@endsection	

@section('content')
	<!--input type="hidden" id="_token" value="{{csrf_token()}}"-->
	<script>
			function delReq(id) {
				var yn = confirm("Are you sure?");
				
				if (yn == false) return;

				$('#delete').submit();
				/*
				alert($('#_token').val());
				location.href="'delete?id="+id+"&page={{$page}}&_token="+$('#_token').val()+"'";
				*/				
			}
	</script>	
	
	<div class="container">
  		<h2>게시글 상세 정보</h2>
  	</div>	
	<div class="container">
		<table class="table">
			<tr> 
				<th>제목</th>
				<td> {{$msg["title"]}}</td>
			</tr>	
			<tr> 
				<th>작성자</th>
				<td>{{$msg->user->name}}</td>
			</tr>	
			<tr> 
				<th>작성일시</th>
				<td>{{$msg["regtime"]}}</td>				
			</tr>	
			<tr> 
				<th>조회수</th>
				<td>{{$msg["hits"]}}</td>				
			</tr>	
			<tr> 
				<th>내용</th>
				<td>{{$msg["content"]}}</td>				
			</tr>				
		</table>	

	</div>	
	
	<div class="container">
		<div class="row">
			<div class="col-sm-2">
				<input type="button" class="btn btn-primary" 
					onclick="location.href='{{route('bbs.index', ['page'=>$page])}}'" value="목록보기">
			</div>
			@if(Auth::user()->id==$msg->user->id)
				<div class="col-sm-1">	
					<input type="button" class="btn btn-success" 
						onclick="location.href='{{route('bbs.edit', ['bb'=>$msg->id, 'page'=>$page])}}'" value="수정">
				</div>	
				<div class="col-sm-1">
					<form action="{{route('bbs.destroy', $msg->id)}}" id="delete" method="post">	
						@csrf
						@method('DELETE')
						<input type="hidden" id="id" name="id" value={{$msg["id"]}}>
						<input type="hidden" name="page" value={{$page}}>
						<!--input type="button" id="btnDelete" class="btn btn-danger" 
							 onclick="delReq({{$msg["id"]}})" value="삭제"-->
						<input type="button" id="btnDelete" class="btn btn-danger" 
							  value="삭제">	 

					</form>	
				</div>
			@endif
			<div class="col-sm-8"></div>
		</div>					
	</div>	
@endsection	

@section('script')
	<script>
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$('#btnDelete').on('click', function(){
			//var id = $('#id').val();
			//alert(id);
			if(confirm('글을 삭제합니다.')) {
				$.ajax({
					type: 'DELETE',
					url: '{{route("bbs.destroy", ["bb"=>$msg->id])}}',
					success: function(data) {
						if(data == 'true') {
							location.href="{{route('bbs.index', ['page'=>$page])}}";
						}
					},
				});
			}	

		});
	</script>
@endsection