function getList(api, property, queryStr, arr){
  let id = new URLSearchParams(window.location.search).get('entityId');
  let xhr = new XMLHttpRequest();
  let url = window.location.origin;
  let tbody = document.querySelector('#table tbody');
  let row = document.querySelector('#table tbody tr');
  tbody.removeChild(row);

  // checkins
  let xhr1 = new XMLHttpRequest();
  xhr1.onreadystatechange = function () {
    if(xhr1.readyState === XMLHttpRequest.DONE){
      if(xhr1.status === 200){
          let res1 = xhr1.response;

          xhr.onreadystatechange = function () {
              if(xhr.readyState === XMLHttpRequest.DONE){
                  if(xhr.status === 200){
                      let checkins = res1['hydra:member'];
                      console.log(res1['hydra:member']);
                      let res = xhr.response[property];
                      for(let i = 0; i < res.length; i++){
                          for(let j = 0; j < row.children.length; j++){
                              if(arr[j] == 'endAt' || arr[j] == 'startAt'){
                                  let d = new Date(res[i][arr[j]]);
                                  console.log(d);
                                  res[i][arr[j]] = d.getFullYear() + '年' + (d.getMonth() + 1) + '月' + d.getDate() + '日';
                              }
                              row.children[j].innerText = res[i][arr[j]];
                          }
                          row.lastElementChild.innerText = '否';
                          for(let j = 0; j < checkins.length; j++){
                              console.log(checkins[j][queryStr]);
                              if(id == checkins[j][queryStr].split("/")[3]){
                                  row.lastElementChild.innerText = '是';
                                  break;
                              }
                          }
                          tbody.appendChild(row.cloneNode(true));
                      }
                  }
              }
          };
          xhr.open('GET', url + api + id);
          xhr.responseType='json';
          xhr.send();
      }
    }
  };
    xhr1.open('GET', url + '/api/checkins?' + queryStr + '.id=' + id);
    xhr1.responseType='json';
    xhr1.send();
}

let tg = document.querySelector('#training-head');
let te = document.querySelector('#trainee-head');
if(tg){
    getList('/api/trainees/', 'training', 'trainee', ['id', 'title', 'description', 'instructor', 'endAt', 'checkin']);
}
if(te){
    getList('/api/trainings/', 'trainees', 'training', ['name', 'id', 'age', 'area', 'pstatus', 'checkin']);
}

