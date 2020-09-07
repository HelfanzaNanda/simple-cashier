<nav class="navbar navbar-secondary navbar-expand-lg">
    <div class="container">
      <ul class="navbar-nav">
        <li class="nav-item {{ Request::is('food') ? 'active' : '' }}">
          <a href="{{ route('food.index') }}" class="nav-link"><i class="far fa-food"></i><span>Food</span></a>
        </li>

        <li class="nav-item {{ Request::is('transaction') ? 'active' : '' }}">
            <a href="{{ route('transaction.index') }}" class="nav-link"><i class="far fa-transaction"></i><span>Transaksi</span></a>
          </li>
      </ul>
    </div>
  </nav>