@extends('layouts.master')
@section('title')
게시글 수정 폼
@endsection

@section('content')
<div class="container">
  <h2>글 수정 폼</h2>
  <p>아래의 모든 필드를 채워주세요.</p>
  <form id="store" action="{{route('bbs.update', ['bb'=>$row->id, 'page'=>$page])}}" method="post">
    @csrf
    @method('PUT')
  	<input type="hidden" name="id" value="{{$row['id']}}">
    <div class="form-group">
      <label for="title">제목:</label>
      <input type="text" class="form-control" id="title" name="title"
      	value="{{$row["title"]}}" 
      required>
    </div>
    <!--div class="form-group">
      <label for="writer">작성자:</label>
      <input type="text" class="form-control" id="writer" name="writer" value="{{$row["writer"]}}" 
      required>
    </div-->    
    <div class="form-group">
      <label for="content">내용:</label>
      <textarea class="form-control" rows="5" id="content" name="content"
      required>
      	{{$row["content"]}}
      </textarea>
    </div>
   <div><h3>첨부파일</h3></div>      
    <ul>
      @forelse($row->attachments as $attach)
        <li>
          <a href="{{'/files/' . Auth::user()->id . '/' . $attach->filename}}">
          {{$attach->filename}} 
          </a>
          <input type="checkbox" class="glyphicon glyphicon-trash" value="{{$attach->id}}" name="del_attachments[]"> Delete
        </li>
      @empty <li>첨부파일 없음</li> 
      @endforelse 
    </ul>
   
  </form>


  <form action="{{route('attachments.store')}}"
      class="dropzone"
      id="dropzone" method="post" enctype="multipart/form-data">
          @csrf
  </form>
  <div style="margin:10px 0 50px 0" >
    <button type="submit" class="btn btn-primary offset-md-1" onclick="$('#store').submit()">수정</button>
    <a class="btn btn-danger offset-md-1" href="{{route('bbs.index',['page'=>$page])}}">목록보기</a>
  </div>
</div>
 @include('bbs.dropZone')
@endsection('content')