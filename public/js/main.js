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
}

let btn = document.querySelector('#batchBtn');
if(btn){
    btn.addEventListener('click', batchApply);
}

//trainingList();
