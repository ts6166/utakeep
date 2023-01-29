<div class="footer">
  <div class="footer-wrapper">
    <div class="external"></div>
    <div class="copyright"><p>&nbsp;</p>
      <p>Copyright &copy; 2018 - 2019 S.Taniguchi</p>
    </div>
  </div>
</div>
@if (app()->isLocal() || app()->runningUnitTests())
  <script src="{{ mix('js/app.js') }}"></script>
@else 
  <script src="{{ config('app.url') }}/js/app.js"></script>
@endif
<script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="{{ asset('js/script.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/page_top.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/player.js') }}"></script>
@php
  $scripts = [
    ['avatar_button'],
    ['facebook_share', 'https://connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v5.0'],
    ['twitter_widgets', 'https://platform.twitter.com/widgets.js'],
    ['twitter_share', 'https://platform.twitter.com/widgets.js']
  ]
@endphp
@foreach ($scripts as $script)
  @if($__env->yieldContent("js_$script[0]"))
    @if(count($script) == 1)
      <script type="text/javascript" src="{{ asset('js/'.$script[0].'.js') }}"></script>
    @else
      <script async type="text/javascript" src="{{ $script[1] }}"></script>
    @endif
  @endif
@endforeach