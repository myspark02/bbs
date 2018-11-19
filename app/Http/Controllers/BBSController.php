<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Board;

class BBSController extends Controller
{
	public function __construct() {
		return $this->middleware('auth');
	}
    public function index(Request $request) {
    	$page = $request->get('page');
	   // $msgs = DB::table('boards')->orderBy('id', 'desc')->paginate(10);
    	$msgs = Board::orderBy('id', 'desc')->paginate(10);
    	return view('bbs.board')->with('msgs', $msgs)->with('page', $page);
    }

    public function show(Request $request) {

		$id = $request->get('id');
		$page = $request->get('page');
		
		$msg = Board::find($id);
		$msg->hits = $msg->hits + 1;
		$msg->save();

		return view('bbs.view')->with('page', $page)
				->with('msg', $msg);
    }	

    public function edit(Request $request) {

	/*
		1. 클라이언트가 송신한 num 값을 읽는다.
		2. 그 값으로 해당하는 게시글을 읽는다.
		3. 그 게시글 정보를 이용해 html을 동적으로 생성한다. 
	*/
		$num = $request->get('num');
    	$page = $request->get('page');
		
		$row = Board::find($num);

		return view('bbs.modify_form')->with("row", $row)->with('page', $page);

    }

    public function update(Request $request) {
	    $num = $request->get('num');
	    $title = $request->get('title');
	    $writer = $request->get('writer');
	    $content = $request->get('content');

	    $page = $request->get('page');

		$this->validate($request, ['title'=> 'required', 
						'writer'=>'required', 'content'=>'required']);	  
    	$msg = Board::find($num);
    	$msg->update(['title'=>$title, 'writer'=>$writer, 'content'=>$content]);
       
        return redirect('bbs?page=$page')->with('message', $num."번 글이 정상적으로 수정되었습니다.");
  	
    }

    public function create() {
    	return view('bbs.write_form');
    }

    public function store(Request $request) {
  		

	    $title = $request->get('title');
	    $writer = $request->get('writer');
	    $content = $request->get('content');

	    $page = $request->get('page');
		
		$this->validate($request, ['title'=> 'required', 
						'writer'=>'required', 'content'=>'required']);	
	      
	    $board = new Board();	
	    $board->title = $title;
	    $board->writer = $writer;
	    $board->content = $content;
	    $board->save();
	    return redirect('bbs?page=$page')->with('message', '새로운 게시글을 등록했습니다.');
	    
    }

    public function destroy(Request $request) {
		$this->validate($request,['num'=>'required']);

		$num = $request->get("num");
		$page = $request->get("page");
		
		$msg = Board::find($num);
		$msg->delete();
		//okGo("게시글이 삭제 되었습니다.", "bbs?page=$page");
		return redirect('bbs?page=$page')->with('message', $num.'번 게시글이 삭제 되었습니다');
    }
}
