@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Transactions</div>
                <div class="panel-body">
                    <form class="form" id="filter">
                        <div class="form-group">
                            <label for="customers">Customers</label>
                            <select class="form-control" id="customers" name="customerId">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount equals</label>
                            <input class="form-control" id="amount" name="amount" placeholder="0.00">
                        </div>
                        <div class="form-group">
                            <label for="date">Date and time equals</label>
                            <div class='input-group date' id='datetimepicker1'>
                                <input type='text' id="date" name="date" class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>

                    <table class="table" id="list">
                        <thead>
                            <th>#</th>
                            <th>Customer Id</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <form class="form-inline full-width">
                        <div class="form-group">
                            <nav aria-label="Page navigation" id="pagination">
                                <ul class="pagination"></ul>
                            </nav>
                        </div>
                        <div class="form-group per-page">
                            <label for="per_page">Per page</label>
                            <select id="per_page" class="form-control">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js-data')
    var public = '{{ $public }}';
    var token = '{{ $token }}';
@endsection