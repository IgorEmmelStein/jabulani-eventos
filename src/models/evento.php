<?php

namespace Src\Models;

class Evento {
    private $id;
    private $titulo;
    private $descricao;
    private $local;
    private $dataEvento;
    private $registroCriado;

    public function __construct($titulo = null, $descricao = null, $local = null, $dataEvento = null, $id = null, $registroCriado = null) {
        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->local = $local;
        $this->dataEvento = $dataEvento;
        $this->id = $id;
        $this->registroCriado = $registroCriado;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getLocal() {
        return $this->local;
    }

    public function setLocal($local) {
        $this->local = $local;
    }

    public function getDataEvento() {
        return $this->dataEvento;
    }

    public function setDataEvento($dataEvento) {
        $this->dataEvento = $dataEvento;
    }

    public function getRegistroCriado() {
        return $this->registroCriado;
    }

    public function setRegistroCriado($registroCriado) {
        $this->registroCriado = $registroCriado;
    }
}