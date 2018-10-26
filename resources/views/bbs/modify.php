<?php
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
        okGo("정상적으로 수정되었습니다.", "bbs?page=$page");
    }else{
        errorBack('모든 항목이 빈칸 없이 입력되어야 합니다.');
    }

?>