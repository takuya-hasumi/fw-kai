<?php
// 抽象クラスの定義
abstract class Base
{
    // DBに接続するコンストラクタ
    public function __construct()
    {
        $env = $this->getEnv();

        // db接続とトランザクション
        $pdo = new PDO(
            'mysql:host=mysql;dbname=' . $env['DB_DATABASE'],
            $env['DB_USERNAME'],
            $env['DB_PASSWORD'],
            [
                PDO::ATTR_ERRMODE          => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
        $pdo->beginTransaction();

        return $pdo;

    }

    // 参照終了後、DBに書き込むかロールバックする
    public function __destruct()
    {
        try {
            // 例外が発生しなければコミット
            $stmt = $pdo -> prepare("INSERT INTO commit_table (user_name) VALUES (:user_name)");
            $stmt->bindParam(':user_name', $env['DB_USERNAME'], PDO::PARAM_STR);
            if (!$stmt->execute()) {
                throw new Exception('テーブルの書き込みに失敗だZ');
            }
            $pdo->commit();
        } catch (PDOException $e) {
            echo "コミットできませんでした" . $e->getMessage();
            $pdo->rollBack();
        }
    }

    // 抽象メソッドの定義
    abstract public function Action();

}
