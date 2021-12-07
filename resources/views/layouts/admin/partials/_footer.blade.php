<footer class="app-footer">
    @if(companyName())
    <span><a href="{{ url('/') }}">{{ companyName() }}</span>
        @else
        <span><a href="{{ url('/') }}">Iconiccodedevelopment</span>
    @endif
</footer>
