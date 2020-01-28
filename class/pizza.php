<?php
//Class pizza

class pizza extends table {
   protected  $pk = "id"; 
   protected  $table = "pizza";
   protected  $champs = ["id", "img1", "img2","img3","taille", "pate", "base","description"];
   protected  $links = ["taille"=>"taille"];
   
}
