<?php

if($process=='login'){

    if(!$data['email']){
        return[
            'success'=> false,
            'type'=>'danger',
            'message'=>'Lütfen e-posta adresinizi kontrol ediniz.',

        ];
    }if(!$data['password']){
        return[
            'success'=> false,
            'type'=>'danger',
            'message'=>'Lütfen şifrenizi kontrol ediniz.',

        ];
    }

    $email=$data['email'];
    $password=$data['password'];
    $q= $db->prepare("SELECT * ,CONCAT(name,' ',surname) as fullname FROM users WHERE email=?  && password=?");
    $islem = $q->execute([$data['email'],md5($data['password'])]);

    if($q->rowCount()){

        $user=$q->fetch(PDO::FETCH_ASSOC);
        add_session('id',$user['id']);
        add_session('name',$user['name']);
        add_session('surname',$user['surname']);
        add_session('email',$user['email']);
        add_session('fullname',$user['fullname']);
        add_session('login',true);
        return[
            'success'=> true,
            'type'=>'success',
            'message'=>'GİRİŞ BAŞARILI.',
            'data'=>$user,
            'redirect'=>'home'
        ];

    }else{
        return[
            'success'=> false,
            'type'=>'danger',
            'message'=>'KULLANICI ADI VEYA ŞİFRENİZ YANLIŞ.'
        ];
    }

}