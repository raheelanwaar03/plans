<footer class="text-white py-2 mt-5">
    <nav class="d-flex justify-content-around align-items-center">
        <a href="{{ route('User.Dashboard') }}" style="color: white;text-decoration: none;"><i class="bi bi-house"
                style="font-size: 20px;"></i><br><span style="font-size:13px;margin-left: -7px;">Home</span></a>
        <a href="{{ route('User.Booster') }}" style="color: white;text-decoration: none;">
            <i class="bi bi-rocket" style="font-size: 20px;"></i>
            <br><span style="font-size:13px;margin-left: -7px;">Booster</span></a>
        <a href="{{ route('User.Trade.Token') }}" style="color: white;text-decoration: none;">
            <i class="bi bi-currency-dollar" style="font-size: 20px"></i>
            <br><span style="font-size:13px;margin-left: -7px;">Trade</span></a>
        <a href="{{ route('User.KYC') }}" style="color: white;text-decoration: none;">
            <i class="bi bi-patch-question" style="font-size: 20px;"></i><br><span
                style="font-size:13px;margin-left: -3px;">KYC</span></a>
    </nav>
</footer>
