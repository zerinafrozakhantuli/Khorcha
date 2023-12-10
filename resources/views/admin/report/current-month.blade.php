@extends('layouts.admin')
@section('content')
@php

 $now=Carbon\Carbon::now()->toDateTimeString();
 $year=date('Y',strtotime($now));
 $month=date('m',strtotime($now));
 $date=date('d',strtotime($now));
 $monthName=date('F',strtotime($now));



$allIncome=App\Models\Income::where('income_status',1)->whereMonth('income_date','=',$month)->whereYear('income_date','=',$year)->get();

$allExpense=App\Models\Expense::where('expense_status',1)->whereMonth('expense_date','=',$month)->whereYear('expense_date','=',$year)->get();

$total_Income=App\Models\Income::where('income_status',1)->whereMonth('income_date','=',$month)->whereYear('income_date','=',$year)->sum('income_amount');

$total_Expense=App\Models\Expense::where('expense_status',1)->whereMonth('expense_date','=',$month)->whereYear('expense_date','=',$year)->sum('expense_amount');

$total_Savings=($total_Income - $total_Expense);
@endphp

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
              <div class="card-header">
                <div class="row">
                    <div class="col-md-8 card_title_part">
                        <i class="fab fa-gg-circle"></i>{{$monthName}} :: Income Expense Summary
                    </div>  
                    <div class="col-md-4 card_button_part">
 <a href="{{url('dashboard/income')}}" class="btn btn-sm btn-dark"><i class="fas fa-th"></i> Income</a>
 <a href="{{url('dashboard/expense')}}" class="btn btn-sm btn-dark"><i class="fas fa-th"></i> Expense </a>
                    </div>  
                </div>
              </div>
              <div class="card-body">
 
               <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">

      @if(Session::has('success'))
    <div class="alert alert-success alert_success" role="alert">
      <strong>Success!</strong>{{Session::get('success')}}
     </div>
     @endif
    @if(Session::has('error'))
    <div class="alert alert-danger alert_error" role="alert">
      <strong>Opps!</strong>{{Session::get('error')}}
     </div>
     @endif
      
    </div>
    <div class="col-md-2"></div>
  </div>
                <table id="inexsummary"class="table table-bordered table-striped table-hover custom_table">
                  <thead class="table-dark">
                    <tr>
                      <th>Date</th>
                      <th>Title</th>
                      <th>Category</th>
                      <th>Income</th>
                      <th>Expense</th>
                     
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($allIncome as $income)
                    <tr>
                      <td>{{date('d-m-Y',strtotime($income->income_date))}}</td>
                      <td>{{$income->income_title}}</td>
                      <td>{{$income->categoryInfo->incate_name}}</td>
                      <td>{{number_format($income->income_amount,2)}}</td>
                      <td></td>
                    </tr>
                    @endforeach
                     @foreach($allExpense as $expense)
                    <tr>
                      <td>{{date('d-m-Y',strtotime($expense->expense_date))}}</td>
                      <td>{{$expense->expense_title}}</td>
                      <td>{{$expense->categoryInfo->expcate_name}}</td>
                      <td></td>
                      <td>{{number_format($expense->expense_amount,2)}}</td>
                      
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="3" class="text-end ">Total:</th>
                      <th>{{number_format($total_Income,2)}}</th>
                      <th>{{number_format($total_Expense,2)}}</th>
                    </tr>
                    <tr>
                      @if($total_Income > $total_Expense )
                      <th colspan="3" class="text-end text-success">Savings:</th>
                      @else($total_Income < $total_Expense)
                      <th colspan="3" class="text-end text-danger">Over Expense:</th>
                      @endif
                      <th colspan="2">{{number_format($total_Savings,2)}}</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <div class="card-footer">
                <div class="btn-group" role="group" aria-label="Button group">
                  <button type="button" onclick="window.print()" class="btn btn-sm btn-dark">Print</button>
                  <a href="{{url('dashboard/income/pdf')}}" class="btn btn-sm btn-secondary">PDF</a>
                  <a href="{{url('dashboard/income/excel')}}" class="btn btn-sm btn-dark">Excel</a>
                </div>
              </div>  
            </div>
        </div>
    </div>

    <!-- --modal delete--  -->

  <div class="modal fade" id="softDeleteModal" tabindex="-1" aria-labelledby="softDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{url('dashboard/income/softdelete')}}">
      @csrf
      
    <div class="modal-content modal_content">
      <div class="modal-header modal_header">
      <h1 class="modal-title modal_title" id="softDeleteModalLabel"><i class="fab fa-gg-circle"></i> Confirm Message</h1>
      </div>
      <div class="modal-body modal_body">
        Do U Really Want To Delete Data?
        <input type="hidden" name="modal_id" id="modal_id" />
      </div>
      <div class="modal-footer modal_footer">
        <button type="submit" class="btn btn-sm btn-success" >Confirm</button>
        <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">close</button>
      </div>
    </div>
     </form>
  </div>
</div>

 @endsection



