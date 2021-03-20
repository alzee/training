function trainingList() {
    let xhr = new XMLHttpRequest();
    let url = window.location.origin;
    let sel = document.querySelector('#traininglist');
    let opt = sel.firstElementChild;
    sel.removeChild(opt);
    xhr.onreadystatechange = function () {
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let res = xhr.response['hydra:member'];
                console.log(res);
                for(let i = 0; i < res.length; i++){
                  opt.value = res[i].id;
                  opt.innerText = res[i].title;
                  console.log(opt);
                  sel.appendChild(opt.cloneNode(true));
                }
              console.log(sel);
            }
        }
    };
    xhr.open('GET', url + '/api/trainings');
    xhr.responseType='json';
    xhr.send();
}


function batchApply() {
    let tab = document.querySelector('table.table');
    let tbody = tab.querySelector('tbody');
    let checkbox = tbody.querySelectorAll('.form-batch-checkbox');

    let sel = document.querySelector('#traininglist');
    let opt = sel.firstElementChild;

    let trainingId = sel.value;
    let trainees = [];
    for(let i = 0; i < checkbox.length; i++){
        if(checkbox[i].checked){
            trainees.push(checkbox[i].value);
        }
    }
    console.log(trainingId);
    console.log(trainees);

    //let data = `{ "tgid": ${trainingId}, "te": ${trainees} }`;
    let data = { tgid: trainingId, te: trainees };
    data = JSON.stringify(data);
    let xhr = new XMLHttpRequest();
    let url = window.location.origin;
    xhr.onreadystatechange = function () {
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                res = xhr.response;
                console.log(res);
                location.reload(true);
            }
        }
    };
    xhr.open('POST', url + '/api/tg');
    xhr.setRequestHeader("Accept", "application/json");
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.responseType='json';
    xhr.send(data);
}

function batchImport() {
    let xhr = new XMLHttpRequest();
    let url = window.location.origin;
    xhr.onreadystatechange = function () {
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                res = xhr.response;
                console.log(res);
                location.reload(true);
            }
        }
    };
    xhr.open('GET', url + '/api/trainee/import');
    xhr.setRequestHeader("Accept", "application/json");
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.responseType='json';
    xhr.send();
}

function capture() {
    let xhr = new XMLHttpRequest();
    let url = window.location.origin;
    let uid = new URLSearchParams(window.location.search).get('entityId');
    xhr.onreadystatechange = function () {
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                res = xhr.response;
                console.log(res);
                setTimeout(
                    function(){
                        location.reload(true);
                    }, 3000
                );
            }
        }
    };
    xhr.open('GET', url + '/api/capture/' + uid);
    xhr.setRequestHeader("Accept", "application/json");
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.responseType='json';
    xhr.send();
}

let btn1 = document.querySelector('#batchBtn');
if(btn1){
    btn1.addEventListener('click', batchApply);
}
let btn2 = document.querySelector('#import');
if(btn2){
    btn2.addEventListener('click', batchImport);
}
let btn3 = document.querySelector('.action-capture');
if(btn3){
    btn3.addEventListener('click', capture);
}

//trainingList();
