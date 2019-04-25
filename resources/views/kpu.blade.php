@extends('layouts.adji')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2><b>Sekelik Corporation</b></h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <label>&copy; 2019 | <a href="https://pemilu2019.kpu.go.id/static/json/hhcw/ppwp.json" class="text-primary">Adji Pangestu, S.Kom (baru calon)</a> - adji.pangestu@hotmail.com</label>
                </li>      
            </ol>
        </div>
    </div>
    
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Quick Count Pemilihan Presiden 2019</h5>
                    </div>
                    <div class="ibox-content">
                        <center><h1 id="loading"><b>Please Wait... </b></h1></center>
                        <div id="diagram" style="display:none;">
                            <h3>Aku tresno karo koe, koe kudu ngerti iki : </h3>
                            <p>Diagram ini menggunakan API JSON dari KPU secara realtime, dan akan otomatis<br> terupdate secara otomatis
                                link <strong><a href="https://pemilu2019.kpu.go.id/static/json/hhcw/ppwp.json">API KPU https://pemilu2019.kpu.go.id/static/json/hhcw/ppwp.json</a></strong>.
                            </p>
                            <canvas id="myChart" height="70"></canvas>
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
