@extends('layouts.app')

@section('content')
{{-- <div class="container">
    <h1>Expense Management</h1>
    <button class="btn btn-primary" data-toggle="modal" data-target="#addExpenseModal">Add Expense</button>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <input type="text" id="search" class="form-control mt-3 mb-3" placeholder="Search for expenses...">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Amount</th>
                <th>Comments</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="expenseTable">
            @foreach ($expenses as $expense)
            <tr>
                <td>{{ $expense->id }}</td>
                <td>{{ $expense->category }}</td>
                <td>{{ $expense->amount }}</td>
                <td>{{ $expense->comments }}</td>
                <td>
                    <a href="{{ route('expenses.show', $expense->id) }}" class="btn btn-info">View</a>
                    <button class="btn btn-warning edit-btn" data-id="{{ $expense->id }}" data-category="{{ $expense->category }}" data-amount="{{ $expense->amount }}" data-comments="{{ $expense->comments }}">Edit</button>
                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div> --}}

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Expense Management</h1>
        <div>
            <button class="btn btn-primary" data-toggle="modal" data-target="#addExpenseModal">Add Expense</button>
            <input type="text" id="search" class="form-control d-inline-block w-auto ml-2" placeholder="Search...">
        </div>
    </div>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Amount</th>
                <th>Comments</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="expenseTable">
            @foreach ($expenses as $expense)
            <tr>
                <td>{{ $expense->id }}</td>
                <td>{{ $expense->category }}</td>
                <td>{{ $expense->amount }}</td>
                <td>{{ $expense->comments }}</td>
                <td>
                    <a href="{{ route('expenses.show', $expense->id) }}" class="btn btn-info btn-sm">View</a>
                    <button class="btn btn-warning btn-sm edit-btn" data-id="{{ $expense->id }}" data-category="{{ $expense->category }}" data-amount="{{ $expense->amount }}" data-comments="{{ $expense->comments }}">Edit</button>
                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add Expense Modal -->
<div class="modal fade" id="addExpenseModal" tabindex="-1" role="dialog" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addExpenseModalLabel">Add Expense</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('expenses.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="category">Category:</label>
                        <input type="text" name="category" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount:</label>
                        <input type="number" name="amount" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="comments">Comments:</label>
                        <textarea name="comments" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Expense Modal -->
<div class="modal fade" id="editExpenseModal" tabindex="-1" role="dialog" aria-labelledby="editExpenseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editExpenseModalLabel">Edit Expense</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editExpenseForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="editCategory">Category:</label>
                        <input type="text" name="category" id="editCategory" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editAmount">Amount:</label>
                        <input type="number" name="amount" id="editAmount" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editComments">Comments:</label>
                        <textarea name="comments" id="editComments" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('search').addEventListener('keyup', function() {
    var searchText = this.value.toLowerCase();
    var rows = document.querySelectorAll('#expenseTable tr');
    
    rows.forEach(function(row) {
        var category = row.cells[1].innerText.toLowerCase();
        var amount = row.cells[2].innerText.toLowerCase();
        var comments = row.cells[3].innerText.toLowerCase();
        
        if (category.indexOf(searchText) !== -1 || amount.indexOf(searchText) !== -1 || comments.indexOf(searchText) !== -1) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function() {
        var id = this.getAttribute('data-id');
        var category = this.getAttribute('data-category');
        var amount = this.getAttribute('data-amount');
        var comments = this.getAttribute('data-comments');

        document.getElementById('editCategory').value = category;
        document.getElementById('editAmount').value = amount;
        document.getElementById('editComments').value = comments;

        var form = document.getElementById('editExpenseForm');
        form.action = '/expenses/' + id;

        $('#editExpenseModal').modal('show');
    });
});
</script>
@endsection
