<?php

namespace Src\Models;

class Usuario {
    private $idUsuario;
    private $nomeUsuario;
    private $email;
    private $senha;
    private $tipo;
    private $registroCriado;

    public function __construct($nomeUsuario = null, $email = null, $senha = null, $tipo = 'participante', $idUsuario = null, $registroCriado = null) {
        $this->nomeUsuario = $nomeUsuario;
        $this->email = $email;
        $this->senha = $senha;
        $this->tipo = $tipo;
        $this->idUsuario = $idUsuario;
        $this->registroCriado = $registroCriado;
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function getNomeUsuario() {
        return $this->nomeUsuario;
    }

    public function setNomeUsuario($nomeUsuario) {
        $this->nomeUsuario = $nomeUsuario;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getRegistroCriado() {
        return $this->registroCriado;
    }

    public function setRegistroCriado($registroCriado) {
        $this->registroCriado = $registroCriado;
    }
}