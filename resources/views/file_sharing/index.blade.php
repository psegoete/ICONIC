@extends('admin.layouts.default')

@section('admin.breadcrumb')
<li class='breadcrumb-item active'>File sharing credits ( {{ $file_sharing->credits }} file sharing credits)</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <form action="{{ route('file-sharing.store') }}" method="POST">
            {!! csrf_field() !!}
            <div class="clearfix">
                <div class="col-lg">
                    <div class="card">
                        <div class="card-header">
                            File sharing credits
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <table class="table table-responsive-sm table-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th></th>
                                            <th>Credits</th>
                                            <th>For</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="credits" value="1" checked>
                                                </div>
                                            </td>
                                            <td>1</td>
                                            <td>R 15</td>

                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="credits" value="10">
                                                </div>
                                            </td>
                                            <td>10</td>
                                            <td>R 150</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="credits" value="50">
                                                </div>
                                            </td>
                                            <td>50</td>
                                            <td>R 750</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="credits" value="100">
                                                </div>
                                            </td>
                                            <td>100</td>
                                            <td>R 1500</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="credits" value="200">
                                                </div>
                                            </td>
                                            <td>200</td>
                                            <td>R 3000</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Buy</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection