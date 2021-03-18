function face() {
    let data = { 
        "sn":"RL001-00186",
        "Count":1,
        "logs":[
            {
                "user_id":"3118",
                "recog_time":"2019-01-01 11:11:11",
                "recog_type":"face",
                "photo":"base64",
                "body_temperature":"36.5",
                "confidence":"95.5",
                "reflectivity":86,
                "room_temperature":25.5
            }
        ]
    }
    data = JSON.stringify(data);
    let xhr = new XMLHttpRequest();
    let url = 'http://training';
    xhr.onreadystatechange = function () {
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                res = xhr.response;
                console.log(res);
            }
        }
    };
    xhr.open('POST', url + '/api/v1/record/face');
    xhr.setRequestHeader("Accept", "application/json");
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.responseType='json';
    xhr.send(data);
}

function stranger() {
    let data =  {
        "sn": "RL001-00186",
        "Count":1,
        "logs":[
            {
                "user_id":"334", 
                "recog_time":"2018-12-26 12:00:00",
                "recog_type":"face",
                "photo":"base64",
                "body_temperature":"36.5",
                "confidence":"95.5",
                "reflectivity":86,
                "gender":1,
                "room_temperature":25.5
            },
            {
                "user_id":"334", 
                "recog_time":"2018-12-26 12:00:00",
                "recog_type":"face",
                "photo":"base64",
                "body_temperature":"36.5",
                "confidence":"95.5",
                "reflectivity":86,
                "gender":1,
                "room_temperature":25.5
            }
        ]
    };
    data = JSON.stringify(data);
    let xhr = new XMLHttpRequest();
    let url = 'https://training.itove.com';
    xhr.onreadystatechange = function () {
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                res = xhr.response;
                console.log(res);
            }
        }
    };
    xhr.open('POST', url + '/api/v1/stranger');
    xhr.setRequestHeader("Accept", "application/json");
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.responseType='json';
    xhr.send(data);
}

let btn1 = document.querySelector('#face');
if(btn1){
    btn1.addEventListener('click',face);
}
let btn2 = document.querySelector('#stranger');
if(btn2){
    btn2.addEventListener('click', stranger);
}
