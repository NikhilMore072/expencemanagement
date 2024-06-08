@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Expense Details</h1>
    <div class="form-group">
        <label>Category:</label>
        <p>{{ $expense->category }}</p>
    </div>
    <div class="form-group">
        <label>Amount:</label>
        <p>{{ $expense->amount }}</p>
    </div>
    <div class="form-group">
        <label>Comments:</label>
        <p>{{ $expense->comments }}</p>
    </div>
    <a href="{{ route('expenses.index') }}" class="btn btn-primary">Back to List</a>
</div>
@endsection
