@extends('admin.layouts.default')

@section('admin.breadcrumb')
<li class='breadcrumb-item active'>Buy tuning credits</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <form action="{{ route('pay-credits') }}" method="POST">
            {!! csrf_field() !!}
            <div class="clearfix">
                <div class="col-lg">
                    <div class="card">
                        <div class="card-header">
                            Buy credits
                        </div>
                        <div class="card-body">
                            <div class="for-group">
                                <div>@include('layouts.partials.alerts._alerts')</div>
                            </div>
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

                                        @foreach($credits_amounts as $key => $credits_amount)

                                        @if (\CreatyDev\Domain\Credittier::where([['credit_group_id', '=', auth()->user()->credit_group_id],['credittier_amounts_id','=',$credits_amount->id]])->first()->for > 0)
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    @if ($key == 0)
                                                        <input class="form-check-input" type="radio" name="id" value="{{ \CreatyDev\Domain\Credittier::where([['credit_group_id', '=', auth()->user()->credit_group_id],['credittier_amounts_id','=',$credits_amount->id]])->first()->id }}" checked>
                                                    @else
                                                        <input class="form-check-input" type="radio" name="id" value="{{ \CreatyDev\Domain\Credittier::where([['credit_group_id', '=', auth()->user()->credit_group_id],['credittier_amounts_id','=',$credits_amount->id]])->first()->id }}">
                                                    @endif
                                                    <input type="hidden" name="for" value="{{ \CreatyDev\Domain\Credittier::where([['credit_group_id', '=', auth()->user()->credit_group_id],['credittier_amounts_id','=',$credits_amount->id]])->first()->for }}">
                                                </div>
                                            </td>
                                            <td>
                                                @if($credits_amount->amount > 1)
                                                {{$credits_amount->amount}} credits
                                                @else
                                                {{$credits_amount->amount}} credit
                                                @endif
                                            </td>
                                            <td>
                                                {{\CreatyDev\Domain\Credittier::where([['credit_group_id', '=', auth()->user()->credit_group_id],['credittier_amounts_id','=',$credits_amount->id]])->first()->from}}
                                            </td>
                                            <td>
                                                {{\CreatyDev\Domain\Credittier::where([['credit_group_id', '=', auth()->user()->credit_group_id],['credittier_amounts_id','=',$credits_amount->id]])->first()->for}}
                                            </td>
                                            <td>
                                                @if ((\CreatyDev\Domain\Credittier::where([['credit_group_id', '=', auth()->user()->credit_group_id],['credittier_amounts_id','=',$credits_amount->id]])->first()->from- \CreatyDev\Domain\Credittier::where([['credit_group_id', '=', auth()->user()->credit_group_id],['credittier_amounts_id','=',$credits_amount->id]])->first()->for) > 0)
                                                   <div style=" background-color: green">
                                                       Save R {{ (\CreatyDev\Domain\Credittier::where([['credit_group_id', '=', auth()->user()->credit_group_id],['credittier_amounts_id','=',$credits_amount->id]])->first()->from - \CreatyDev\Domain\Credittier::where([['credit_group_id', '=', auth()->user()->credit_group_id],['credittier_amounts_id','=',$credits_amount->id]])->first()->for) }}
                                                   </div>
                                                @endif
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if($credits_amounts->count())
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Buy</button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection