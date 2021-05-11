<?php

Class keyApi
{
    /*Apenas nos acessamos a variavel */
    private $key = null;
    /*Variavel de erro */
    private $error = null;

    /*Variavel que guardo o ip do usuario */
    private $ip = "";

    /*Ao instanciar a classe passo a chave que está sendo transportada no index
    e salvo na variavel key desta classe
    O null é em caso de não receber nada
     */
    function __construct($key = null)
    {  
       if(!empty($key)) $this->key = $key;
    }

    /*Pego o ip de forma manual caso o usuário digite*/
    function pegarip($ip)
    {
        $this->ip = $ip;
    }

    /*Aqui faço o pedido a api da geoipfy passando o endpoint e o usando na url, também posso passar parametros */
    function request ($endpoint = '', $parametros =  array())
    {

        /* Verifico se existe algo dentro do ip

        */
        if(strlen($this->ip) != 0)
        {
            $url = "https://geo.ipify.org/".$endpoint."?apiKey=".$this->key."&ipAddress=".$this->ip."&format=json";
        }/* Se não possuir pega automaticamente*/
        else{
            $url = "https://geo.ipify.org/".$endpoint."?apiKey=".$this->key."&format=json";
        }

        /*Se o parametro for um array, ele de qualquer forma já que está inicializado como um, continua o procedimento */
        if(is_array($parametros))
        {
            /*Adiciono a url o que foi passado dentro da variavel parametros */
            foreach($parametros as $key => $value)
            {
                /**Caso não exista ele não passa o valor novamente*/
                if(empty($value)) continue;
                $url .= $key."=".urlencode($value)."&";
            }   

            /*Pego todos os arquivos dentro da url e transforma em json enviando a 
            variavel response */
            $response = @file_get_contents($url);
            /*Digo que não houve erro*/
            $this->error = false;

            /*Retorno um array a partir do json que o response recebeu*/
            return json_decode($response,true);
        }
        else{
            /**Caso não exista um array nos retornamos o erro */
            $this->error = true;
            return false;
        }
    }

    /**Mensagem de erro */
    function is_error()
    {
        return $this->error;
    }

    /*A função country ou País, retorna o array com todas as
     informações sobre a localização do usuario */
    function country()
    {
        /*Função que retornou o array com informações */
        $data = $this->request("/api/v1");

        /**SE não estiver vazio e for um array a variavel: data
         * continuamos a programação
        */
        if(!empty($data) && is_array($data['location']))
        {
            /*Nós apresentamos falso para o erro */
            $this->error = false;
            
            /*Retornamos o array especifico $data['location']
              Nesse caso, um array mais geral*/
            return $data;
        }
        else{
            /*Se um dos ou ambos forem falsos nos atribuimos o erro e retornamos false */
            $this->error = true;
            return false;
        }
    }
}

?>