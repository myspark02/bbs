<?php
	require_once("tools.php");
	require_once("BoardDao.php");

	$num = requestValue("num");
	$page = requestValue("page");
	$dao = new BoardDao();
	$dao->deleteMsg($num);

	okGo("게시글이 삭제 되었습니다.", "bbs?page=$page");
?>