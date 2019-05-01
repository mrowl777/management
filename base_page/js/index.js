function init() {
    init_events();
}

function init_events() {
    $('#exit').on('click', kill_session);
    $('#database').on('click', e => send_request( e , 'manage_db' ));
    $('#settings').on('click', e => send_request( e , 'open_settings' ));
    $('#monitoring').on('click', e => send_request( e , 'open_monitor' ));
    $('#targets').on('click', e => send_request( e , 'open_targets' ));
}

function send_request( e , cat ){
    $( e.target ).parent().parent().find('a').removeAttr('checked');
    $( e.target ).attr('checked', 'checked');
    $.post(
        "index.php",
        {
            action: cat
        },
        load_module
    );
    e.preventDefault(); 
}

function kill_session(e) {
    e.preventDefault();
    $.post(
        "index.php",
        {
            action: "logout"
        },
        onAjaxSuccess
    );
}

function load_module(data) {
    $('.content_box').replaceWith(data);
}

function onAjaxSuccess() {
    window.location.href = '/onl_tracker/';
}

document.addEventListener('DOMContentLoaded', function () {
    init();
});