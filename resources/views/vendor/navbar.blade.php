<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
        <a class="navbar-brand" href="/">Market</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                </li>
            </ul>
    
            <ul class="navbar-nav ml-auto">
                @if(auth()->check())
                    <span class="navbar-text mr-5">
                        Wallet: {{ auth()->user()->wallet }} Tk 
                    </span>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ auth()->user()->profilePath() }}">Shop Profile</a>
                    </li>    
                @else
                <li class="nav-item">
                    <a class="nav-link" href="/register">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/login">Login</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="/cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
                </li>
            </ul>
    
    
        </div>
    </nav>