let ctx1 = document.getElementById('chart1');
let ctx2 = document.getElementById('chart2');
let ctx3 = document.getElementById('chart3');
let ctx4 = document.getElementById('chart4');
let ctx5 = document.getElementById('chart5');
let ctx6 = document.getElementById('chart6');
let countTrainees = document.getElementById('countTrainees').dataset.count;
let d1 = document.querySelectorAll('.areaPeople');
let d2 = document.querySelectorAll('.ageGroup');
let d3 = ctx3.dataset.soldiers;
let d4 = ctx4.dataset.partymembers;
let data1 = {
  labels: [],
  datasets: [{
    label: '',
    backgroundColor: '#0dcaf0',
    data: []
  }]
};
let data2 = {
  labels: [],
  datasets: [{
    backgroundColor: ['#0dcaf0', "rgb(255, 99, 132)","rgb(54, 162, 235)","rgb(255, 205, 86)", "#cd3c63", '#6174d1'],
    data: []
  }]
};
let data3 = {
  labels: ['退伍军人', '其他'],
  datasets: [{
    backgroundColor: ['#0dcaf0', '#cbcfd4'],
    data: [d3, countTrainees - d3]
  }]
};
let data4 = {
  labels: ['党员', '其他'],
    datasets: [{
      backgroundColor: ['#0dcaf0', '#cbcfd4'],
      data: [d4, countTrainees - d4]
    }]
};
let data5 = {
  labels: ['对口', '非对口'],
  datasets: [{
    backgroundColor: ['#0dcaf0', '#cbcfd4'],
    data: [ctx5.dataset.checkins, ctx5.dataset.shouldcome - ctx5.dataset.checkins]
  }]
};

let data6 = {
  labels: ['初中', '高中', '大专', '本科及以上'],
  datasets: [{
    backgroundColor: ['#0dcaf0', '#6174d1', '#1ea471', '#cd3c63'],
    data: [1, 1, 3, 5]
  }]
};

for (let i = 0; i < d1.length; i++){
  data1.labels.push((d1[i].dataset.area));
  data1.datasets[0].data.push((d1[i].dataset.people));
  console.log(d1[i].dataset.area);
}
for (let i = 0; i < d2.length; i++){
  console.log(d2[i]);
  data2.labels.push((d2[i].dataset.age));
  data2.datasets[0].data.push((d2[i].dataset.people));
  console.log(d2[i].dataset.age);
}

let chart1 = new Chart(ctx1, {
    type: 'bar',
    data: data1,
    options: {
      responsive:true,
      maintainAspectRatio: false,
      indexAxis: 'y',
      plugins: {
        legend: {
          display: false
        }
      },
      scales: {
        x: {
          ticks: {
            beginAtZero: true,
          }
        }
      }
    }
});

let chart2 = new Chart(ctx2, {
    type: 'pie',
    data: data2,
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }
      },
    }
});

let chart3 = new Chart(ctx3, {
    type: 'doughnut',
    data: data3,
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }
      },
    }
});

let chart4 = new Chart(ctx4, {
    type: 'doughnut',
    data: data4,
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }
      },
    }
});

let chart5 = new Chart(ctx5, {
    type: 'doughnut',
    data: data5,
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }
      },
    }
});

let chart6 = new Chart(ctx6, {
    type: 'doughnut',
    data: data6,
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }
      },
    }
});
