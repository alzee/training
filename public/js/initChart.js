let ctx1 = document.getElementById('chart1');
let ctx2 = document.getElementById('chart2');
let ctx3 = document.getElementById('chart3');
let ctx4 = document.getElementById('chart4');
let ctx5 = document.getElementById('chart5');
let d1 = document.querySelectorAll('.areaPeople');
let data1 = {
  labels: [],
  datasets: [{
    label: '领用排行榜',
    backgroundColor: '#0dcaf0',
    data: []
  }]
};
for (let i = 0; i < d1.length; i++){
  data1.labels.push((d1[i].dataset.area));
  data1.datasets[0].data.push((d1[i].dataset.people));
  console.log(d1[i].dataset.area);
}

let d2 = document.querySelectorAll('.ageGroup');
let data2 = {
  labels: [],
  datasets: [{
    backgroundColor: ['#0dcaf0', "rgb(255, 99, 132)","rgb(54, 162, 235)","rgb(255, 205, 86)", "#cd3c63", '#6174d1'],
    data: []
  }]
};
for (let i = 0; i < d2.length; i++){
  console.log(d2[i]);
  data2.labels.push((d2[i].dataset.age));
  data2.datasets[0].data.push((d2[i].dataset.people));
  console.log(d2[i].dataset.age);
}

let options = {
    responsive:true,
    maintainAspectRatio: false,
    legend: {
        display: false,
    },
    scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true
            }
        }]
    }
};

let chart1 = new Chart(ctx1, {
    type: 'horizontalBar',
    data: data1,
    options: options
});

let chart2 = new Chart(ctx2, {
    type: 'pie',
    data: data2,
    options: {
      legend: {
        display: false,
      }
    }
});

let chart3 = new Chart(ctx3, {
    type: 'doughnut',
    //data: data,
    data: {
        labels: [],
        datasets: [{
            backgroundColor: ['#0dcaf0'],
            data: [20,80]
        }]
    },
    options: {
      legend: {
        display: false,
      }
    }
});

let chart4 = new Chart(ctx4, {
    type: 'doughnut',
    //data: data,
    data: {
        labels: [],
        datasets: [{
            backgroundColor: ['#0dcaf0'],
            data: [90,10]
        }]
    },
    options: {
      legend: {
        display: false,
      }
    }
});

let chart5 = new Chart(ctx5, {
    type: 'doughnut',
    //data: data,
    data: {
        labels: [],
        datasets: [{
            backgroundColor: ['#0dcaf0'],
            data: [40,60]
        }]
    },
    options: {
      legend: {
        display: false,
      }
    }
});
