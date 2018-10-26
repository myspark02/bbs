@extends('layouts.master')
@section('title')
게시글 수정 폼
@endsection

@section('content')
<div class="container">
  <h2>글 수정 폼</h2>
  <p>아래의 모든 필드를 채워주세요.</p>
  <form action="modify?page={{$page}}" method="post">
    @csrf
  	<input type="hidden" name="num" value="{{$row["Num"]}}">
    <div class="form-group">
      <label for="title">제목:</label>
      <input type="text" class="form-control" id="title" name="title"
      	value="{{$row["Title"]}}" 
      required>
    </div>
    <div class="form-group">
      <label for="writer">작성자:</label>
      <input type="text" class="form-control" id="writer" name="writer" value="{{$row["Writer"]}}" 
      required>
    </div>    
    <div class="form-group">
      <label for="content">내용:</label>
      <textarea class="form-control" rows="5" id="content" name="content"
      required>
      	{{$row["Content"]}}
      </textarea>
    </div>
    <button type="submit" class="btn btn-primary">수정</button>
    <a class="btn btn-danger" href="bbs?page={{$page}}">목록보기</a>
  </form>
</div>
@endsection('content')