<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    {{-- ChartStyle --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
</head>
<body>
    <div id="app">

        <main class="py-4">
        <div class="container">
            <h1>Income Graph</h1>
            <div class="row">
                <div class="col-6">
                    <div class="card rounded">
                        <div class="card-body py-3 px-3">
                            {!! $incomeChart->container() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </main>
    </div>

    {{-- Chartscript --}}
    @if($incomeChart)
    {!! $incomeChart->script() !!}
    @endif
</body>
</html>