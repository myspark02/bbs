<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BBSController extends Controller
{
    public function index(Request $request) {
    	$page = $request->get('page');
	    $msgs = DB::table('boards')->orderBy('id', 'desc')->paginate(10);
    	return view('bbs.board')->with('msgs', $msgs)->with('page', $page);
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
