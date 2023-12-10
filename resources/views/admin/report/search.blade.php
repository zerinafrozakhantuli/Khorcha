@extends('layouts.admin')
@section('content')
@php
$starting=$_GET['starting'];
$ending=$_GET['ending'];
$allIncome=App\Models\Income::where('income_status',1)->whereBetween('income_date',[$starting,$ending])->get();
$allExpense=App\Models\Expense::where('expense_status',1)->whereBetween('expense_date',[$starting,$ending])->get();
$total_Income=App\Models\Income::where('income_status',1)->whereBetween('income_date',[$starting,$ending])->sum('income_amount');
$total_Expense=App\Models\Expense::where('expense_status',1)->whereBetween('expense_date',[$starting,$ending])->sum('expense_amount');
$total_Savings=($total_Income - $total_Expense);
@endphp

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
              <div class="card-header">
                <div class="row">
                    <div class="col-md-8 card_title_part">
                        <i class="fab fa-gg-circle"></i>Income Expense Summary
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

        <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8 mb-3">
            <form method="get" action="{{url('dashboard/report/search')}}">
              <div class="row">
                <div class="col-md-5">
           <input type="text" class="form-control" id="startDate" name="starting"  placeholder="Form" >
                </div>
                <div class="col-md-5 pad_left_0">
                <input type="text" class="form-control" id="endDate" name="ending"  placeholder="To" >
                </div>
                <div class="col-md-2 pad_left_0">
              <input type="submit" class="btn btn-primary btn-sm search_btn mt-1" id="" value="SEARCH" >
                </div>
              </div>
            </form>
          </div>
          <div class="col-md-2"></div>
        </div>
            <div class="row">
              <div class="col-md-12">
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
                      @if($total_Income > $total_Expense)
                      <th colspan="3" class="text-end text-success">Savings:</th>
                      @else($total_Expense > $total_Income)
                      <th colspan="3" class="text-end text-danger">Over Expense:</th>
                      @endif
                      <th colspan="2">{{number_format($total_Savings,2)}}</th>
                    </tr>
                  </tfoot>
                </table>
              </div>

            </div>

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



