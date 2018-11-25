function _login(id, pw, rm) {
    $.ajax({
        type: "POST",
        url: "user/login",
        data: {
            "id": id,
            "pw": pw,
            "rm": rm
        },
        dataType: "json",
        success: function (response) {
            if (response.status > 0) {
                alert(response.msg);
                location.href = "/";
            } else {
                alert(response.msg);
                $('#btn-login').html('登录');
                $('#btn-login').removeAttr('disabled');
            };
        }
    });
}

function _logout() {
    $.ajax({
        type: "POST",
        url: "user/logout",
        dataType: "json",
        success: function (response) {
            if (response.status > 0) {
                alert(response.msg);
                location.href = "/";
            } else {
                alert(response.msg);
            };
        }
    });
}

function _cpw(old_pw,new_pw,callback) {
    $.ajax({
        type: "POST",
        url: "user/cpw",
        data: {
            'old_pw': old_pw,
            'new_pw': new_pw
        },
        dataType: "json",
        success: function (response) {
            if (response.status > 0) {
                alert(response.msg);
                window.location.href = "/";
            } else {
                alert(response.msg);
                callback();
            };
        }
    });
}

$('#a-logout').click(function () {
    $(this).html('请稍候');
    _logout();
});


Date.prototype.Format = function (fmt) { //author: meizz 
    var o = {
        "M+": this.getMonth() + 1,
        "d+": this.getDate(),
        "h+": this.getHours(),
        "m+": this.getMinutes(),
        "s+": this.getSeconds(),
        "q+": Math.floor((this.getMonth() + 3) / 3),
        "S": this.getMilliseconds()
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
    if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
}