はじめに

このアプリはPHPを独学で学習している私がアウトプットの１つとして作成したもので、セキュリティなどに問題があるかもしれません。  
もし実際にアプリを動作させるような場合はローカル環境で動作させてください。
あと、もし眼に余るようなトンデモナイ記述をしていたらそっと<a href="https://twitter.com/float_top">ツイッター</a>のDMにでも連絡いただければ幸いです。(；´Д`)


アプリ名
====
**<a href="https://1.kagome.xyz/borad_on_cake/">「画像掲示板」 CakePHP.ver</a>**
<img src="https://user-images.githubusercontent.com/52596476/64934788-23d7ae00-d888-11e9-9069-1c218c470008.png" width="800">  

## 簡単な説明
前作の<a href="https://board.kagomeee.com/">「画像掲示板」</a>をcakephpで作り変えました。  
デザインやレイアウトは前作の物を流用していますが、機能面で新たに追加した物もあります。



## 機能
1. 会員登録機能
1. 会員情報変更機能
1. 退会機能
1. ユーザーアイコン変更機能
1. コンテンツ投稿機能
1. コンテンツ削除機能
1. 返信機能
1. 投稿画像サムネイル表示機能
1. 画像詳細表示機能
1. ~~投稿制限機能~~
1. 返信可不可選択機能 <font color="red">new!!</font>
1. urlリンク生成機能 <font color="red">new!!</font>
1. 投稿画像一覧表示機能(mypage) <font color="red">new!!</font>
1. youtube動画サムネイル&タイトル表示機能 <font color="red">new!!</font>
1. 投稿youtube動画サムネイル一覧表示機能(mypage) <font color="red">new!!</font>
1. 投稿検索機能 <font color="red">new!!</font> 9/21



## 開発環境
使用言語・データーベース
* PHP
* HTML
* CSS(SCSS)
* MYSQL  

使用ツール・ライブラリ
* vagrant
* Atom Editor  
* jquery
* slick
* fontawesome
* youtubeAPI



## 作った感想と今後の課題  

定数をどこで定義すれば良いのか、色々出てきて迷ったのですが数も少ないので`bootstrap.php`で定義しています。  
youtubeAPIのキーもここで設定可能です。  
他には独自のHelperやValidationを作成したり。各Controllerで使用する共通functionをコンポーネントに記載して使用しました。  

またcakeの学習と並行してscssの学習も引き続き行っています。今回初めて`@each`を使ってループ処理をしたりもしました。  
`webroot\sass\styles.scss`に記載しています。  
参考になったサイト。[http://dim5.net/cakephp/sass-generate-css.html]

## 1  
「12.urlリンク生成機能　14.youtube動画サムネイル&タイトル表示機能」  
今回はコンテンツ投稿時にurlが含まれていた場合は正規表現を使ってurlを検出して、`<a></a>`で囲ってリンクを自動生成させました。  
これはネットにたくさん情報があったので簡単に実装できました。  
ただしリンクが自動生成されるのは`https://`のみで`http://`ではurlは表示されますが、リンクは生成されません。  
さらにもう少し正規表現を使って機能を増やしたいと思ったので、youtube動画のurlが投稿された場合は動画のサムネイルを表示させることにしました。  
参考になった記事はこちら。[https://applica.info/youtube-thumbnail-acquisition]  
youtubeのurlから11桁のIDを切り出して加工してサムネイルを取得することができました。  
さらに欲が出て動画のタイトルも表示させたくなったのですが、これは流石に難しいと判断してyoutubeAPIに頼りました。  
動画のサムネイル取得もAPIに頼れば楽だったのですが、一応正規表現の学習の一貫なので今回はタイトル取得のみAIPに頼っています。  
上記の機能は`View\Helper\LinkHelper.php`の`CreateLink()`ファンクションで行っています。  
現時点ではページが読み込まれる度にヘルパーで処理を行っているので、今後投稿が増えていくと処理が重くなると思います。  
解決策としては素直にDBにタイトルとサムネイル画像のパスを格納しようかと思っています。  
9/22　youtubeAPIのクエリ上限に達してしまうと、タイトルの表示が一時的に不可能な状態になってしまいます。
考えてみればviewでページを読み込む度にAPIにクエリしてる訳で簡単に上限いく訳ですね。  
リセットされれば表示が再開されますが、予定通りDBにタイトルを格納する方向で修正します。  
<img src="https://user-images.githubusercontent.com/52596476/64934742-d5c2aa80-d887-11e9-85a8-1b34bf29275d.png" width="600">  

## 2   
 「13.投稿画像一覧表示機能(mypage)　15.投稿youtube動画サムネイル一覧表示機能(mypage)」  
①で投稿された画像とyoutube動画のサムネイルをmypageにてjqueryのプラグインのslickを使って一覧表示させました。  
画像はDBに保存してあるので取り出すのは簡単なのですが、youtubeのサムネルはurlが含まれている投稿のみを正規表現を使って探し出して表示させています。  
上記の処理は`UsersController.php`の`edit()`ファンクションの94〜128辺りで行っています。  
`view`でのサムネイルとタイトルの表示処理は`View\Helper\LinkHelper.php`の`CreateYoutubeThumb()`で行っています。  
<img src="https://user-images.githubusercontent.com/52596476/64935254-2a1b5980-d88b-11e9-81a7-ad032ff4ea02.png" width="600">  
~~PC表示ではslickスライダーの表示に問題はないのですが、スマホで見た場合にスライダーのarrowボタンがうまく表示されないのと、サムネイルが小さくなりすぎて操作性が悪くなってしまっています。  
解決策としてはslickには他に使用できるレイアウトがあるので、そちらに変更するかもしれません。こんな感じのが良いかもしれないです。~~  
レイアウト変更しました。スマホ表示の矢印表示も改善されました。9/22  
<img src="https://user-images.githubusercontent.com/52596476/65381473-0e053580-dd2d-11e9-8f34-4745aaf386b5.png" width="600">


## 3  
11.返信可不可選択機能  
コンテンツを投稿する際に、他ユーザーからの返信を「許可する」or「許可しない」を選択できるようにしました。  
「許可する」を選択してコンテンツを投稿すると、会員ならば誰でも投稿にたいして返信する事ができます。  
「許可しない」を選択すると投稿に対して、他ユーザーは返信する事が不可能になります。ただし、許可されないのは返信のみなので、他ユーザーは自由に投稿内容を閲覧する事ができます。  
<img src="https://user-images.githubusercontent.com/52596476/64934544-7e700a80-d886-11e9-94d7-b2c6d5e65e5c.png" width="600">  
<img src="https://user-images.githubusercontent.com/52596476/64934634-0eae4f80-d887-11e9-98e8-1617976171cb.png" width="600">


## 今後実装したい機能や課題  
## ①
スマホで画像を投稿しようとすると出来ない場合がある。拡張子が問題なのかサイズの問題なのか。現在調査中。  
たぶんjavascriptで色々しなきゃいけない気がします。

## ②  
qiitaのurlを投稿すると、一緒にタイトルも表示される機能。  
今はurlとタイトルを２回コピペしなきゃいけなく面倒なので。
qiitaAPIがあるのでやれるかもしれないです[https://qiita.com/leafia78/items/a252a09bbdf31bf770f4]
