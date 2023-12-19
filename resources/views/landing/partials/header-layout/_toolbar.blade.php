@guest
    <div class="flex-equal text-end ms-1">
        <a href="{{route('discord.register')}}" class="btn btn-maroon"><i class="fa-brands fa-discord" style="color: #5780c7;"></i>Login/Register</a>
    </div>
@endguest

@auth()
    <div class="flex-equal text-end ms-1">
        <a href="{{route('dashboard.index')}}" class="btn btn-maroon">Dashboard</a>
    </div>
@endauth

