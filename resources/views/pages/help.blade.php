@extends('layouts.app')
@section('title', 'ヘルプ')

@section('sidebar')
@include('widgets.user-infomation', ['user' => Auth::user(), 'hidden' => true])
@endsection

@section('content')
@component('components.question', ['title' => 'Utakeepについて'])
@slot('contents')
  Utakeepは持ち歌を記録して人と共有したりできるWebサービスです。<br>
  プログラミングの学習の一環として個人で開発・運営しています。<br>
  まだ不具合は多々あるかと思いますが最低限動くようになってきたので公開しています。<br>
  不定期で更新します。
@endslot
@endcomponent

@component('components.question', ['title' => 'ステータスの使い分け方がわからない'])
@slot('contents')
  ステータスには「気になる」、「習得中」、「習得済み」の3つの状態があります。<br>
  「気になる」は気になっている曲、練習しようか迷ってる曲の状態を表します。<br>
  「習得中」は歌詞を覚えている途中、完璧ではないが雰囲気で歌えるという状態を表します。<br>
  「習得済み」は歌詞を覚えていて歌うことができる状態を表します。<br>
  これらは完全な定義では無いので参考程度にして、細かい部分は自分の中でルールを決めて利用することを推奨しています。
@endslot
@endcomponent

@component('components.question', ['title' => '登録したい曲が見つからない'])
@slot('contents')
  <a class="default-link" href="https://www.apple.com/jp/itunes/" target="_blank">iTunes Music</a><strike>または、<a class="default-link" href="https://www.clubdam.com/" target="_blank">DAM CHANNEL</a></strike>で配信されている曲を検索することができます。<br>
  本サービスは外部のサービスに依存しているため将来的に使用不可になる可能性があります。
@endslot
@endcomponent

@component('components.question', ['title' => 'みんなが登録した中からの検索結果とは'])
@slot('contents')
  APIにより取得されるデータにはアーティスト・タイトルが同一の曲が複数存在していることがあります。<br>
  できるだけ他ユーザーと別の項目を登録しないよう以前誰かが登録したことのある曲のみにフィルターをかけたものを「みんなが登録した中から」という表現にしています。
@endslot
@endcomponent

@component('components.question', ['title' => '退会したい'])
@slot('contents')
  <a class="default-link" href="{{ route('settings.account') }}">アカウントの設定ページ</a>の「アカウントの削除」欄から削除申請を行うことができます。<br>
  削除申請から7日後、完全にデータが消去されるため元に戻すことはできません。
@endslot
@endcomponent
@endsection
