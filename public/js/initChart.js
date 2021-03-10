let ctx1 = document.getElementById('chart1');
let ctx2 = document.getElementById('chart2');
let ctx3 = document.getElementById('chart3');
let ctx4 = document.getElementById('chart4');
let ctx5 = document.getElementById('chart5');

let data = {
    labels: ['1月', '2月', '3月', '4月', '5月', '6月'],
    datasets: [{
        label: '物品领用统计',
        barPercentage: 0.5,
        barThickness: 6,
        maxBarThickness: 8,
        minBarLength: 2,
        backgroundColor: '#0d6efd',
        data: [10, 20, 30, 40, 50, 60, 70]
    }]
};

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
    //data: data,
    data: {
        labels: ['1月', '2月', '3月', '4月', '5月', '6月'],
        datasets: [{
            label: '领用排行榜',
            backgroundColor: '#0dcaf0',
            data: [638, 300, 488, 1050, 214, 843]
        }]
    },
    options: options
});

let chart2 = new Chart(ctx2, {
    type: 'pie',
    //data: data,
    data: {
        labels: ['20-25', '25-30', '30-35', '35-40', '40-45', '18-20'],
        datasets: [{
            backgroundColor: ['#0dcaf0', "rgb(255, 99, 132)","rgb(54, 162, 235)","rgb(255, 205, 86)", "#cd3c63", '#6174d1'],
            data: [638, 300, 488, 1050, 214, 843]
        }]
    },
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
