@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Quick Count Pemilu Presiden 2019</div>

                <div class="card-body">
                    <center><h1 id="loading">Please Wait..</h1></center>
                    <div id="diagram" style="display:none;">
                        <h5>Aku tresno karo koe, koe kudu ngerti iki : </h5>
                        <p>Diagram ini menggunakan API JSON dari KPU secara realtime, dan akan otomatis<br> terupdate secara otomatis
                            link <strong><a href="https://pemilu2019.kpu.go.id/static/json/hhcw/ppwp.json">API KPU https://pemilu2019.kpu.go.id/static/json/hhcw/ppwp.json</a></strong>.
                        </p>
                        <canvas id="myChart" width="200" height="100"></canvas>
                        <div class="" style="margin-top:10px;">
                            <div style="border-bottom: dashed 1px rgb(215,215,215); padding-top:1px;">
                            <label>Perolehan suara Ir H Joko widodo</label><strong style="float:right" class="pull-right" id="a"></strong>
                            </div>
                            <div style="border-bottom: dashed 1px rgb(215,215,215); padding-top:5px;">
                                <label>Perolehan suara H Prabowo Subianto</label> <strong style="float:right" id="b"></strong>
                            </div>
                            <div style="">
                                Proggress <strong id="prosses"></strong> dari <strong id="tps"></strong> TPS (<strong id="persen"></strong>%)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer">
    <label>&copy; 2019 | <a href="#">Adji Pangestu, S.Kom (baru calon)</a> - adji.pangestu@hotmail.com</label>
</div>
@endsection
@push('script')
<script>
function getData() {
    $.ajax({
        url: '{{url("data/suara")}}',
        type: 'GET',
        async: true,
        contentType: 'application/json',
        crossDomain:true,
        success: function(response) {
            var A = response.jokowi
            var B = response.prabowo
            var totalALL = A+B;
            var totalA = (A/totalALL)*100;
            var totalB = (B/totalALL)*100;
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
        url: '{{url("data/proses")}}',
        type: 'GET',
        async:true,
        contentType: 'application/json',
        crossDomain:true,
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
</script>
@endpush