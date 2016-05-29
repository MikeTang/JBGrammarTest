// Avoid `console` errors in browsers that lack a console.
(function() {

    $('.btn-code').click(function(e) {
        var number = $('#txt_phone').val();
        
        if (number == ''){
            alert('please enter a phone number!');
        }else{
            $.ajax({
              url: getCodeURL + '/' + number,
              context: document.body
            }).done(function(data) {
              alert(data);
            });
        }

        
    });

    $('.btn-bug').click(function(e) {
        var number = $('#txt_phone').val();
        
        if (number == ''){
            alert('感谢反馈问题，已记录!');
        }else{
            $.ajax({
              url: getCodeURL + '/' + number,
              context: document.body
            }).done(function(data) {
              alert(data);
            });
        }
        
    });

    $('.btn-toReg').click(function(e) {
        var number = $('#txt_phone').val();
        
        if (number == ''){
            alert('要使用语法字典请先注册登录!');
        }else{
            $.ajax({
              url: getCodeURL + '/' + number,
              context: document.body
            }).done(function(data) {
              alert(data);
            });
        }
    });

    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeline', 'timelineEnd', 'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
    
    var elem = document.getElementById("correct_answers");
    var easeOutCubic = function(t, b, c, d) {
        var ts = (t /= d) * t;
        var tc = ts * t;
        return b + c * (2.0635683940025e-1 * tc * ts + 0.999999999999998 * tc + -3 * ts + 3 * t);
    };
    var options = {
      easingFn: easeOutCubic
    };
    var numAnim = new CountUp(elem, 0, targetCounter, 0, 1.5, options);
    
    numAnim.start();



}());




// Place any jQuery/helper plugins in here.

