@extends('layouts.master')
@section('title')
게시판
@endsection
@section('content')
	<div class="container">
		@if(Session::has('message'))
			<div class="alert alert-info">
				{{Session::get('message')}}
			</div>
		@endif
		<table class="table table-hover">
			<tr>
				<th>번호</th>
				<th>제목</th>
				<th>작성자</th>
				<th>작성일시</th>
				<th>조회수</th>
			</tr>	
			
				@foreach($msgs as $row) 
					<tr>
						<td>{{$row->id}}</td>
						<td>
							<a href="/view?id={{$row->id}}&page={{$page}}">
								{{$row->title}}						
							</a>		
						</td>
						<td>{{$row->writer}}</td>
						<td>{{$row->regtime}}</td>
						<td>{{$row->hits}}</td>
					</tr>
				@endforeach	
			
		</table>	
		<input type="button" value="글쓰기" onclick="location.href='/write'" class="btn btn-danger">
	</div>	
	<br><br>
	{{$msgs->links()}}
@endsection
