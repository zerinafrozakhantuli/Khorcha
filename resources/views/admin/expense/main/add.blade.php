@extends('layouts.admin')
@section('content')
<div class="row">
<div class="col-md-12 ">
<form method="POST" action="{{url('dashboard/expense/submit')}}">
@csrf
<div class="card mb-3">
<div class="card-header">

<div class="row">
    <div class="col-md-8 card_title_part">
        <i class="fab fa-gg-circle"></i>Add Expense Information
    </div>  
    <div class="col-md-4 card_button_part">
        <a href="{{url('dashboard/expense')}}" class="btn btn-sm btn-dark"><i class="fas fa-th"></i>All Expense </a>
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

  <div class="row mb-3 {{ $errors->has('title') ? 'has-error' : ''}}">
    <label class="col-sm-3 col-form-label col_form_label">Expense Title <span class="req_star">*</span>:</label>
    <div class="col-sm-7">
      <input type="text" class="form-control form_control" id="" name="title" value="{{old('title')}}">
@if($errors->has('title'))
      <span class="invalid-feedback" role="alert">
         <strong>{{ $errors->first('title')}}</strong>
      </span>
@endif
    </div>
  </div>


 <div class="row mb-3 {{ $errors->has('category') ? 'has-error' : ''}}">
    <label class="col-sm-3 col-form-label col_form_label">Expense Category <span class="req_star">*</span>:</label>
    <div class="col-sm-7">
      @php
      $all=App\Models\ExpenseCategory::where('expcate_status',1)->orderBy('expcate_name','ASC')->get();
      @endphp
      <select class="form-control form_control" id="" name="category"> 
   <option value="">Choose Category </option>
   @foreach($all as $cate)
   <option value="{{$cate->expcate_id}}">{{$cate->expcate_name}} </option>
   @endforeach
      </select>
      @if($errors->has('category'))
      <span class="invalid-feedback" role="alert">
         <strong>{{ $errors->first('category')}}</strong>
      </span>
@endif
    </div>
  </div>


   <div class="row mb-3 {{ $errors->has('amount') ? 'has-error' : ''}}">
    <label class="col-sm-3 col-form-label col_form_label">Expense Amount  <span class="req_star">*</span>:</label>
    <div class="col-sm-7">
      <input type="number" class="form-control form_control" id="" name="amount" value="{{old('amount')}}">
@if($errors->has('amount'))
      <span class="invalid-feedback" role="alert">
         <strong>{{ $errors->first('amount')}}</strong>
      </span>
@endif
    </div>
  </div>

 <div class="row mb-3 {{ $errors->has('date') ? 'has-error' : ''}}">
    <label class="col-sm-3 col-form-label col_form_label"> Expense Date <span class="req_star">*</span>:</label>
    <div class="col-sm-7">
      <input type="text" class="form-control form_control" id="date" name="date" value="{{old('date')}}">
@if($errors->has('date'))
      <span class="invalid-feedback" role="alert">
         <strong>{{ $errors->first('date')}}</strong>
      </span>
@endif
    </div>
  </div>

</div>
<div class="card-footer text-center">
<button type="submit" class="btn btn-sm btn-dark">SUBMIT</button>
</div>  
</div>
</form>
</div>
</div>
@endsection
             