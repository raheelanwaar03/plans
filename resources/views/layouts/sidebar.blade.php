<div class="sidebar" id="sidebar">
    <header>
        <span class="text-white">Pigeon Mining</span>
        <!-- Close Icon -->
        <i class="fa-solid fa-arrow-left close-icon text-white" id="close-icon"></i>
    </header>
    <section>
        <h3>My Financial</h3>
        <ul>

            <li><a href="{{ route('User.Transfer') }}"><i class="fa-solid fa-dollar-sign"></i>Transfer Tokens</a><i
                    class="fa-solid fa-chevron-right"></i></li>
            <li><a href="{{ route('User.Premium') }}"><i class="fa-solid fa-money-bill"></i>
                    Premium</a><i class="fa-solid fa-chevron-right"></i></li>
            <li><a href="{{ route('User.Tasks') }}"><i class="fa-solid fa-list"></i>
                    Earn Tokens</a><i class="fa-solid fa-chevron-right"></i></li>
        </ul>
    </section>
    <section>
        <h3>My Detail</h3>
        <ul>
            <li><a href="{{ route('profile.edit') }}"><i class="fa-solid fa-user"></i> Personal Info</a><i
                    class="fa-solid fa-chevron-right"></i></li>
        </ul>
    </section>
    <section>
        <h3>Platform Detail</h3>
        <ul>
            <li><a href="{{ route('User.Contact') }}"><i class="fa-solid fa-headset"></i> Customer
                    Service</a><i class="fa-solid fa-chevron-right"></i></li>
        </ul>
    </section>
    <div class="logout">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>
</div>
