<?php

if (!get_session('login') || get_session('login') != true) redirect('login');


if (route(0) == 'categories' && !route(1)) {

    /*  if(isset($_POST ['submit'])){
          $_SESSION['post']=$_POST;
          $eposta=post('eposta');
          $sifre=post('şifre');

          $return=model('auth/login',['email'=> $eposta,'password'=>$sifre],'login');


          if($return['success']== true){

              if(isset($return['redirect'])){
                  redirect($return['redirect']);
              }
          }else{
              add_session('error',[
                  'message'=>$return['message'] ?? '',
                  'type'=>$return['type']??''
              ]);
          }

      }
  */

    view('categories/home');
}
else if (route(0) == 'categories' && route(1) == 'list') {


    $return = model('categories', [], 'list');
    view('categories/list', $return['data']);

}
else if (route(0) == 'categories' && route(1) == 'edit' && is_numeric(route(2))) {

    if (isset($_POST ['submit'])) {
        $_SESSION['post'] = $_POST;
        $title = post('title');
        $id = post('id');

        $return = model('categories', ['title' => $title, 'id' => $id], 'edit');


        if ($return['success'] == true) {

            add_session('error', [
                'message' => $return['message'] ?? '',
                'type' => $return['type'] ?? ''
            ]);

            if (isset($return['redirect'])) {
                redirect($return['redirect']);
            }
        } else {
            add_session('error', [
                'message' => $return['message'] ?? '',
                'type' => $return['type'] ?? ''
            ]);
        }

    }

    $return = model('categories', ['id' => route(2)], 'getsingle');
    view('categories/edit', $return['data']);


}
else if (route(0) == 'categories' && route(1) == 'remove' && is_numeric(route(2))) {


    $return = model('categories', ['id' => route(2)], 'remove');
    redirect('categories/list/?type=' . $return['type'] . '&message=' . $return['message']);

}
else if (route(0) == 'todo' && route(1) == 'add') {

    $return = model('categories', [], 'list');
    view('todo/add',$return['data']);

}
else if (route(0) == 'todo' && route(1) == 'list') {

    $return = model('todo', [], 'list');
    view('todo/list',$return['data']);

}
else if(route(0)=='todo' && route(1)=='edit' && is_numeric(route(2))){
//    $return = model('todo', ['id' => route(2)], 'getsingle');
//    view('todo/edit',$return['data']);


  /*  if (isset($_POST ['submit'])) {
        $_SESSION['post'] = $_POST;
        $title = post('title');
        $id = post('id');

        $return = model('todo', ['title' => $title, 'id' => $id], 'edit');


        if ($return['success'] == true) {

            add_session('error', [
                'message' => $return['message'] ?? '',
                'type' => $return['type'] ?? ''
            ]);

            if (isset($return['redirect'])) {
                redirect($return['redirect']);
            }
        } else {
            add_session('error', [
                'message' => $return['message'] ?? '',
                'type' => $return['type'] ?? ''
            ]);
        }

    }  */

    $return = model('todo', ['id' => route(2)], 'getsingle');
    view('todo/edit', $return['data']);
}