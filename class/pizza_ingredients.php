<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pizza_ingredients
 *
 * @author élève
 */
class pizza_ingredients extends table {
    protected $pk = "id";
    protected $table = "pizza_ingredients";
    protected $champs = ["id", "ingredient"];
}
