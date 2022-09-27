/* globals $ */

$(function () {
    // ナビバー特定スクロール固定
    var menu = $("nav");
    var menu_offset = menu.offset();
    $(window).scroll(function () {
        if ($(window).scrollTop() > menu_offset.top) {
            menu.addClass("fixed");
        } else {
            menu.removeClass("fixed");
        }
    });

    // ジャンプボタン特定位置表示
    var jump = $("#intro");
    var jump_offset = jump.offset();
    $(window).scroll(function () {
        if (!jump_offset) {
            return false;
        }
        if ($(window).scrollTop() > jump_offset.top) {
            $(".jump").addClass("fade-in");
        } else {
            $(".jump").removeClass("fade-in");
        }
    });

    // トップに戻る
    $(".jump").on("click", function () {
        $("html").animate({ scrollTop: 0 }, 800);
    });

    $('#nav_content a[href*="#"]').on("click", function () {
        var elmHash = $(this).attr("href");
        var pos = $(elmHash).offset().top;
        $("html").animate({ scrollTop: pos }, 500);
        return false;
    });

    $(".modal").modaal({
        overlay_opacity: "0.5",
        background_scroll: "true",
        hide_close: "false",
        width: 400,
    });

    // jsバリデーション
    $("#contact_button").on("click", function (event) {
        var error = [];

        if ($("input[name='name']").val() == "") {
            error.push("氏名は必須入力です。");
        }
        if ($("input[name='name']").val().length > 10) {
            error.push("氏名は10文字以内でご入力ください。");
        }
        if ($("input[name='kana']").val() == "") {
            error.push("フリガナは必須入力です。");
        }
        if ($("input[name='kana']").val().length > 10) {
            error.push("フリガナは10文字以内でご入力ください。");
        }
        if (!/^([0-9]{0,})$/.test($("input[name='tel']").val())) {
            error.push("電話番号は0-9の数字のみでご入力ください。");
        }
        if (
            !/^[a-zA-Z0-9_+-]+(\.[a-zA-Z0-9_+-]+)*@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*/.test(
                $("input[name='email']").val()
            )
        ) {
            error.push("メールアドレスは正しくご入力ください。");
        }
        if ($("textarea[name='body']").val() == "") {
            error.push("お問い合わせ内容は必須入力です。");
        }

        if (error.length != 0) {
            alert(error.join("\n"));
            return;
        }
    });

    $(".delete").on("click", function (e) {
        var result = window.confirm("本当に削除しますか？");

        if (!result) {
            e.preventDefault();
        }
    });
});
