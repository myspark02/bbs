<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BBSController extends Controller
{
    public function index() {
	    require_once('boardDao.php');
	    require_once('tools.php');

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
		$startPage = 1;
		$endPage = 1;
		$prev = false;
		$next = false;
		$startRecord = 0;
		$msgs = null;
		$totalPages = 0;

		if($totalCount > 0) {
		
			$startPage = floor(($currentPage-1)/NUM_PAGE_LINKS)*NUM_PAGE_LINKS+1;	
			$endPage = $startPage + NUM_PAGE_LINKS - 1;
			$totalPages = ceil($totalCount/NUM_LINES);
			if ($endPage > $totalPages)
				$endPage = $totalPages;
		

			if ($startPage > 1) $prev = true;
			if ($endPage < $totalPages) $next = true;
	
			$startRecord = ($currentPage-1)*NUM_LINES;	
			$msgs = $dao->getMsgs4Page($startRecord, NUM_LINES);
		}

    	return view('bbs.board')->with('startPage', $startPage)->with('endPage', $endPage)->with('prev', $prev)->with('next', $next)->with('startRecord', $startRecord)->with('currentPage', $currentPage)->with('totalCount', $totalCount)->with('msgs', $msgs)->with('totalPages', $totalPages);
    }

    public function show() {

		require_once('boardDao.php');
		require_once('tools.php');

		$id = requestValue("id");
		$page = requestValue("page");
		$dao = new boardDao();
		$msg = $dao->getMsg($id);	
		$dao->increaseHits($id);

		return view('bbs.view')->with('page', $page)
				->with('msg', $msg);
    }	

    public function edit() {

	require_once("boardDao.php");
	require_once("tools.php");
	/*
		1. 클라이언트가 송신한 num 값을 읽는다.
		2. 그 값으로 해당하는 게시글을 읽는다.
		3. 그 게시글 정보를 이용해 html을 동적으로 생성한다. 
	*/
		$num = requestValue("num");
    	$page = requestValue("page");
		$dao = new boardDao();
		$row = $dao->getMsg($num);

		return view('bbs.modify_form')->with("row", $row)->with('page', $page);

    }

    public function update() {
	    require_once('tools.php');
	    require_once('boardDao.php');

	    $num = requestValue('num');
	    $title = requestValue('title');
	    $writer = requestValue('writer');
	    $content = requestValue('content');

	    $page = requestValue('page');

	    if($num && $title && $writer && $content){
	        $bdao = new boardDao();
	        $bdao->updateMsg($num, $title, $writer, $content);
	       // okGo("정상적으로 수정되었습니다.", "bbs?page=$page");
	        return redirect('bbs?page=$page')->with('message', $num."번 글이 정상적으로 수정되었습니다.");
	    }else{
	        errorBack('모든 항목이 빈칸 없이 입력되어야 합니다.');
	    }	
    }

    public function create() {
    	return view('bbs.write_form');
    }

    public function store() {
  		require_once('tools.php');
	    require_once('boardDao.php');

	    $title = requestValue('title');
	    $writer = requestValue('writer');
	    $content = requestValue('content');

	    $page = requestValue('page');

	    if($title && $writer && $content){
	        $bdao = new boardDao();
	        $bdao->insertMsg($title, $writer, $content);
	        //okGo("정상적으로 입력되었습니다.", "bbs?page=$page");
	        return redirect('bbs?page=$page')->with('message', '새로운 게시글을 등록했습니다.');
	    }else{
	        errorBack('모든 항목이 빈칸 없이 입력되어야 합니다.');
	    }

    }

    public function destroy() {
	 	require_once("tools.php");
		require_once("BoardDao.php");

		$num = requestValue("num");
		$page = requestValue("page");
		$dao = new BoardDao();
		$dao->deleteMsg($num);

		//okGo("게시글이 삭제 되었습니다.", "bbs?page=$page");
		return redirect('bbs?page=$page')->with('message', $num.'번 게시글이 삭제 되었습니다');
    }
}
