@extends('layouts.app')
@section('page_type', 'outer')

@section('content')
<div class="banner">
  <img id="icon" class="animated rotateIn" src="{{ asset('images/icons/icon-48x.png') }}" alt="icon">
  <h1 class="title">Uta<span style="opacity: 0.6;">keep</span></h1>
  <p class="text">Utakeep は自分の持ち歌（歌える曲）や気になった曲を記録してユーザー同士で共有ができるWebサービスです。<br>カラオケ等へ行くとき用にメモ感覚で簡単に使えます。</p>
  <resource-counter-component></resource-counter-component>
  <div class="prompt">
    <button class="button button-danger auto" onclick="location.href='{{ route('register') }}'">今すぐ曲の管理を始める</button>
  </div>
</div>
<div class="introducts margin">
  @component('components.introduct', ['delay_time' => '0.2', 'thumbnail' => 'training.jpg'])
    @slot('title')
      シンプルな持ち歌の管理システム
    @endslot
    @slot('text')
      iTunes<strike>もしくはDAM CHANNEL</strike>で配信されている曲の中からお好みで「気になる」、「習得中」、「習得済み」の3つの状態に振り分けて状態を管理できます。<br>
    振り分けた曲は状態ごとに一覧で閲覧でき、いつでも任意の状態に変更可能です。<br>
    また、キーワードにマッチした曲のみを抽出して表示することもできます。
    @endslot
    @slot('subtext')
      ※現時点ではiTunesで配信されている曲のみを検索できます。
    @endslot
  @endcomponent
  @component('components.introduct', ['delay_time' => '1.2', 'thumbnail' => 'timeline.jpg'])
    @slot('title')
      みんなの記録が見れるタイムライン機能
    @endslot
    @slot('text')
      自分、もしくは他のユーザーの更新記録をリスト形式で確認することができます。<br>
      このページからサンプル音源の視聴や状態の記録を行うことが出来ます。
    @endslot
  @endcomponent
  @component('components.introduct', ['delay_time' => '2.2', 'thumbnail' => 'analysis.jpg'])
    @slot('title')
      登録曲の傾向や利用頻度を自動で分析
    @endslot
    @slot('text')
      登録されたデータを元に、登録数が多いアーティストをドーナツグラフで、月毎の利用頻度を折れ線グラフで可視化できます。
    @endslot
  @endcomponent
</div>
<div class="height-small"></div>
@endsection