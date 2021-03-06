<?php

class Empresa extends Eloquent{

  protected $table = 'empresas';

  public $primaryKey = 'ruc';

  public $incrementing = false;
  
  public $timestamps = false;

  public function trabajadores(){
    return $this->hasMany('Trabajador', 'empresa_ruc');
  }

  public function clientes(){
    return $this->belongsToMany('Cliente', 'cliente_empresa', 'empresa_ruc', 'cliente_ruc');
  }

  public function contratos(){
    return $this->hasMany('Contrato', 'empresa_ruc');
  }

  public function usuarios(){
    return $this->belongsToMany('Usuario', 'area_empresa_usuario', 'empresa_ruc', 'usuario_id')
      ->withPivot('area_id');
  }

  public function costos(){
    return $this->hasMany('Costo', 'empresa_ruc');
  }

  public function variables(){
    return $this->hasMany('Variable', 'empresa_ruc');
  }

  public function cartas(){
    return $this->hasMany('Carta', 'empresa_ruc');
  }

  public function memorandums(){
    return $this->hasMany('Memorandum', 'empresa_ruc');
  }

  public function informes(){
    return $this->hasMany('Informe', 'empresa_ruc');
  }

  public function prendas(){
    return $this->belongsToMany('Prenda', 'empresa_prenda', 'empresa_ruc', 'prenda_id')
      ->withPivot('codigo', 'cantidad_p', 'cantidad_s');
  }

  public function herramientas(){
    return $this->belongsToMany('Herramienta', 'empresa_herramienta', 'empresa_ruc', 'herramienta_id')
      ->withPivot('serie', 'marca', 'modelo', 'descripcion');
  }
}