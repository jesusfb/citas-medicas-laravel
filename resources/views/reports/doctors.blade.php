@extends('layouts.panel')

@section('content')

<div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Reporte: Médicos más activos</h3>
        </div>
      </div>
    </div>
    <div class="card-body" role="alert">
        <div  class="input-daterange datepicker row align-items-center"  data-date-format="yyyy-mm-dd">
            <div class="col">
                <div class="form-group">
                    <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                        </div>
                        <input id="start" class="form-control" placeholder="Start date" type="text" value={{$start}}>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                        </div>
                        <input id="end" class="form-control" placeholder="End date" type="text" value={{$end}} >
                    </div>
                </div>
            </div>
        </div>
        <div id="container"></div>
   </div>
   
</div>
@endsection
@section('scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="{{asset('js/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script>
    //HIGHCHARTS DEMOS -> BASIC COLUMN-

    const chart=Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Top 5: Médicos más activos'
    },/*
    subtitle: {
        text: 'Source: WorldClimate.com'
    },
    */
    xAxis: {
        categories: [

    ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Citas atendidas'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">Médico: {point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    //la cantidad de datas por series tiene que ser igual a xAxis
    series: [

    ]
});

//JQUERY
let $start,end;

function fetchData(){
const startDate= $start.val();
const endDate=$end.val();
const url = `/charts/data/doctors?start=${startDate}&end=${endDate}`;
 fetch(url) // peticion HTTP
    .then(function(response){
        return response.json(); // retorna el contenido en tipo JSON
    })
    .then(function(data){ // RECIBE EL CONTENIDO EN FORMATO JSON, DESPUES DE LA PETICIOON AL SERVIDOR
       console.log(data)
        chart.xAxis[0].setCategories(data.categories);
        if(chart.series.length > 0){
            chart.series[1].remove();
            chart.series[0].remove();
        }
        chart.addSeries(data.series[0]); //Citas atendidas"
        chart.addSeries(data.series[1]); // Citas canceladas"
    });
}
$(function(){
    $start=$('#start');
    $end=$('#end'); 
    fetchData();
    $start.change(fetchData);
    $end.change(fetchData);
});
</script>
@endsection
