<?php

class Database{
	/* 
	 * Variaveis do banco 
	 */
	private $db_host = "localhost";  
	private $db_user = "root"; 
	private $db_pass = "";
	private $db_name = "avaliacao";
	
	/*
	 * variaveis para serem usadas em debug
	 */
	private $con = false; // verifica se a conexao está ativa
    private $myconn = ""; // objeto sql
	private $result = array(); // Todos os resultados de uma consulta serão armazenados aqui
    private $myQuery = "";// Usado para o processo de depuração com retorno SQL
    private $numResults = "";// Retorna o numero de registros
	
	// conecta no banco
	public function connect(){
		if(!$this->con){
			$this->myconn = new mysqli($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
            if($this->myconn->connect_errno > 0){
                array_push($this->result,$this->myconn->connect_error);
                return false; // Se der problema ao selecionar o banco de dados
            }else{
                $this->con = true;
                return true; // Achou o bando de dados
            } 
        }else{  
            return true; // Conexao ok
        }  	
	}
	
	// desconecta no banco
    public function disconnect(){
    	
		// Se houver uma conexão com o banco de dados
    	if($this->con){    		
    		if($this->myconn->close()){    		
    			$this->con = false;			
				return true;
			}else{				
				return false;
			}
		}
    }
	
	public function sql($sql){
		$query = $this->myconn->query($sql);
        $this->myQuery = $sql;
		if($query){			
			$this->numResults = $query->num_rows;		
			for($i = 0; $i < $this->numResults; $i++){
				$r = $query->fetch_array();
               	$key = array_keys($r);
               	for($x = 0; $x < count($key); $x++){               		
                   	if(!is_int($key[$x])){
                   		if($query->num_rows >= 1){
                   			$this->result[$i][$key[$x]] = $r[$key[$x]];
						}else{
							$this->result = null;
						}
					}
				}
			}
			return true; // Se estiver ok
		}else{
			array_push($this->result,$this->myconn->error);
			return false; // Deu algum problema
		}
	}
	
	// Função para SELECT
	public function select($table, $rows = '*', $join = null, $where = null, $order = null, $limit = null){		
		$q = 'SELECT '.$rows.' FROM '.$table;
		if($join != null){
			$q .= ' JOIN '.$join;
		}
        if($where != null){
        	$q .= ' WHERE '.$where;
		}
        if($order != null){
            $q .= ' ORDER BY '.$order;
		}
        if($limit != null){
            $q .= ' LIMIT '.$limit;
        }        
        $this->myQuery = $q;
		// Verifica se tabela existe
        if($this->tableExists($table)){
        	// Caso exista 
        	$query = $this->myconn->query($q);    
			if($query){				
				$this->numResults = $query->num_rows;			
				for($i = 0; $i < $this->numResults; $i++){
					$r = $query->fetch_array();
                	$key = array_keys($r);
                	for($x = 0; $x < count($key); $x++){                	
                    	if(!is_int($key[$x])){
                    		if($query->num_rows >= 1){
                    			$this->result[$i][$key[$x]] = $r[$key[$x]];
							}else{
								$this->result[$i][$key[$x]] = null;
							}
						}
					}
				}
				return true; // Se estiver ok
			}else{
				array_push($this->result,$this->myconn->error);
				return false; // Deu algum problema
			}
      	}else{
      		return false; // Se tabela nao existir
    	}
    }
	
	
	// Função para inserir no banco de dados
    public function insert($table,$params=array()){
    	// Verifica se tabela existe
    	 if($this->tableExists($table)){
    	 	$sql='INSERT INTO `'.$table.'` (`'.implode('`, `',array_keys($params)).'`) VALUES ("' . implode('", "', $params) . '")';
            $this->myQuery = $sql; // passa o sql           
            if($ins = $this->myconn->query($sql)){
            	array_push($this->result,$this->myconn->insert_id);
                return true; // Se estiver ok faz o insert
            }else{
            	array_push($this->result,$this->myconn->error);
                return false; // Deu algum problema nao faz insert
            }
        }else{
        	return false; // Se tabela nao existir
        }
    }
	
	// Função para deletar no banco de dados
    public function delete($table,$where = null){    	
    	 if($this->tableExists($table)){    	 
    	 	if($where == null){
                $delete = 'DROP TABLE '.$table;
            }else{
                $delete = 'DELETE FROM '.$table.' WHERE '.$where;
            }           
            if($del = $this->myconn->query($delete)){
            	array_push($this->result,$this->myconn->affected_rows);
                $this->myQuery = $delete;
                return true;
            }else{
            	array_push($this->result,$this->myconn->error);
               	return false;
            }
        }else{
            return false;
        }
    }
	
	// Função para update no banco de dados
    public function update($table,$params=array(),$where){    
    	if($this->tableExists($table)){    		
            $args=array();
			foreach($params as $field=>$value){				
				$args[]=$field.'="'.$value.'"';
			}		
			$sql='UPDATE '.$table.' SET '.implode(',',$args).' WHERE '.$where;			
            $this->myQuery = $sql;
            if($query = $this->myconn->query($sql)){
            	array_push($this->result,$this->myconn->affected_rows);
            	return true;
            }else{
            	array_push($this->result,$this->myconn->error);
                return false;
            }
        }else{
            return false;
        }
    }
	
	// Verificar se a tabela existe
	private function tableExists($table){
		$tablesInDb = $this->myconn->query('SHOW TABLES FROM '.$this->db_name.' LIKE "'.$table.'"');
        if($tablesInDb){
        	if($tablesInDb->num_rows == 1){
                return true;
            }else{
            	array_push($this->result,$table."Não existe neste banco de dados");
                return false;
            }
        }
    }
	
	// Retorna resultados
    public function getResult(){
        $val = $this->result;
        $this->result = array();
        return $val;
    }
    
	// Retorna o SQL de volta para depuração
    public function getSql(){
        $val = $this->myQuery;
        $this->myQuery = array();
        return $val;
    }

    
	// Retorna o número de linhas de volta
    public function numRows(){
        $val = $this->numResults;
        $this->numResults = array();
        return $val;
    }

} 
