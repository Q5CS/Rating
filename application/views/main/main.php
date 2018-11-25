<div class="fly-content" style="margin-top:1rem">
    <?php
    foreach ($shops as $t) {
        $id = $t['id'];
        $name = $t['name'];
        $desc = $t['descrp'];
        $rate = round($t['rate'], 1);
        //$img = $t['main_pic'];
        $img = 'https://rating-cdn.qz5z.ren/assets/img/shops/' . $t['main_pic'];
        echo "
            <section class=\"shops-box am-panel am-panel-default\">
            <header class=\"am-panel-hd\">
                <h3 class=\"am-panel-title\">$name</h3>
            </header>
            <div class=\"am-panel-bd\">
                <div class=\"am-g\">
                    <div class=\"am-u-sm-6\" style=\"padding-left: 0;\">
                        <img class=\"am-img-responsive am-radius\" src=\"$img\"></img>
                    </div>
                    <div class=\"am-u-sm-6\">
                        <div class=\"am-g\">
                            <div style=\"text-align: right\">
                                <span class=\"shops-rate-this\" id=\"rate-$id\">$rate</span> <span class=\"shops-rate-total\">/ 5</span>
                            </div>
                        </div>
                        <div class=\"am-g\">
                            <button type=\"button\" class=\"shops-view-btn am-btn am-btn-primary am-fr\" sid=\"$id\">查看评价</button>
                        </div>
                    </div>
                    </div>
            </div>
            </section>
        ";
    }
    ?>
</div>

<div class="am-modal am-modal-no-btn" tabindex="-1" id="shop-detail-modal">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">
            <span id="shop-modal-title"></span>
            <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
        </div>
        <div class="am-modal-bd" id="shop-modal-content">

        </div>
    </div>
</div>

<div class="am-modal am-modal-no-btn" tabindex="-1" id="new-rate-modal">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">
            <span id="shop-modal-title"></span>
            发布评价
            <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
        </div>
        <div class="am-modal-bd" id="shop-modal-content">
            <div class="rate-select">
                <span>菜品：</span>
                <select id="rate1">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="rate-select">
                <span>卫生：</span>
                <select id="rate2">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="rate-select">
                <span>价格：</span>
                <select id="rate3">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>

            <div class="am-input-group" style="width: 100%">
                <textarea type="text" class="am-form-field" id="rate-comment" placeholder="评价内容 (60 字以内，匿名发布，请勿发表过激或违规言论)" maxlength="60" style="min-height: 5rem"></textarea>
            </div>

            <button type="button" id="new-rate-btn" class="am-btn am-btn-primary am-btn-block">发布</button>
            <small>一旦发布，即意味您已阅读并同意<a data-am-modal="{target: '#protocol-modal'}">使用协议</a></small>
        </div>
    </div>
</div>

<div class="am-modal am-modal-confirm" tabindex="-1" id="confirm-modal">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">
      请确认
      <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
    </div>
    <div class="am-modal-bd">
    <span class="am-modal-bd-ico am-icon-exclamation-circle am-text-warning"></span>
    <p>评价发布后无法修改，请确认是否发布？</p>
    </div>
    <div class="am-modal-footer">
      <button type="button" class="am-btn am-modal-btn am-btn-default am-btn-hollow"  data-am-modal-cancel>取消</button>
      <button type="button" class="am-btn am-modal-btn am-btn-primary" data-am-modal-confirm>确定</button>
    </div>
  </div>
</div>

<div class="am-modal am-modal-no-btn" tabindex="-1" id="protocol-modal">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">使用协议
      <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
    </div>
    <div class="am-modal-bd">
      <small>
      1. 我们将通过校园网获取您的用户编号、姓名、班级、年段及座位号，并跟随您发布的内容一起储存在数据库中；<br>
      2. 如您发布了违规/违法内容，我们可能采取删除内容、封禁帐号等一系列措施，不再另行通知；情节严重的情况下，我们将在不经过您的许可的情况下，向校方及有关部门提供上述信息。<br>
      3. 如非上述情况，在未经您的许可的情况下，我们不会向除了您以外的其他个人或组织透露您的以上信息；<br>
      4. 如您选择发布评价，即视为您已充分理解并同意上述内容。
      </small>
    </div>
  </div>
</div>