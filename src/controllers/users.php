<?php

session_start();
requireValidSession(true);

$exception = null;
if(isset($_GET['delete'])){
    try{
        User::deleteById($_GET['delete']);
        addSuccessMsg('Usuário excluído com sucesso.');
    } catch(Exception $e){
        if(stripos($e->getMessage(), 'FOREIGN KEY')){
            addErrorMsg('Não foi possível excluir o usuário com batimentos.');
        }
        $exception = $e;
    }
}

$users = User::getAll();
foreach($users as $user){
    $user->start_date = (new DateTime($user->start_date))->format('d/m/Y');
    if($user->end_date){
        $user->end_date = (new DateTime($user->end_date))->format('d/m/Y');
    }
}

loadTemplateView('users', [
    'users' => $users,
    'exception' => $exception
]);