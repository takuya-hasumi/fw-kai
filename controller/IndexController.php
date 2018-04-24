<?php
class IndexController extends BaseController
{
    public function Action()
    {
        // 任意のテンプレートの呼び出し
        if (!$file = $this->getTemplate("index")) {
            throw new Exception('テンプレートの呼び出しに失敗しました。');
        }

        // 呼び出したテンプレートを置換
        if (!$file = $this->regParams($file, "This is INDEXだZ")) {
            throw new Exception('テンプレートの置換に失敗しました。');
        }

        // HTMLに出力
        if (!$this->viewHtml($file)) {
            throw new Exception('HTMLの出力に失敗しました。');
        }

    }
}
