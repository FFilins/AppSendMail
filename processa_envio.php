<?php 

print_r($_POST);
echo '<br>';

class Mensagem {
    private $para = null;
    private $assunto = null;
    private $mensagem = null;

    public function __get($attr){
        return $this->$attr;
    }
    public function __set($attr, $value){
        return $this->$attr = $value;
    }
    public function mensagemValida() {
        if(empty($this->para) || empty($this->assunto) || empty($this->mensagem)) {
            return false;
        }

        return true;
    }


}

$mensagem = new Mensagem();

$mensagem->__set('para', $_POST['para']);
$mensagem->__set('assunto', $_POST['assunto']);
$mensagem->__set('mensagem', $_POST['mensagem']);

if($mensagem->mensagemValida()) {
    echo 'mensagem valida';
}else {
    echo 'mensagem inválida';
}

?>