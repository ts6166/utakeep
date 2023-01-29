@php
if ($errors->any()) {
  foreach ($errors->all() as $error) {
    $alert = ['type' => 'danger', 'text' => $error];
    break;
  }
} elseif (session('status')) {
  $alert = ['type' => 'success', 'text' => session('status')];
} elseif (session('error')) {
  $alert = ['type' => 'danger', 'text' => session('error')];
}
@endphp
<div class="main main-inner">
  <div class="margin">
    @isset($alert)
      @include('components.alert', ['type' => $alert['type'], 'text' => $alert['text']])
    @endisset
    <div class="layout">
      <div class="sidebar">
        @yield('sidebar')
      </div>
      <div class="content">
        @yield('content')
      </div>
    </div>
  </div>
</div>