<?php
    require_once('tools.php');
    require_once('boardDao.php');

    $title = requestValue('title');
    $writer = requestValue('writer');
    $content = requestValue('content');

    $page = requestValue('page');

    if($title && $writer && $content){
        $bdao = new boardDao();
        $bdao->insertMsg($title, $writer, $content);
        okGo("정상적으로 입력되었습니다.", "bbs?page=$page");
    }else{
        errorBack('모든 항목이 빈칸 없이 입력되어야 합니다.');
    }

?>