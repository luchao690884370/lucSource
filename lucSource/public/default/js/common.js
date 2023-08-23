
function tip(msg, type) {
    var type = type ? type : 2;
    layer.msg(msg, { icon: type });
}



function dataDotSet(action, type, data, callback, load_flag) {
    var $ = layui.$;
    var load_flag = load_flag ? load_flag : 0;
    var value = { success: false, message: '' };
    if (load_flag == 1) {
        layer.load(1);
    }
    $.ajax({
        url: action,
        async: false,
        type: type,
        dataType: 'json',
        data: data,
        jsonpCallback: 'myCallback',
        success: function (res) {
            console.log("dataDotSet res", res);
            if (load_flag == 1) {
                layer.closeAll('loading');
            }

            if (typeof (callback) == 'function') {
                callback(res);
            }
        },
        error: function () {
            if (load_flag == 1) {
                layer.closeAll('loading');
            }
            console.log('请求失败');
        }
    });

}


function dataDotSetImg(action, type, data, callback, load_flag) {
    var $ = layui.$;
    var load_flag = load_flag ? load_flag : 0;
    var value = { success: false, message: '' };
    if (load_flag == 1) {
        layer.load(1);
    }

    $.ajax({
        url: APPPURL + action,
        async: false,
        type: type,
        dataType: 'json',
        data: data,
        processData: false,
        contentType: false,
        jsonpCallback: 'myCallback',
        success: function (res) {
            //   console.log("dataDotSetImg res",res);
            if (load_flag == 1) {
                layer.closeAll('loading');
            }
            console.log(res);
            if (typeof (callback) == 'function') {
                callback(res);
            }
        },
        error: function () {
            if (load_flag == 1) {
                layer.closeAll('loading');
            }
            console.log('请求失败');
        }
    });
}


function myCallback(data) {
    console.log('数据请求成功');
    console.log(data);
}

function win_back() {
    history.go(-1);
}

function isEmail(s) {
    return /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,4}$/.test(s)
}

function isWechat() {
    return String(window.navigator.userAgent.toLowerCase().match(/MicroMessenger/i)) === "micromessenger";
}


function isURL(s) {
    return /^http[s]?:\/\/.*/.test(s)
}

function isPhone(s) {
    return /^1[1|2|3|4|5|6|7|8|9][0-9]{9}$/.test(s)
}

function isMobile(s) {
    return /^1[3456789]\d{9}$/.test(s)
}


function get_ymd() {
    var data = new Date();
    var y = data.getFullYear(); //年
    var m = (data.getMonth() + 1) < 10 ? "0" + (data.getMonth() + 1) : data.getMonth() + 1; //月
    var d = data.getDate() < 10 ? "0" + data.getDate() : data.getDate(); //日
    return y + '-' + m + '-' + d;
}

function timestampToymdhms(timestamp) {
    const date = new Date(timestamp * 1000); // 将时间戳乘以1000转换为毫秒，并传入Date构造函数
    const year = date.getFullYear(); // 获取年份
    const month = date.getMonth() + 1; // 获取月份，注意JavaScript的月份是从0开始计算的，所以要加1
    const day = date.getDate(); // 获取日期
    const hour = date.getHours(); // 获取小时
    const minute = date.getMinutes(); // 获取分钟
    const second = date.getSeconds(); // 获取秒数
    const formattedTime = `${year}-${month}-${day} ${hour}:${minute}:${second}`;
    return formattedTime;
}

function playAudio(name) {
    var url = '../chat/res/' + name + '.mp3';
    const audio = new Audio(url);
    audio.play();
}
