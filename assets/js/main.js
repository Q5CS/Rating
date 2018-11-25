$('#shop-detail-modal').on('closed.modal.amui', function () {
    $(this).removeData('amui.modal');
});
$('#new-rate-modal').on('closed.modal.amui', function () {
    $(this).removeData('amui.modal');
});

$('.shops-view-btn').click(function () {
    show($(this).attr('sid'), $(this))
});

function show(sid, jQele) {
    jQele.button('loading');
    $.ajax({
        type: "POST",
        url: "/main/shopinfo",
        data: {
            'id': sid
        },
        dataType: "json",
        success: function (response) {
            $('#shop-modal-title').html(response.name);
            rate = response.rate;
            rate1 = response.rate1;
            rate2 = response.rate2;
            rate3 = response.rate3;
            detail_tpl = `
            总分：<span class="shops-rate-this">${rate}</span> <span class="shops-rate-total">/ 5</span>
            <br>
            <small>菜品 / 卫生 / 价格 ：${rate1} / ${rate2} / ${rate3}</small>
            `;
            if (login) {
                if(response.canrate) {
                    detail_tpl += `<button type="button" class="am-btn am-btn-primary am-btn-block" id="new-rate" sid="${sid}">发布评价</button>`;
                } else {
                    detail_tpl += `<button type="button" class="am-btn am-btn-primary am-btn-block" disabled>您已发表过评价</button>`;
                }
                detail_tpl += `<hr>
                    <div id="rates">评价加载中，请稍候...</div><div id="rates-hide" style="display:none"></div>
                    `;
            } else {
                detail_tpl += `<hr>
                <span><a href="/main/login">登录</a>后，可以查看和发表评价</span>`;
            }
            $('#shop-modal-content').html(detail_tpl);
            if (login) getrates(sid);
            jQele.button('reset');
            $('#shop-detail-modal').modal({closeViaDimmer: false});
            $('#new-rate').click(function () {
                newRate($(this).attr('sid'));
            })
        }
    });
}

function getrates(sid) {
    $.ajax({
        type: "POST",
        url: "/main/rateinfo",
        data: {
            'id': sid
        },
        dataType: "json",
        success: function (response) {
            console.log(response);
            if (response.length == 0) {
                $('#rates').html('暂无评价');
                return;
            }
            t = ``;
            l = 3;
            if (response.length < 3) l = response.length;
            for (var i = 0; i < l; i++) {
                rate1 = response[i].rate1;
                rate2 = response[i].rate2;
                rate3 = response[i].rate3;
                time = formatDate(response[i].time*1000);
                comment = response[i].comment;
                t += `<p class="rate-info">
                    <small>时间 ：${time}</small>
                    <br>
                    <small>评分 ：${rate1} / ${rate2} / ${rate3}</small>
                    <br>
                    <small>评价 ：${comment}</small>
                </p>
                <hr>
                `;
            }
            if (response.length > 3) t += `<a id="showall" onclick="showall()" style="cursor: pointer;">查看所有评价</a>`;
            $('#rates').html(t);
            t = ``;
            if (response.length > 3)
                for (var i = 3; i < response.length; i++) {
                    rate1 = response[i].rate1;
                    rate2 = response[i].rate2;
                    rate3 = response[i].rate3;
                    time = formatDate(response[i].time*1000);
                    comment = response[i].comment;
                    t += `<p class="rate-info">
                    <small>时间 ：${time}</small>
                    <br>
                    <small>评分 ：${rate1} / ${rate2} / ${rate3}</small>
                    <br>
                    <small>评价 ：${comment}</small>
                </p>
                <hr>
                `;
                }
            $('#rates-hide').html(t);
        }
    });
}

function formatDate(timestamp) {
    var now = new Date(parseInt(timestamp));
    return now.Format("yyyy-MM-dd");
}

function showall() {
    $('#rates-hide').show();
    $('#showall').hide();
}

last = 0;
function newRate(sid) {
    console.log(sid);
    $('#shop-detail-modal').modal('close');
    $('#new-rate-modal').modal({closeViaDimmer: false});
    if (sid != last) {
        last = sid;
        $('#rate-comment').val('');
        $('#rate1').barrating({
            theme: 'fontawesome-stars'
        });
        $('#rate1').barrating('set', 5);
        $('#rate2').barrating({
            theme: 'fontawesome-stars'
        });
        $('#rate2').barrating('set', 5);
        $('#rate3').barrating({
            theme: 'fontawesome-stars'
        });
        $('#new-rate-btn').click(function () {
            confirm(sid);
        });
        $('#rate3').barrating('set', 5);
    }
}

function confirm(sid) {
    $('#confirm-modal').modal({
        relatedTarget: this,
        closeViaDimmer: false,
        onConfirm: function(e) {
            postNewRate(sid)
        },
        onCancel: function(e) {
        }
      });
}

function postNewRate(sid) {
    rate1 = $('#rate1 option:selected').val();
    rate2 = $('#rate2 option:selected').val();
    rate3 = $('#rate3 option:selected').val();
    comment = $('#rate-comment').val().trim();
    if (!comment) {
        alert('请填写评价内容！');
        return;
    }
    console.log(rate1, rate2, rate3, comment);
    $('#new-rate-btn').button('loading');
    $.ajax({
        type: "POST",
        url: "/main/post",
        data: {
            'sid': sid,
            'rate1': rate1,
            'rate2': rate2,
            'rate3': rate3,
            'comment': comment,
        },
        dataType: "json",
        success: function (response) {
            if (response.status > 0) {
                alert(response.msg);
                $('#new-rate-modal').modal('close');
                //$('#rate-'+sid).html(response.now);
                window.location.reload();
            } else {
                alert(response.msg);
            }
            $('#new-rate-btn').button('reset');
        }
    });
}
