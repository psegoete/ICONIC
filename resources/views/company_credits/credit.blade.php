@extends('admin.layouts.default')

@section('admin.breadcrumb')
<li class='breadcrumb-item active'>Buy Sharing credits</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <form action="{{ route('companyCredits') }}" method="POST">
            {!! csrf_field() !!}
            <div class="clearfix">
                <div class="col-lg">
                    <div class="card">
                        <div class="card-header">
                            Buy sharing credits
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <table class="table table-responsive-sm table-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th></th>
                                            <th>Description</th>
                                            <th>From</th>
                                            <th>For</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($company_credits as $key => $company_credit)
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    @if ($key == 0)
                                                        <input class="form-check-input" type="radio" name="id" value="{{ $company_credit->id }}" checked>
                                                    @else
                                                        <input class="form-check-input" type="radio" name="id" value="{{ $company_credit->id }}">
                                                    @endif
                                                    <input type="hidden" name="for" value="{{ $company_credit->for }}">

                                                    {{--  <input type="hidden" name="credits" value="{{ $company_credit->description }}">  --}}
                                                </div>
                                            </td>
                                            <td>{{ $company_credit->description }} credits</td>
                                            <td>R {{ $company_credit->from }}</td>
                                            <td>R {{ $company_credit->for }}</td>
                                            <td>
                                                @if (($company_credit->from - $company_credit->for) > 0)
                                                    Save R {{ ($company_credit->from - $company_credit->for) }}
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
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