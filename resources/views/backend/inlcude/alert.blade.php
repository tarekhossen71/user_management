@if (session()->get('success'))
    <div id="hide" class="alert alert-success " >
        <strong>Success: </strong> {{ session()->get('success') }}
    </div>
    @elseif (session()->get('warning'))
        <div id="hide" class="alert alert-warning " >
            <strong>Warning: </strong> {{ session()->get('warning') }}
        </div>
    @elseif (session()->get('error'))
        <div id="hide" class="alert alert-danger " >
            <strong>Error: </strong> {{ session()->get('error') }}
        </div>
@endif