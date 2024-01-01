@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-12 welcome_part">
        <p><span>Welcome Mr./Mrs</span> {{Auth::user()->name}}</p>
    </div>
</div>

 <div class="row mt-5">
        <div class="col-md-6">
            <div class="card mb-3">
              <div class="card-header">
                <div class="row">
                    <div class="col-md-12 card_title_part">
                        <i class="fab fa-gg-circle"></i>All Expense Category Information
                    </div>  
                      
                </div>
              </div>
              <div class="card-body">

               <canvas id="myChart"></canvas>
              </div>
              <div class="card-footer">
                
              </div>  
            </div>
        </div>
    </div>
    @php
    $allCate=App\Models\IncomeCategory::where('incate_status',1)->orderBy('incate_id','ASC')->get();
    @endphp
    <script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: 
      [
      @php
      foreach( $allCate as $cate){
      echo "'".$cate->incate_name ."',";
     }
      @endphp
      ],
      datasets: [{
        label: '# of Votes',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

    

@endsection


