# Rese

飲食店予約サイト

## デプロイ先URL

[AWS上のデプロイ先](http://3.27.160.43/)

## 機能一覧

### ゲスト機能

* 店舗情報検索
* アカウント登録

### ユーザー機能

* 予約登録・確認・修正・削除
* お気に入り登録・削除
* マイページ
* ログイン・ログアウト

### 店舗代表者機能

* 管理画面
* 店舗検索
* 店舗情報登録・修正
* 店舗予約確認
* ログイン・ログアウト

### 管理者機能

* 管理画面
* 店舗代表者登録
* ログイン・ログアウト

## 仕様技術

Laravel 8.x

## ER図

![ER](https://github.com/Keigo-Ohashi/rese/assets/143822636/08b4d1c5-5c92-4734-81f0-c4ac204cb1cd)

## テストユーザー

| ロール  | Email               | Password    |
| ------- | ------------------- | ----------- |
| admin   | <admin@sample.com>    | AdminPass   |
| manager | <manager1@sample.com> | ManagerPass |
| ^       | <manager2@sample.com> | ^           |
| user    | <user1@sample.com>    | UserPass    |
| ^       | <user2@sample.com>    | ^           |
| ^       | <user3@sample.com>    | ^           |

## デプロイ方法(編集中)

### EC2

[EC2](https://ap-southeast-2.console.aws.amazon.com/ec2/home)の「インスタンスを起動」から以下の項目を設定して、インスタンスを起動する。

* 名前とタグ
  * 名前
* キーペア → 新しいキーペアの作成
  * キーペア名：(任意)
  * キーペアのタイプ：RSA
  * プライベートキーファイル形式：.pem
* ネットワーク設定
  * ファイアーウォール：セキュリティグループを作成
    * 以下の3つにチェック
      * SSHトラフィックを許可 → 自分のIP
      * インターネットからのHTTPSトラフィックを許可
      * インターネットからのHTTPトラフィックを許可

### RDS

[RDS](https://ap-southeast-2.console.aws.amazon.com/rds/home)の「データベースの作成」から以下の項目を設定して、データベースを作成する。

* エンジンのオプション
  * エンジンのタイプ：MySQL
  * エンジンバージョン：MySQL 8.0.28
* テンプレート：無料利用枠
* 設定
  * DBクラスター識別子：(任意)
  * 認証情報の設定
    * マスターユーザー名：(任意)
    * マスターパスワード：(任意)
* 接続
  * VPCセキュリティグループ(ファイアウォール)：既存の選択
    * 既存のVPCセキュリティグループ：[EC2](#ec2)で作成した「launch-wizard-(数字)」のみチェック

### S3

[S3](https://s3.console.aws.amazon.com/s3/home)の「バケットを作成」から以下の項目を設定して、バケットを作成する。
