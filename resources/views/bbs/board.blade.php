@extends('layouts.master')
@section('title')
게시판
@endsection
@section('content')
<?php
    require_once(__DIR__.'/boardDao.php');
    require_once(__DIR__.'/tools.php');

    $currentPage = requestValue("page");
    // http://localhost/bbs/board.php?page=-3
    if($currentPage < 1) 
    	$currentPage = 1;

    /*
		currentPage는 주어지는 것이고...
		계산해야 될 것은 startPage, endPage, prevLink, nextLink

    */

	$dao = new boardDao();

	// 집단함수, aggregate function
	// select count(*) from board;
	$totalCount = $dao->getTotalCount();

	if($totalCount > 0) {
	
		$startPage = floor(($currentPage-1)/NUM_PAGE_LINKS)*NUM_PAGE_LINKS+1;	
		$endPage = $startPage + NUM_PAGE_LINKS - 1;
		$totalMsgs = $dao->getTotalCount();
		$totalPages = ceil($totalMsgs/NUM_LINES);
		if ($endPage > $totalPages)
			$endPage = $totalPages;

		// total page : ceil(전체 게시글 수 / NUM_LINES)
/*
		$totalPages = ceil($totalCount/NUM_LINES);

		if ($endPage > $totalPages)
			$endPage = $totalPages;
*/
		$prev = false;
		$next = false;

		if ($startPage > 1) $prev = true;
	//	if ($endPage < $totalPages) $next = true;
	/*
	1. DB에 등록된 게시글 리스트를 인출(boardDao에게 요청)
		<table>
			<tr>
				<td>번호</td>
				<td>제목</td>
				<td>작성자</td>
				<td>작성일시</td>
				<td>조회수</td>
			</tr>
	2. 2차원 배열로 반환된 게시글 리스트 각각에 대해 
		2.1 HTML 문서를 동적으로 생성
		    <tr>
		    	<td></td>
		    	<td> </td>
		    	<td> </td>
		    	<td> </td>
		    	<td> </td>
		    </tr>
	3. </table>	   
	
	4. 글쓰기 버튼 생성  

	*/
		// select * from board order by regtime limit start, count
		/*
			currentPage 1: start = 0, count = NUM_LINES
			currentPage 2: start = NUM_LINES, count = NUM_LINES
			currentPage 3: start = NUM_LINES*2, count = NUM_LINES
			currentPage 4: start = NUM_LINES*3, count = NUM_LINES
			....
		*/
		$startRecord = ($currentPage-1)*NUM_LINES;	
		//$msgs = $dao->getManyMsgs();
		$msgs = $dao->getMsgs4Page($startRecord, NUM_LINES);
	}

?>	<div class="container">
		<table class="table table-hover">
			<tr>
				<th>번호</th>
				<th>제목</th>
				<th>작성자</th>
				<th>작성일시</th>
				<th>조회수</th>
			</tr>	
			<?php if ($totalCount > 0) : ?>
				<?php foreach($msgs as $row) : ?>
					<tr>
						<td><?= $row["Num"]?></td>
						<td>
							<a href="/view?id=<?=$row["Num"] ?>&page=<?=$currentPage ?>">
								<?= $row["Title"]?>						
							</a>		
						</td>
						<td><?= $row["Writer"]?></td>
						<td><?= $row["Regtime"]?></td>
						<td><?= $row["Hits"]?></td>
					</tr>
				<?php endforeach ?>	
			<?php endif ?>	

		</table>	
		<input type="button" value="글쓰기" onclick="location.href='/write'" class="btn btn-danger">
	</div>	
	<br><br>
	<?php if ($totalCount > 0) : ?>
		<div class="container">
		<ul class="pagination">
		<?php
			if($startPage > 1) {
		?>		<li class="page-item">
					<a class="page-link"  href="?page=<?= $startPage-1 ?>"> Previous </a>
				</li>
		<?php		
			}
			for ($i=$startPage; $i<=$endPage; $i++) {
				if($i==$currentPage) {
		?>
				<li class="page-item  active">
					<a class="page-link"  href="?page=<?= $i ?>"> 
						<?= $i ?> 
					</a>
				</li>	
		<?php			
					
				}else {
		?>		<li class="page-item">	
					<a class="page-link"  href="?page=<?= $i ?>"> <?= $i ?> </a>
				</li>	
		<?php			
				}	
			}
			if ($endPage < $totalPages) {
		?>		<li class="page-item">
					<a class="page-link"  href="?page=<?= $endPage+1 ?>"> Next </a>
				</li>	
		<?php		
			}
		?>
		</ul>
		</div>
	<?php endif ?>	
@endsection
