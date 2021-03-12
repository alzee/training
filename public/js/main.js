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

trainingList();
