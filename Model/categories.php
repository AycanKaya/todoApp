<?php

if($process=='add'){

    if(!$data['title']){
        return[
            'success'=> false,
            'type'=>'danger',
            'message'=>'Lütfen kategoriniz için başlık giriniz.',

        ];
    }

    $title=$data['title'];


    $q= $db->prepare("INSERT INTO categories SET title=? , user_id=? ");
    $islem = $q->execute([$title,get_session('id')]);

    if($q->rowCount()){

        return[
            'success'=> true,
            'type'=>'success',
            'message'=>'Kategoriniz başarıyla eklendi.',
            'redirect'=>'categories/list'
        ];

    }else{
        return[
            'success'=> false,
            'type'=>'danger',
            'message'=>'Kategoriniz eklenirken bir hata meydana geldi.'
        ];
    }

}
else if($process=='list'){

    $q= $db->prepare("SELECT * FROM categories WHERE user_id=?");
    $q->execute([get_session('id')]);

    if($q->rowCount()){

        return[
            'success'=> true,
            'type'=>'success',
            'data'=> $q->fetchAll(PDO::FETCH_ASSOC)
        ];

    }else{
        return[
            'success'=> true,
            'type'=>'success',
            'data'=> []
        ];
    }

}
else if($process=='remove'){

    $id=$data['id'];

    $q= $db->prepare("DELETE FROM categories WHERE categories.id=? && categories.user_id=?");
    $q->execute([$id,get_session('id')]);

    if($q->rowCount()){
        add_session('error',[
            'message'=>'Kategoriniz başarı ile silindi.',
            'type'=>'success',
        ]);

        return[
            'success'=> true,
            'type'=>'success',
            'message'=>'Kategoriniz başarı ile silindi.'
        ];

    }else{
        add_session('error',[
            'message'=>'Silme işlemi sırasında bir hata meydana geldi.',
            'type'=>'danger',
        ]);
        return[
            'success'=> false,
            'type'=>'danger',
            'message'=>'Silme işlemi sırasında bir hata meydana geldi.',

        ];
    }

}

else if($process =='getsingle'){
    $id=$data['id'];
    $q=$db->prepare("SELECT * FROM categories WHERE categories.id=? && user_id=?");
    $q->execute([$id,get_session('id')]);


    if($q->rowCount()){
        return [
            'success'=>true,
            'type'=>'succes',
            'data'=>$q->fetch(PDO::FETCH_ASSOC)
        ];
    }else{
        return [
            'success'=>true,
            'type'=>'danger',
            'data'=>[]
        ];
    }

}
else if($process =='edit'){

    $id=$data['id'];
    $title=$data['title'];
    if(!$data['title']){
        return[
            'success'=> false,
            'type'=>'danger',
            'message'=>'Lütfen kategoriniz için başlık giriniz.',

        ];
    }
    $q= $db->prepare("UPDATE categories SET categories.title=? WHERE categories.id=? && user_id=?");
    $q->execute([$title,$id,get_session('id')]);

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
