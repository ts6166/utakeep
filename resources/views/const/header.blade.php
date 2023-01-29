<div class="header">
  <nav class="navbar">
    <div class="navbar-container">
      <div class="navbar-left">
        <ul class="navbar-nav">
          <li class="nav-brand{{ Auth::check() ? ' hidden-sm-below' : '' }}">
            <img src="{{ asset('images/icons/icon-64x.png') }}" alt="logo" onclick="location='{{ route('home') }}'">
            <a href="{{ route('home') }}"><span class="hidden-md-below">&nbsp;Utakeep&nbsp;</span></a>
          </li>
          @auth
          <li class="nav-item{{ Request::is('/') ? ' active' : '' }}">
            <a href="{{ route('home') }}"><i class="fas fa-home"></i><span class="nav-indention">&nbsp;ホーム</span></a>
          </li>
          <li class="nav-item{{ Request::is('notifications') ? ' active' : '' }}">
            <a href="{{ route('notifications') }}"><span class="unconfirm{{ !empty($exist_unconfirm_notification) ? ' exist-unconfirm' : '' }}"><i class="fas fa-bell"></i></span><span class="nav-indention">&nbsp;通知</span></a>
          </li>
          <li class="nav-item{{ Request::is('search/song') ? ' active' : '' }}">
            <a href="{{ route('search.song') }}"><i class="fas fa-search"></i><span class="nav-indention">&nbsp;曲を探す</span></a>
          </li>
          @endauth
        </ul>
      </div>
      <div class="navbar-right">
        <ul class="navbar-nav">
          @guest
          <li class="nav-item{{ Request::is('register') ? ' active' : '' }}">
            <a href="{{ route('register') }}"><i class="fas fa-user"></i><span
                class="nav-indention">&nbsp;新規登録</span></a>
          </li>
          <li class="nav-item{{ Request::is('login') ? ' active' : '' }}">
            <a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i><span
                class="nav-indention">&nbsp;ログイン</span></a>
          </li>
          @else
          <li class="nav-input hidden-md2-below">
            <form method="GET" action="{{ route('search.song') }}">
              <input type="text" class="text" name="q" placeholder="検索" maxlength="20" autocomplete="off" required>
            </form>
          </li>
          <li class="nav-button">
            <button id="avatar-button"><img src="{{ asset('images/profile_image/' . Auth::user()->profile_image . '_small.png') }}" alt="avatar"></button>
          </li>
          @endguest
        </ul>
        @auth
        @section('js_avatar_button', true)
        <div id="nav-dialog" class="nav-dialog dialog">
          <div class="dialog-panel">
            <ul class="dialog-group">
              <li class="dialog-item success-dialog-item">
                <a href="{{ route('user', ['id' => Auth::user()->screen_name]) }}"><i class="fa fa-user"></i><span class="indent">マイページ</span></a>
              </li>
              <li class="dialog-item success-dialog-item">
                <a href="{{ route('search.user') }}"><i class="fa fa-users"></i><span class="indent">ユーザーを探す</span></a>
              </li>
            </ul>
            <ul class="dialog-group">
              <li class="dialog-item inverse-dialog-item">
                <a href="{{ route('help') }}"><i class="fas fa-question-circle"></i><span class="indent">ヘルプ</span></a>
              </li>
              <li class="dialog-item inverse-dialog-item">
                <a href="{{ route('tools.export') }}"><i class="fas fa-tools"></i><span class="indent">ツール</span></a>
              </li>
              <li class="dialog-item inverse-dialog-item">
                <a href="{{ route('settings.profile') }}"><i class="fas fa-cog"></i><span class="indent">設定</span></a>
              </li>
            </ul>
            <ul class="dialog-group">
              <li class="dialog-item danger-dialog-item">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="fas fa-power-off"></i><span class="indent">ログアウト</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
              </li>
            </ul>
          </div>
        </div>
        @endauth
      </div>
    </div>
  </nav>
</div>