@extends('layouts.app')



@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="text-center title">Portal Statistics</h4>
      </div>
      <div class="card-body">
        <canvas id="myChart"></canvas>
      </div>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>


<script>
    var timeFormat = 'YYYY-MM-DD';

    var stats = '';

    var my_url = '{{ config('app.url') }}/admin/api/stats/total_users';
    var total_users = (function () {
        var json = null;
        $.ajax({
            'async': false,
            'global': false,
            'url': my_url,
            'dataType': "json",
            'success': function (data) {
                json = data;
            }
        });
        return json;
    })();

    const config = {
        type: 'line',
        data:    {
            datasets: [
                {
                    label: "Total Users",
                    data: total_users,
                    fill: false,
                    borderColor: 'red',
                }
            ]
        },
        options: {
            scales: {
                x: {
                    type: 'time',
                    time: {
                        // Luxon format string
                        tooltipFormat: 'dd T'
                    },
                    title: {
                        display: true,
                        text: 'Date'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'value'
                    },
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }

    };

</script>
<script>
    const myChart = new Chart(
      document.getElementById('myChart'),
      config
    );
  </script>

@endsection
