function login() {
    init_login_events();
}

function init_login_events() {
    $('[name=submit]').on('click', try_au);
    $('.reg_btn').on('click', refactor_form);
}

function try_au(e) {
    e.preventDefault();
    var type = $('[name=action]').val();
    var login = $('[name=login]').val() !== '';
    var password = $('[name=password]').val() !== '';
    var password_again = $('[name=repeat]').val() !== '';
    var ident = $('[name=password]').val() === $('[name=repeat]').val();
    
    if( !login ){
        showError('Введите логин');
    }else if( !password ){
        showError('Введите пароль');
    }else if( !password_again && type === 'register'){
        showError('Повторите пароль');
    }else if( !ident  && type === 'register'){
        showError('Пароли не совпадают');
    }else{
        $.ajax({
            type: "POST",
            url: "index.php",
            data: $('form').serialize(),
            success: onAjaxSuccess
        }); 
    } 
}

function onAjaxSuccess(data) {
    if ( data === 'auth_error' ) {
        showError('Ошибка авторизации. Проверьте правильность данных');
        return false;
    }else if( data === 'wrong_nickname' ){
        showError('Имя занято. Выберите другое имя и повторите попытку');
        return false;
    }
    window.location.href = '/staff_management/';
}

function refactor_form(e) {
    e.preventDefault();
    var reg_ico = $(this).find('i');
    var submit_ico = $('[name=submit]').find('i');
    var exists = $(document).find('.field.repeat').length !== 0;
    if (!exists) {
        reg_ico.removeClass('icon-user-plus');
        reg_ico.addClass('icon-times');

        submit_ico.removeClass('icon-arrow-right');
        submit_ico.addClass('icon-check-circle');

        $('[name=action]').val('register');

        $(this).css('top', '30px');
        $('[name=submit]').parent().css('top', '30px');
        $('.submit').before('<p class="field repeat"><input type="password" name="repeat" placeholder="Повторите пароль"><i class="icon-lock icon-large"></i></p>');
    }else{
        reg_ico.addClass('icon-user-plus');
        reg_ico.removeClass('icon-times');
    
        submit_ico.addClass('icon-arrow-right');
        submit_ico.removeClass('icon-check-circle');
    
        $('[name=action]').val('login');
    
        $(this).css('top', '10px');
        $('[name=submit]').parent().css('top', '10px');
        $('.repeat').remove();
    }
}

function showError( error ) {
    var bar = $('#snackbar');
    bar.text( error );
    var x = document.getElementById("snackbar");
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
  }

document.addEventListener('DOMContentLoaded', function () {
    login();
});