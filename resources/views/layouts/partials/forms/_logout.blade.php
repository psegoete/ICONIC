@if(Auth::user()->role == 'super-admin')
<form id="logout-form" action="{{ url('admin-logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@else
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@endif