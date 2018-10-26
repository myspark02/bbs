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
			@if($totalCount > 0)
				@foreach($msgs as $row) 
					<tr>
						<td>{{$row["Num"]}}</td>
						<td>
							<a href="/view?id={{$row["Num"]}}&page={{$currentPage}}">
								{{$row["Title"]}}						
							</a>		
						</td>
						<td>{{$row["Writer"]}}</td>
						<td>{{$row["Regtime"]}}</td>
						<td>{{$row["Hits"]}}</td>
					</tr>
				@endforeach	
			@endif	

		</table>	
		<input type="button" value="글쓰기" onclick="location.href='/write'" class="btn btn-danger">
	</div>	
	<br><br>
	@if ($totalCount > 0) 
		<div class="container">
		<ul class="pagination">
		
			@if($startPage > 1)
				<li class="page-item">
					<a class="page-link"  href="?page={{$startPage-1}}"> Previous </a>
				</li>
		    @endif
			@for ($i=$startPage; $i<=$endPage; $i++)
				@if($i==$currentPage)
					<li class="page-item  active">
						<a class="page-link"  href="?page={{$i}}"> 
							{{$i}} 
						</a>
					</li>	
				@else 
					<li class="page-item">	
						<a class="page-link"  href="?page={{$i}}"> {{$i}} </a>
					</li>	
				@endif
				@if ($endPage < $totalPages) 
					<li class="page-item">
						<a class="page-link"  href="?page={{$endPage+1}}"> Next </a>
					</li>	
				@endif
			@endfor	
		</ul>
		</div>
	@endif	
@endsection
