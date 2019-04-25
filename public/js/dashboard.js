function getData() {
    $.ajax({
        url: '/quick/count',
        type: 'GET',
        success: function(response) {
            var A = response.jokowi
            var B = response.prabowo
            var totalALL = A+B;
            var totalA = (A/totalALL)*100;
            var totalB = (B/totalALL)*100;
            console.log(totalA); 
            chart(totalA.toFixed(2),totalB.toFixed(2))
            $('#a').html(A)
            $('#b').html(B)
            $('#loading').hide();
            $('#diagram').show();
        }
    })
}

function proggess() {
    $.ajax({
        url: '/quick/proses',
        type: 'GET',
        success: function(response) {
            var A = response.prosses 
            var B = response.total
            var total = A/B*100; 
            $('#prosses').text(A);
            $('#tps').text(B);
            $('#persen').text(total.toFixed(5));
        }
    })
}

proggess();
getData();

setInterval(function(){
getData();
},5000);

function chart(a,b) {
    var ctx = document.getElementById('myChart');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Ir H Jokowi','H Prabowo'],
            datasets: [{
                label: '# of Votes',
                data: [a,b],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 2
            }]
        },
        legend: {
            display: false,
        },
        options: {
            scales: {
                xAxes: [{
                    gridLines: {
                        display:false,
                        color: "rgba(0, 0, 0, 0)",
                    },
                    ticks: {
                        beginAtZero: true,
                        display: false,
                    }
                }],
                yAxes: [{
                    gridLines: {
                        display:false,
                        color: "rgba(0, 0, 0, 0)",
                    },
                    ticks: {
                        beginAtZero: true,
                        display: false
                    }
                }]
            },
            tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                return data['labels'][tooltipItem['index']] + ': ' + data['datasets'][0]['data'][tooltipItem['index']] + '%';
                }
            }
            }
        },
    });
}