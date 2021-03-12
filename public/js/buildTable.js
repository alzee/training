function getTraininglist(){
  let id = new URLSearchParams(window.location.search).get('entityId');
  let xhr = new XMLHttpRequest();
  let url = 'http://training/api/trainings/';
  let tbody = document.querySelector('#table tbody');
  let row = document.querySelector('#table tbody tr');
  tbody.removeChild(row);
  xhr.onreadystatechange = function () {
    if(xhr.readyState === XMLHttpRequest.DONE){
      if(xhr.status === 200){
        let trainees = xhr.response.trainees;
        for(let i = 0; i < trainees.length; i++){
          row.firstElementChild.innerText = trainees[i].name;
          row.firstElementChild.nextElementSibling.innerText = trainees[i].id;
          row.firstElementChild.nextElementSibling.nextElementSibling.innerText = trainees[i].age;
          row.firstElementChild.nextElementSibling.nextElementSibling.nextElementSibling.innerText = trainees[i].area;
          row.firstElementChild.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.innerText = trainees[i].pstatus;
          row.firstElementChild.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.innerText = trainees[i].checkins;
          tbody.appendChild(row.cloneNode(true));

          console.log(trainees[i]);
        }
      }
    }
  };
  xhr.open('GET', url + id);
  xhr.responseType='json';
  //xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.send();
}

function getTraineelist(){
  let id = new URLSearchParams(window.location.search).get('entityId');
  let xhr = new XMLHttpRequest();
  let url = 'http://training/api/trainees/';
  let tbody = document.querySelector('#table tbody');
  let row = document.querySelector('#table tbody tr');
  tbody.removeChild(row);
  xhr.onreadystatechange = function () {
    if(xhr.readyState === XMLHttpRequest.DONE){
      if(xhr.status === 200){
        let training = xhr.response.training;
        for(let i = 0; i < training.length; i++){
          row.firstElementChild.innerText = training[i].id;
          row.firstElementChild.nextElementSibling.innerText = training[i].title;
          row.firstElementChild.nextElementSibling.nextElementSibling.innerText = training[i].description;
          row.firstElementChild.nextElementSibling.nextElementSibling.nextElementSibling.innerText = training[i].instructor;
          row.firstElementChild.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.innerText = training[i].instructor;
          row.firstElementChild.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.innerText = training[i].checkins;
          tbody.appendChild(row.cloneNode(true));

          console.log(training[i].checkins);
        }
      }
    }
  };
  xhr.open('GET', url + id);
  xhr.responseType='json';
  //xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.send();
}

let tg = document.querySelector('#training-head');
let te = document.querySelector('#trainee-head');
if(tg){
  getTraininglist();
}
if(te){
  getTraineelist();
}
