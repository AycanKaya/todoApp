<?php
function status($status){
    if($status=='a'){
        return [
            'title'=>'Aktif',
            'color'=>'success',
            'icon'=>'fa fa-check'
        ];
    }else if($status=='p'){
        return [
            'title'=>'Pasif',
            'color'=>'danger',
            'icon'=>'fa fa-trash'
        ];
    }else if($status=='s'){
        return [
            'title'=>'Süreçte',
            'color'=>'warning',
            'icon'=>'fa fa-info'
        ];
    }



}