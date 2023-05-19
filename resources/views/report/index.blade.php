@extends('layouts.master')

@section('title','AdminLTE 2 | Master Page')


@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Trial
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Trial</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
          <div class="col-sm-6">
            <div class="box box-primary">
              <form class="form-horizontal" role="form" id="formIDe">
              <div class="box-header with-border">
                  <h5 class="box-title"><i class="fa fa-user"></i> Report Sales </h5>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
              </div>
              <div class="box-body">
                <div class="form-group">
                  <label for="inputsm" class="col-sm-2 control-label">Bulan</label>
                  <div class="col-sm-9" >
                    <input id="month" name="month" class="form-control input-sm monthPicker" autocomplete="off" placeholder="Pilih Bulan" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputsm" class="col-sm-2 control-label">Sales</label>
                  <div class="col-sm-9" >
                    <select name="sales" id="sales" class="form-control select3" style="width: 100%">
                      <option selected value="">All Sales </option>
                      @forelse ($responses as $response)
                      <option value="{{$response->user->name}}">{{$response->user->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="box-footer" id="foter">
                <input type="hidden" name="token" id="token" value="{{ Auth::user()->id }}">
                <button type="submit" class="btn btn-xs btn-info col-sm-3 col-sm-offset-4" name="cari" id="buttonIDe" onClick="">
                <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search
                </button>
              </div>
              </form>
            </div>
          </div>
      </div>

      <div class="row">
          <div class="col-sm-12" id="hasil">
            <div class="box box-primary">
              <div class="box-header with-border">
                  <h5 class="box-title"><i class="fa fa-pie-chart"></i> Result <i id="bulantampil"></i> </h5>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
              </div>
              <div class="box-body">

              </div>
            </div>
          </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <!-- DONUT CHART -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Donut Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <canvas id="pieChart" style="height:250px"></canvas>
            </div>
          </div>
        </div>
      </div>
      @include('panel.buttonhome')
    </section>
@endsection
<style> 
  .none { display:none; }, 
  .showDIV { display:block; } 
</style>
@section('page-script')
  <script type="text/javascript">
    $(document).ready(function(){   
      $(".monthPicker").datepicker({
          dateFormat: 'MM yy',
          changeMonth: true,
          changeYear: true,
          showButtonPanel: true,

          onClose: function(dateText, inst) {
              var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
              var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
              $(this).val($.datepicker.formatDate('MM yy', new Date(year, month, 1)));
          }
      });
      $(".monthPicker").focus(function () {
          $(".ui-datepicker-calendar").hide();
          $("#ui-datepicker-div").position({
              my: "center top",
              at: "center bottom",
              of: $(this)
          });
      });
    });
  </script>

<!-- tabel hasil pencarian -->
<script>
  $(document).ready(function(){
    $('#buttonIDe').on('click', function(event) {
      var isvalidate = $("#formIDe")[0].checkValidity();
      if (isvalidate) {
        event.preventDefault();
        var data = $('.form-horizontal').serialize();
        $('#modal-loader').show();
        $("#hasil").addClass("none");

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          type: 'POST',
          url: '{!! route('datareport') !!}',
          data: data,
          cache:false,
          success: function(data) {
            // var response = JSON.parse(data);
            console.log(data);
            // console.log(response.status['status']);
            var pesan = (data.pesan);
            if(pesan == 'success'){
              // window.location.reload(true);
              // alert(response.regulerid);
              // $('#modal-loader').hide();
              $("#hasil").removeClass("none");
              document.getElementById("bulantampil").innerHTML =data.bulan;
              
              // document.getElementById("header_ccc").innerHTML = response.status['ccc'];
              // document.getElementById("header_nama").innerHTML = response.status['nama'];
              // document.getElementById("header_alamat").innerHTML = response.status['alamat'];
              // document.getElementById("header_poin").innerHTML = response.status['poin'];
              // document.getElementById("header_balance").innerHTML = response.status['balance'];
              // tblredeem();
            }else{
              alert('Silahkan Coba lagi');
            }
          },
          error: function(data){
            // var errors = data.responseJSON;
            // var err_id_teamviewer=errors.errors.id_teamviewer;
            // document.getElementById('response').innerHTML = err_id_teamviewer;
          }
        });
      }
    });
  });
</script>


<script>
  $(function () {
    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieChart       = new Chart(pieChartCanvas)
    var PieData        = [
      {
        value    : 700,
        color    : '#f56954',
        highlight: '#f56954',
        label    : 'Chrome'
      },
      {
        value    : 500,
        color    : '#00a65a',
        highlight: '#00a65a',
        label    : 'IE'
      },
      {
        value    : 400,
        color    : '#f39c12',
        highlight: '#f39c12',
        label    : 'FireFox'
      },
      {
        value    : 600,
        color    : '#00c0ef',
        highlight: '#00c0ef',
        label    : 'Safari'
      },
      {
        value    : 300,
        color    : '#3c8dbc',
        highlight: '#3c8dbc',
        label    : 'Opera'
      },
      {
        value    : 100,
        color    : '#d2d6de',
        highlight: '#d2d6de',
        label    : 'Navigator'
      }
    ]
    var pieOptions     = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke    : true,
      //String - The colour of each segment stroke
      segmentStrokeColor   : '#fff',
      //Number - The width of each segment stroke
      segmentStrokeWidth   : 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 0, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps       : 100,
      //String - Animation easing effect
      animationEasing      : 'easeOutBounce',
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate        : true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale         : false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive           : true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio  : true,
      //String - A legend template
      legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions)



  })
</script>
@stop