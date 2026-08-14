<ul class="nav">


    <li class="nav-item dropdown">
        <select id="theme-switcher" onchange="switchTheme(this.value)" aria-label="Changer de thème">
            <option value="indigo">Light Mode</option>
            <option value="dark">Dark Mode</option>
        </select>
    </li>
    <li>
        <a class="nav-link" href="{{ url('/') }}">{{ __('IpsumAdmin::layout.Aller sur le site') }}</a>
    </li>

    @guest
        <li>
            <a class="nav-link" href="{{ route('admin.login') }}">{{ __('IpsumAdmin::layout.Connexion') }}</a>
        </li>
    @else
        <li>
            <div class="nav-link"><a href="{{ route('admin.logout') }}">{{ __('IpsumAdmin::layout.Déconnexion') }}</a> (<a href="{{ route('adminUser.edit', auth()->user()->id) }}">{{ auth()->user()->name }}</a>)</div>
        </li>
    @endguest
</ul>