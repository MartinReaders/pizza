<?php

//class mere
class table {
   
    protected $pk;   //Cles primaire
    protected $table; //table
    protected $champs=[];  //champs
    protected $valeurs=[]; 
    protected $links=[];
    protected $linksVal=[];
    
    
    
    public function __construct($pk = null) {
        //method magique
        //charger l'objet apres avoir apple new objet
        if(!is_null($pk)){
            $this->loadById($pk);
        }
        
    }
    
    
    public function get($nomChamp){
        //Recupere la valuer 
        //$nomChamp nom du champ
        //Retour la valeur du champ
        if(!in_array($nomChamp, $this->champs)){
            echo "Champ $nomChamp inexiste";
            return "";
        }
        if(isset($this->links[$nomChamp])){
            if(!isset($this->linksVal[$nomChamp])){
                $class = $this->links[$nomChamp];
                $this->linksVal[$nomChamp] = new $class($this->valeurs[$nomChamp]);
            }
            return $this->valeurs[$nomChamp];
        }
        
        if(isset($this->valeurs[$nomChamp])){
            return $this->valeurs[$nomChamp];
        } else {
            return "";
        }
    }
    
    
    public function set($nomChamp, $val){
        //Role initialiser la valeur
        //Paramtres : $nomChamp nom du champ, $val la valeur
        //retoru trou ou false
        if(!in_array($nomChamp, $this->champs)){
            echo "Champ $nomChamp inexsite";
            return false;
        }
        $this->valeurs[$nomChamp] = $val;
        return true;
    }
    
    public function loadById($pk){
        //Role charger lobjet par id
        //Param $pk cles primaire
        //Retour l'odjet demande
        $sql = "SELECT * FROM `{$this->table}` WHERE `{$this->pk}`=:pk";
        $param = [":pk"=>$pk];
        $req = BDDselect($sql, $param);
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        if(!empty($ligne)){
            $this->setFromTab($ligne);
            return true;
        }else{
            $this->valeurs[$this->pk]=0;
            return false;
        }
        
    }
    
    public function setFromTab($tab){
        //Role Charger la valeurs de pluisierus attributs
        //Paramtres $tab tableu
        //Retour trou ou false
        foreach ($this->champs as $nomChamp){
            if(isset($tab["$nomChamp"])){
                $this->set($nomChamp,$tab["$nomChamp"]);
            }
        }
        return true;
    }
    
    
    public function inser(){
        //Role : insert dans la basse de donnes
        //paramtres non
        //Retour trou ou false
        $sql = "INSERT INTO `{$this->table}` SET";
        $set = [];
        $param = [];
        foreach ($this->champs as $nomChamp){
            if($nomChamp !== "id"){
                 $set[]= "`$nomChamp`=:$nomChamp";
                 $param["$nomChamp"]= $this->valeurs[$nomChamp];
            }
            
           
        }
        
        $sql .= implode(",", $set);
        if(BDDquery($sql, $param) === 1){
            $this->valeurs[$this->pk]= BDDlastId();
            return true;
        } else {
            echo 'Erorre de la creation' . get_class($this);
        }
    }
    
    public function update(){
        //Role : mette a jour 
        //paratres non
        //retour non
        $sql = "UPDATE `{$this->table}` SET ";
        $set = [];
        $param = [];
        foreach ($this->champs as $nomChamp){
            $set[]= "`$nomChamp`=:$nomChamp";
            $param["$nomChamp"]=$this->valeurs[$nomChamp];
        }
        
        $sql .= implode(",", $set);
        $sql .= " WHERE `{$this->pk}`=:pk";
        $param[":pk"] = $this->valeurs[$this->pk];
        
        if(BDDquery($sql, $param)!==-1){
            return true;
        } else {
            echo "Error de modification". get_class($this);
            return false;
        }
    }
    
    
    
    public function delete(){
        //Role suprimer 
        //paramtre  non
        //retoiur trou ou false
        $sql= "DELETE FROM `{$this->table}` WHERE `{$this->pk}`=:pk";
        $param = [":pk"=> $this->valeurs[$this->pk]];
        
        if(BDDquery($sql, $param)!==-1){
            return true;
        }else{
            echo 'Errore de supresion'. get_class($this);
            return false;
        }
    }
    
    
    
    
}
