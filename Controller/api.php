<?php


if (route(1) == 'addtodo') {
    $post = filter($_POST);
    $start_date=date('Y-m-d H:i:s');
    $end_date=date('Y-m-d H:i:s');

    if (!$post['title']) {

        $status = 'error';
        $title = 'Ops! Dikkat! ';
        $msg = 'Lütfen bir başlık giriniz.';
        echo json_encode(['status' => $status, 'title' => $title, 'msg' => $msg]);
        exit();

    }

    if (!$post['description']) {

        $status = 'error';
        $title = 'Ops! Dikkat! ';
        $msg = 'Lütfen bir açıklama giriniz.';
        echo json_encode(['status' => $status, 'title' => $title, 'msg' => $msg]);
        exit();

    }

    if($post['start_date_time'] && $post['start_date']){

        $start_date=$post['start_date'].' '.$post['start_date_time'];

    }
    if($post['end_date_time'] && $post['end_date']){

        $end_date=$post['end_date'].' '.$post['end_date_time'];

    }

    if($post['category_id']){
        $user_id=get_session('id');
        $c_id=$post['category_id'];
        $q=$db->query("SELECT id FROM categories WHERE user_id='$user_id' && categories.id='$c_id'");
        $c=$q->fetch(PDO::FETCH_ASSOC);
        if(!$c){
            $status = 'error';
            $title = 'Ops! Dikkat! ';
            $msg = 'Sadece Oluşturduğunuz Kategorileri Seçiniz !';
            echo json_encode(['status' => $status, 'title' => $title, 'msg' => $msg]);
            exit();
        }
    }



    $q=$db->prepare("INSERT INTO todos SET 
                                    todos.title=?, 
                                    todos.description=?,
                                    todos.color=?,
                                    todos.start_date=?,
                                    todos.end_date=?,
                                    todos.category_id=?,
                                    todos.user_id=?,
                                    todos.status=?,
                                    todos.progress=?");

       $insert=  $q->execute([
            $post['title'],
            $post['description'],
            $post['color'] ?? '#007bff',
            $start_date,
            $end_date,
            $post['category_id'] ?? 0,
            get_session('id'),
            $post['status'],
            $post['progress'],

        ]);

       if($insert){
           $status = 'success';
           $title = 'İşlem Başarılı ';
           $msg = 'Yapılacaklar Listenize Eklendi.';
           echo json_encode(['status' => $status, 'title' => $title, 'msg' => $msg, 'redirect'=>url('todo/list')]);
           exit();
       }else{
           $status = 'error';
           $title = 'Ops! Dikkat! ';
           $msg = 'Beklenmedik Bir Hata Meydana Geldi !!';
           echo json_encode(['status' => $status, 'title' => $title, 'msg' => $msg]);
           exit();
       }
}


if (route(1) == 'edittodo') {
    $post=filter($_POST);
    $id=$post('id');
    $title=$post('title');

    $db->prepare("UPDATE todos SET todos.* WHERE todos.id=? && todos.user_id=?");
    $q->execute([$post,$id,get_session('id')]);

    if($q->rowCount()){

        return[
            'success'=> true,
            'type'=>'success',
            'message'=>'Kategoriniz güncellendi . ',
            'data'=>$q->fetch(PDO::FETCH_ASSOC)
        ];

    }else{

        return[
            'success'=> true,
            'type'=>'danger',
            'message'=>'Güncelleme işlemi sırasında bir hata meydana geldi.',
            'data'=>[]
        ];
    }
}
// adding edittodo and removetodo
elseif (route(1)=='calendar'){

    $start=get('start');
    $end=get('end');
    $sql="
        SELECT id,title,start_date as start , end_date as end , CONCAT('/todoApp/todo/edit/',todos.id) as url 
        FROM todos 
        WHERE todos.user_id=?";

    if($start && $end){
        $sql .= "&& (start_date BETWEEN '$start' AND '$end' OR end_date BETWEEN '$start' AND '$end')";
    }

    $q = $db->prepare($sql);
    $q->execute([get_session('id')]);
    $array = $q->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($array);
}
elseif (route(1)=='passwordchange'){
    $post=filter($_POST);

    if(!$post['old_password']  || (get_session('password')  !=  md5($post['old_password']))){

            $status = 'error';
            $title = 'Ops! Dikkat! ';
            $msg = 'Lütfen şuanda kullanmakta olduğunuz şifreyi giriniz.';
            echo json_encode(['status' => $status, 'title' => $title, 'msg' => $msg]);
            exit();


    }
    $kucuk=preg_match('#[a-z]#',$post['password']);
    $buyuk=preg_match('#[A-Z]#',$post['password']);
    $sayi=preg_match('#[0-9]#',$post['password']);

    if(!$post['password']  || !$kucuk || !$buyuk || !$sayi || strlen($post['password'])<6){
            $status = 'error';
            $title = 'Ops! Dikkat! ';
            $msg = 'Şifreniz büyük harf, küçük harf ve sayı içermeli, en az 6 karakter olmalıdır. ';
            echo json_encode(['status' => $status, 'title' => $title, 'msg' => $msg]);
            exit();
  }
    if(!$post['password'] || !$post['password_again'] || $post['password'] != $post['password_again'] ){
            $status = 'error';
            $title = 'Ops! Dikkat! ';
            $msg = 'Yeni Şifreniz Birbiri İle Uyuşmuyor. ';
            echo json_encode(['status' => $status, 'title' => $title, 'msg' => $msg]);
            exit();
    }

    $p=md5($post['password']);
    $id=get_session('id');
    $upd=$db->query("UPDATE users SET password='$p' WHERE users.id='$id'");

    if($upd){
        add_session('password',$p);
        $status = 'success';
        $title = 'İşlem Başarılı ';
        $msg = 'Şifreniz Güncellendi';
        echo json_encode(['status' => $status, 'title' => $title, 'msg' => $msg]);
        exit();

    }else{
        $status = 'error';
        $title = 'Ops! Dikkat! ';
        $msg = 'Şifreniz güncellenirken bir hata meydana geldi. Tekrar Deneyiniz. ';
        echo json_encode(['status' => $status, 'title' => $title, 'msg' => $msg]);
        exit();

    }








}
elseif (route(1)=='profile'){
    $post=filter($_POST);

    if(!$post['isim']){
        $status = 'error';
        $title = 'Ops! Dikkat! ';
        $msg = 'Lütfen isminizi giriniz.';
        echo json_encode(['status' => $status, 'title' => $title, 'msg' => $msg]);
        exit();


    }elseif (!$post['soyisim']){
        $status = 'error';
        $title = 'Ops! Dikkat! ';
        $msg = 'Lütfen soyisminizi giriniz.';
        echo json_encode(['status' => $status, 'title' => $title, 'msg' => $msg]);
        exit();


    }elseif (!$post['email']){
        $status = 'error';
        $title = 'Ops! Dikkat! ';
        $msg = 'Lütfen E-posta adresinizi giriniz.';
        echo json_encode(['status' => $status, 'title' => $title, 'msg' => $msg]);
        exit();


    }
    $isim=$post['isim'];
    $soyisim=$post['soyisim'];
    $email=$post['email'];
    $id=get_session('id');
    $q=$db->query("UPDATE users SET name = '$isim', surname ='$soyisim', email = '$email' WHERE users.id='$id'");



    if($q){

        add_session('name',$isim);
        add_session('surname',$soyisim);
        add_session('email',$email);
        add_session('fullname',$isim.' '.$soyisim);
        $status = 'success';
        $title = 'İşlem Başarılı ';
        $msg = 'Şifreniz Güncellendi';
        echo json_encode(['status' => $status, 'title' => $title, 'msg' => $msg]);
        exit();

    }else{
        $status = 'error';
        $title = 'Ops! Dikkat! ';
        $msg = 'Şifreniz güncellenirken bir hata meydana geldi. Tekrar Deneyiniz. ';
        echo json_encode(['status' => $status, 'title' => $title, 'msg' => $msg]);
        exit();

    }








}