<?php
//isso aqui serve so pra organizar e dizer que o name space pertence a src/config
namespace Src\Config;

//aqui importa os recursos nativos do php pra conectar com o banco
use PDO;
use PDOException;

class Database {

//isso aqui guarda a conexão depois que a gente criar ela
    private static $instance = null;

    public static function getConnection() {
        if (self::$instance === null) {
            //criando a conexão aqui dentro da funcao getConnection, caso não tenha feito ainda (if)

            //dados do bg pra conectar
            $host = 'localhost';
            $db   = 'jabulani_eventos';
            $user = 'root'; 
            $pass = '';     
            //formatação Multibyte de 4 bytes para conexões de banco de dados, sendo o padrão atual e recomendado
            $charset = 'utf8mb4';

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            
            //aqui configura o comportamento do PDO
            $options = [
                //exception de erro
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,

                //configura banco pra retordar dados como um array onde acessa os dados atraves de uma coluna (ex: $linha['nome_do_evento'])
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

                //aqui e pra segurança pra n fazer sql injection
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            //aqui cria a conexão com o banco
            try {
                self::$instance = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {

                die("Erro de conexao com o banco de dados: " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}