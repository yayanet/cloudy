$.extend({
    disposeResponse : function(response){
        if (response.message) {
            alert(response.message);
        }

        if (response.redirect) {
            location.href = response.redirect;
        }
        else if (response.need_reload) {
            location.href = location.href;
        }
    },

    easyPost : function(url, params, callback) {
        $.post(url, params, function(response) {
            $.disposeResponse(response);

            if (typeof(callback) == 'function') {
                callback(response);
            }
        }, 'json');
    }
});
