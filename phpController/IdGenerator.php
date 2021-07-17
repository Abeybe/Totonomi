<?php
//ランダムID作成用クラス
class IdGenerator{
    //12桁のIDを作成
    //日付による一意な文字列作成->ハッシュ化->桁指定で短縮
    public function createId(){
        return $this->shortHash(uniqid(),12);
    }
    public function shortHash($string, $len=6, $algo='sha512')
    {
        $hash   = hash($algo, $string);  // ハッシュ値の取得
        $number = hexdec($hash);         // 16進数ハッシュ値を10進数
        $result = $this->dec62th($number);      // 62進数に変換

        return substr($result, 0, $len); //$len の長さぶん抜き出し
    }

    public function dec62th($number)
    {
        $char = array_merge(
            range('0', '9'),
            // range('a', 'z'),
            range('A', 'H'),range('J', 'N'),range('P', 'Z')
        );
        
        return $this->decNth($number, $char);
    }

    public function decNth($number, array $char)
    {
        $base   = count($char);
        $result = "";

        while ($number > 0) {
            $result = $char[ fmod($number, $base) ] . $result;
            $number = floor($number / $base);
        }

        return empty($result) ? 0 : $result;
    }
}
?>