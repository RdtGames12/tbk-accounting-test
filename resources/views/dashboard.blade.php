@extends('layouts.app')

@section('content')

<h3 class="mb-4">Dashboard</h3>

<div class="row">

    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body">
                <h6>Total Category</h6>
                <h3>{{ $totalCategory }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body">
                <h6>Total Chart Of Account</h6>
                <h3>{{ $totalCoa }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body">
                <h6>Total Transaction</h6>
                <h3>{{ $totalTransaction }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body">
                <h6>Net Profit</h6>
                <h3>
                    Rp {{ number_format($netProfit,0,',','.') }}
                </h3>
            </div>
        </div>
    </div>

</div>

<div class="card mt-3">
    <div class="card-body">

        <h5>Income vs Expense</h5>

        <div id="profitChart"></div>

    </div>
</div>

@endsection

@section('scripts')

<script>
    var options = {
        series: [{
            name: 'Amount',
            data: [
                {{ $totalIncome }},
                {{ $totalExpense }}
            ]
        }],
        chart: {
            type: 'bar',
            height: 350
        },
        xaxis: {
            categories: [
                'Income',
                'Expense'
            ]
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return 'Rp ' + val.toLocaleString('id-ID');
                }
            }
        }
    };
    var chart = new ApexCharts(
        document.querySelector("#profitChart"),
        options
    );
    chart.render();
</script>

@endsection