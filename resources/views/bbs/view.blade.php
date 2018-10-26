@extends('layouts.master')
<?php
	// 특정 글의 상세보기 
	require_once(__DIR__."/tools.php");
	require_once(__DIR__."/boardDao.php");

	/* 
		request에서 글의 id를 추출
		해당 번호의 글을 읽고, 조회 수 1 증가 
		읽은 글을 출력한다.

	*/
	$id = requestValue("id");
	$page = requestValue("page");
	$dao = new boardDao();
	$msg = $dao->getMsg($id);	
	$dao->increaseHits($id);
?>

	@section('title') 
		게시글 상세보기
	@endsection	

@section('content')
	<script>
			function delReq(num) {
				var yn = confirm("Are you sure?");
				if (yn == false) return;

				location.href="delete?num="+num+"&page="+<?=$page?>;
			}
	</script>	

	<div class="container">
  		<h2>게시글 상세 정보</h2>
  	</div>	


	<div class="container">
		<table class="table">
			<tr> 
				<th>제목</th>
				<td><?= $msg["Title"]?></td>
			</tr>	
			<tr> 
				<th>작성자</th>
				<td><?= $msg["Writer"]?></td>
			</tr>	
			<tr> 
				<th>작성일시</th>
				<td><?= $msg["Regtime"]?></td>				
			</tr>	
			<tr> 
				<th>조회수</th>
				<td><?= $msg["Hits"]?></td>				
			</tr>	
			<tr> 
				<th>내용</th>
				<td><?= $msg["Content"]?></td>				
			</tr>				
		</table>	

	</div>	
	
	<div class="container">
		<input type="button" class="btn btn-primary" 
			onclick="location.href='bbs?page=<?=$page?>'" value="목록보기">
		<input type="button" class="btn btn-success" 
			onclick="location.href='modify?num=<?= $msg["Num"] ?>&page=<?= $page ?>'" value="수정">
		<input type="button" class="btn btn-danger" 
			onclick="delReq(<?= $msg["Num"] ?>)"value="삭제">				
	</div>	
@endsection	