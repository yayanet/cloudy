$(function(){
    $.get('/notebook/list', {}, function(data){
        $('.note-notebook-panel').html(data);
        
        var $first = $('.note-notebook-panel .notebook-item:first');
        if ($first.length > 0) {
            var notebookId = $first.attr('notebook-id');
            $.get('/note/list', {notebook_id: notebookId}, function(data) {
                $('.note-note-panel').html(data);
            });
        }
    });
});
