@extends('layouts.master')
@section('title')
게시글 수정 폼
@endsection
<?php 
	require_once(__DIR__."/boardDao.php");
	require_once(__DIR__."/tools.php");
	/*
		1. 클라이언트가 송신한 num 값을 읽는다.
		2. 그 값으로 해당하는 게시글을 읽는다.
		3. 그 게시글 정보를 이용해 html을 동적으로 생성한다. 
	*/
		$num = requestValue("num");
    $page = requestValue("page");
		$dao = new boardDao();
		$row = $dao->getMsg($num);
?>
@section('content')
<div class="container">
  <h2>글 수정 폼</h2>
  <p>아래의 모든 필드를 채워주세요.</p>
  <form action="modify?page=<?= $page ?>" method="post">
    <?= csrf_field(); ?>
  	<input type="hidden" name="num" value="<?=$row["Num"] ?>">
    <div class="form-group">
      <label for="title">제목:</label>
      <input type="text" class="form-control" id="title" name="title"
      	value="<?= $row["Title"] ?>" 
      required>
    </div>
    <div class="form-group">
      <label for="writer">작성자:</label>
      <input type="text" class="form-control" id="writer" name="writer" value="<?= $row["Writer"] ?>" 
      required>
    </div>    
    <div class="form-group">
      <label for="content">내용:</label>
      <textarea class="form-control" rows="5" id="content" name="content"
      required>
      	<?= $row["Content"] ?>
      </textarea>
    </div>
    <button type="submit" class="btn btn-primary">수정</button>
    <a class="btn btn-danger" href="bbs?page=<?=$page?>">목록보기</a>
  </form>
</div>
@endsection('content')