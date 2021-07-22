# numazu-no-takara-100sen-master

当プログラムは、静岡県沼津市が主催している企画「[ぬまづの宝100選](https://www.city.numazu.shizuoka.jp/photolibrary/100sen/index.htm)」の写真を登録し、写真の取得、点数の取得、認定ランクの取得、認定証の取得を行う事ができるWordPress用のプラグインです。

※当プラグインは私個人が作成したWordPressプラグインです。沼津市とは一切の関係がございません。

## プラグインのダウンロード

当GitHubのページからクローン、またはZIPファイルをダウンロードしてください。

## プラグインの有効化

当プラグインのダウンロード後、以下の手順でアップロードを行ってください。

1. WordPressのプラグインを追加
2. プラグインのアップロード
3. ZIPファイルを選択してアップロード

FTPでプラグインディレクトリにアップロードする方法でも可能です。

## 使い方

### 管理画面

1. プラグインの有効化後、ぬまづの宝100選メニューから撮影したスポットの写真を登録。
2. 認定証を登録したい場合は設定画面から登録

### フロント

1. 登録した写真を表示したい、投稿や固定ページにショートコードを挿入

### ショートコード

以下のショートコードを登録済みです。投稿、固定ページ、テーマなどでしようする事が可能です。

``
[numazu_no_takara_point]  
``

登録済みの写真のポイント数の合計を出力します。  
（出力例：100）

``
[numazu_no_takara_rank]
``

登録済みの写真のポイントから該当する認定ランクを出力します。
（出力例：マスター）

* 201点以上 = マスター
* 151点以上 = 名人
* 100点以上 = 先生
* 100点未満 = -

``
[numazu_no_takara_photos]
``

登録済みの写真の一覧を出力します。

また、[numazu_no_takara_photos]は、オプションを設定する事が可能です。

* column
* sp_column
* tab_column
* pc_column

``
[numazu_no_takara_photos column=2]
``

column、sp_column、tab_column、pc_columnは、1〜5の数字を指定する事ができます。上記の例では2カラムで表示します。

スマートフォン、タブレット、パソコンなどのデバイスに応じたの表示方法も切り替え（ブレイクポイント）も可能です。sp_column（〜640px）、tab_column（641px〜1023px）、pc_column（1024px〜）となります。お使いの環境に合わせて、cssにてブレイクポイントは変更してください。

``
[numazu_no_takara_photos sp_column=2 tab_column=2 pc_column=3]
``

上記の例では、
・スマートフォンは2カラム
・タブレットは2カラム
・パソコンは3カラム
で表示します。

``
[numazu_no_takara_certified_imgs]
``

登録済みの認定証の一覧を出力します。

また、[numazu_no_takara_certified_imgs]は、オプションを設定する事が可能です。

* column
* sp_column
* tab_column
* pc_column
* rank

``
[numazu_no_takara_photos rank=1]
``

column、sp_column、tab_column、pc_columnは、[numazu_no_takara_photos]と同様の動作をします。

rankは、1〜3の数字を指定する事ができます。rankを指定すると一枚ずつ写真を取得する事ができます。

* 1 = マスター
* 2 = 名人
* 3 = 先生

上記の例ではマスターので表示します。

## 参考

ぬまづの宝100選について、詳しくは沼津市のホームページをご覧ください。
[https://www.city.numazu.shizuoka.jp/photolibrary/100sen/index.htm](https://www.city.numazu.shizuoka.jp/photolibrary/100sen/index.htm)


## バージョン履歴

### v0.1.2

* 不要なスクリプトの削除
* 必要なページでのみスクリプトの読み込み

### v0.1.1

* wp_enqueue_media() 追加
* 画像の書き出しサイズの見直し（管理画面：wp_get_attachment_image_src medium、フロント：wp_get_attachment_image_src large）
* スクリプトをフッターで呼び出すように修正
* 翻訳ファイル（JS）不要な文字列の削除
* 不具合修正

### v0.1.0

ベータ版リリース