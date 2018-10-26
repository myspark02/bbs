@extends('layouts.master')
	@section('title') 
		게시글 상세보기
	@endsection	

@section('content')
	<!--input type="hidden" id="_token" value="{{csrf_token()}}"-->
	<script>
			function delReq(num) {
				var yn = confirm("Are you sure?");
				
				if (yn == false) return;

				$('#delete').submit();
				/*
				alert($('#_token').val());
				location.href="'delete?num="+num+"&page={{$page}}&_token="+$('#_token').val()+"'";
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
				<td> {{$msg["Title"]}}</td>
			</tr>	
			<tr> 
				<th>작성자</th>
				<td>{{$msg["Writer"]}}</td>
			</tr>	
			<tr> 
				<th>작성일시</th>
				<td>{{$msg["Regtime"]}}</td>				
			</tr>	
			<tr> 
				<th>조회수</th>
				<td>{{$msg["Hits"]}}</td>				
			</tr>	
			<tr> 
				<th>내용</th>
				<td>{{$msg["Content"]}}</td>				
			</tr>				
		</table>	

	</div>	
	
	<div class="container">
		<div class="row">
			<div class="col-sm-2">
				<input type="button" class="btn btn-primary" 
					onclick="location.href='bbs?page={{$page}}'" value="목록보기">
			</div>
			<div class="col-sm-1">	
				<input type="button" class="btn btn-success" 
					onclick="location.href='modify?num={{$msg["Num"]}}&page={{$page}}'" value="수정">
			</div>	
			<div class="col-sm-1">
				<form action="delete" id="delete" method="post">	
					@csrf
					<input type="hidden" name="num" value={{$msg["Num"]}}>
					<input type="hidden" name="page" value={{$page}}>
					<input type="button" class="btn btn-danger" 
						onclick="delReq({{$msg["Num"]}})"value="삭제">
				</form>	
			</div>
			<div class="col-sm-8"></div>
		</div>					
	</div>	
@endsection	