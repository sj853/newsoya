<?php

class Database
{
    private $Connection = NULL;

    public static function Connect()
    {
        $obj = new Database();
        $ret = $obj->Connection = mysql_connect( DATABASE_IP_ADDRESS, DATABASE_USERNAME, DATABASE_PASSWORD,true);
        if( !$ret ) throw new Exception( "Error, failed to connect to database. " . mysql_error());

        $ret = mysql_select_db( DATABASE_NAME, $obj->Connection);
        if( !$ret ) throw new Exception ("Error, failed to select db " . mysql_error());

        $ret = mysql_query( 'set names utf8', $obj->Connection);
        if( !$ret ) throw new Exception ("Error, failed to set the character_set" . mysql_error());
        return $obj;
    }

    function __destruct()
    {
        $this->Close();
    }
    public function Close()
    {
        if( $this->Connection != NULL )
        {
            mysql_close($this->Connection);
            $this->Connection = NULL;
        }
    }

    public function Execute($sql)
    {
        $rs = mysql_unbuffered_query( $sql, $this->Connection);
        if( !$rs ) throw new Exception( "Error, failed to execute command '".$sql."',  " . mysql_error());
    }
    public function GetSingleVal($sql)
    {
        $rs = mysql_unbuffered_query( $sql, $this->Connection);
        if( !$rs ) throw new Exception( "Error, failed to execute query '".$sql."',  " . mysql_error());
        $row = mysql_fetch_row($rs);
        if( !$row ) return NULL;
        return $row[0];
    }

    public function GetSingleValOrDefault($sql, $defaultVal)
    {
        $rs = mysql_unbuffered_query( $sql, $this->Connection);
        if( !$rs ) throw new Exception( "Error, failed to execute query '".$sql."',  " . mysql_error());
        $row = mysql_fetch_row($rs);
        if( !$row ) return $defaultVal;
        return $row[0];
    }

    public function GetCount($sql)
    {
        $rs = mysql_query( $sql, $this->Connection);
        if( !$rs ) throw new Exception( "Error, failed to execute query '".$sql."',  " . mysql_error());

        return mysql_num_rows($rs);
    }


    public function GetSingleRow($sql)
    {
        $rs = mysql_unbuffered_query( $sql, $this->Connection);
        if( !$rs ) throw new Exception( "Error, failed to execute query '".$sql."',  " . mysql_error());
        return mysql_fetch_object($rs);
    }

    public function GetResultSet($sql)
    {
        $rs = mysql_query( $sql, $this->Connection);
        return $rs;
    }

    public function Insert( $tableName, &$newRow)
    {
        $sql = "describe " . $tableName;
        $rs = mysql_query( $sql, $this->Connection);
        if( !$rs ) throw new Exception( "Error, failed to describe table '".$tableName."',  " . mysql_error());

        $fieldsName = "";
        $fieldsValue = "";

        $reflectedObj = new ReflectionObject($newRow);
        $properties = $reflectedObj->getProperties();
        $count = count($properties);
        $fields = array();
        for( $i = 0; $i < $count; $i++)
        {
            $fields = array_merge( $fields, array($properties[$i]->getName() => $properties[$i]) );
        }

        $row = mysql_fetch_object($rs);
        while($row)
        {
            if( $reflectedObj->hasProperty($row->Field) )
            {
                $fieldVal = $fields[$row->Field]->getValue($newRow);
                $fieldsName = $fieldsName . $row->Field . ",";

                if( strpos( $row->Type, "varchar") == 0 ||
                    strpos( $row->Type, "char") == 0 ||
                    strpos( $row->Type, "datetime") == 0 ||
                    strpos( $row->Type, "time") == 0 )
                {
                    $fieldsValue = $fieldsValue."'".$this->Encode( $fieldVal )."',";
                }
                else
                {
                    $fieldsValue = $fieldsValue . $fieldVal . ",";
                }
            }

            $row = mysql_fetch_object($rs);
        }

        $sql = "INSERT INTO ".$tableName."(".rtrim($fieldsName,",").") VALUES(".rtrim($fieldsValue,",").")";
        $rs = mysql_unbuffered_query($sql, $this->Connection);

        if( !$rs ) throw new Exception( "Error, failed to execute query '".$sql."',  " . mysql_error());
    }

    public function Encode($str)
    {
        $str = str_replace("//", "////", $str);
        $str = str_replace("'", "''", $str);
        //addslashes($str);
        return $str;
    }

    public function UpdateByPk( $tableName, &$existingRow)
    {
        $sql = "describe " . $tableName;
        $rs = mysql_query( $sql, $this->Connection);
        if( !$rs ) throw new Exception( "Error, failed to describe table '".$tableName."',  " . mysql_error());

        $updateCause = "";
        $whereCause = "";

        $reflectedObj = new ReflectionObject($existingRow);
        $properties = $reflectedObj->getProperties();
        $count = count($properties);
        $fields = array();
        for( $i = 0; $i < $count; $i++)
        {
            $fields = array_merge( $fields, array($properties[$i]->getName() => $properties[$i]) );
        }

        $row = mysql_fetch_object($rs);
        while($row)
        {
            if( $reflectedObj->hasProperty($row->Field) )
            {
                $fieldVal = $fields[$row->Field]->getValue($existingRow);

                if( strpos( $row->Type, "varchar") == 0 ||
                    strpos( $row->Type, "char") == 0 ||
                    strpos( $row->Type, "datetime") == 0 ||
                    strpos( $row->Type, "time") == 0 )
                {
                    if( $row->Key == "PRI" )
                        $whereCause = $whereCause . "AND " . $row->Field . "='" . $this->Encode( $fieldVal )."' ";
                    else
                        $updateCause = $updateCause. $row->Field . "='".$this->Encode( $fieldVal )."',";
                }
                else
                {
                    if( $row->Key == "PRI" )
                        $whereCause = $whereCause . "AND " . $row->Field . "=" . $fieldVal." ";
                    else
                        $updateCause = $updateCause. $row->Field . "=".$fieldVal.",";
                }
            }

            $row = mysql_fetch_object($rs);
        }

        $sql = "UPDATE ".$tableName." SET ".rtrim($updateCause,",")." WHERE 1=1 ".$whereCause."";
        $rs = mysql_unbuffered_query($sql, $this->Connection);

        if( !$rs ) throw new Exception( "Error, failed to execute query '".$sql."',  " . mysql_error());
    }

    public function Delete($tableName, $deleteRow)
    {
        $sql = "describe " . $tableName;
        $rs = mysql_query( $sql, $this->Connection);
        if( !$rs ) throw new Exception( "Error, failed to describe table '".$tableName."',  " . mysql_error());

        $whereCause = "";

        $reflectedObj = new ReflectionObject($deleteRow);
        $properties = $reflectedObj->getProperties();
        $count = count($properties);
        $fields = array();
        for( $i = 0; $i < $count; $i++)
        {
            $fields = array_merge( $fields, array($properties[$i]->getName() => $properties[$i]) );
        }

        $row = mysql_fetch_object($rs);
        while($row)
        {
            if( $reflectedObj->hasProperty($row->Field) )
            {
                $fieldVal = $fields[$row->Field]->getValue($deleteRow);

                if( strpos( $row->Type, "varchar") == 0 ||
                    strpos( $row->Type, "char") == 0 ||
                    strpos( $row->Type, "datetime") == 0 ||
                    strpos( $row->Type, "time") == 0 )
                {
                    $whereCause = $whereCause . "AND " . $row->Field . "='" . $this->Encode( $fieldVal )."' ";
                }
                else
                {
                    $whereCause = $whereCause . "AND " . $row->Field . "=" . $fieldVal." ";
                }
            }

            $row = mysql_fetch_object($rs);
        }

        if( strlen($whereCause) == 0 )
            throw new Exception("Error, where cause is required!");

        $sql = "DELETE FROM ".$tableName." WHERE 1=1 ".$whereCause."";
        $rs = mysql_unbuffered_query($sql, $this->Connection);

        if( !$rs ) throw new Exception( "Error, failed to execute query '".$sql."',  " . mysql_error());
    }


	public function getConfigurationArray($key){
		$sql = "select * from configuration where `key` = '$key' ORDER BY sort,`value`";
		$rs = mysql_query($sql, $this->Connection);

		$return_rs = array();
		while($row=mysql_fetch_array($rs)){
            $return_rs[] =$row;
        }
		return $return_rs;
	}
	public function getConfigurationArray2($key,$parent_id){
		$sql = "select * from configuration where `key` = '$key' and A=$parent_id ORDER BY sort,`value`";
		$rs = mysql_query($sql, $this->Connection);

		$return_rs = array();
		while($row=mysql_fetch_array($rs)){
            $return_rs[] =$row;
        }
		return $return_rs;
	}
	public function getShangquanArray($quyu_id){
		$sql = "select * from configuration where `A` = '$quyu_id' and `key` = 'zufang_shangquan' ORDER BY sort,`value`";
		$rs = mysql_query($sql, $this->Connection);

		$return_rs = array();
		while($row=mysql_fetch_array($rs)){
            $return_rs[] =$row;
        }
		return $return_rs;
	}
	public function getGuanggao($guanggao_id){
		$sql = "select * from guanggao where `A` = '$guanggao_id'";
		$rs = mysql_query($sql, $this->Connection);

		$guanggao_content = '';
		while($row=mysql_fetch_array($rs)){
            $guanggao_content =$row['guanggao_content'];
			break;
        }
		return $guanggao_content;
	}
	public function getArticle($A){
		$sql = "select * from common_article where `A` = '$A'";
		$rs = mysql_query($sql, $this->Connection);

		$content = '';
		while($row=mysql_fetch_array($rs)){
            $content =$row['content'];
			break;
        }
		return $content;
	}
	public function isFavorites($type,$id){
		if($_SESSION['user_id']){
			$sql = "select * from shoucang where shoucang_leixing = $type and shoucang_dongxi_id=$id";
			$rs = mysql_query($sql, $this->Connection);
			while($row=mysql_fetch_array($rs)){
				return 1;
				break;
			}
		}
		return 0;
	}
	 
	public function insert_keywords($keywords_array,$type,$type_desc){
		foreach ($keywords_array as $kwds=>$hotval) {
			 	
			$sql = "select * from keyword_task where keyword = '$kwds'";
			 
			if($this->GetCount($sql)>0){
				$sql = "update keyword_task set" .
	    		" hotval=$hotval,time=now() where keyword='$kwds'";
				
				}else{
				
				$sql = "insert into keyword_task" .
	    		"(keyword,hotval,type,type_desc,time)" .
	    		" values('$kwds',$hotval,$type,'$type_desc',now())";
								
			}
			@mysql_unbuffered_query( $sql, $this->Connection);
			
			
		}	
	}
	 
	public function insert_keywords_gb2312($keywords_array,$source_num,$source_type){
		mysql_query('set names gb2312', $this->Connection); 
		foreach ($keywords_array as $kwds) {
		
			$sql = "select * from so where keyword = '$kwds'";
			$rs = mysql_query($sql, $this->Connection);
			$has = false;
			while($row=mysql_fetch_array($rs)){
				$has = true;
				break;
			}
			if($has){
				continue;
			}
			
			$sql = "insert into so" .
	    		"(keyword,keyword_add_date,source_num,source_type)" .
	    		" values('$kwds',now(),$source_num,'$source_type')";
			echo $kwds.'<br/>';
			@mysql_unbuffered_query( $sql, $this->Connection);
		}	
	}

	public function insert_keywords_result($kid,$content,$likes,$desc=''){
		mysql_query('set names gb2312', $this->Connection); 
			
			$sql = "select * from keyword_result where kid = $kid";
			$rs = mysql_query($sql, $this->Connection);
			while($row=mysql_fetch_array($rs)){
				$exsist = true;
				break;
			}
			if($exsist){
				$sql = "update keyword_result set" .
	    		" content='$content',likes='$likes',time=now(),description='$desc' where kid = $kid";
				
			}else{
				
				$sql = "insert into keyword_result" .
	    		"(kid,content,time,likes,description)" .
	    		" values($kid,'$content',now(),'$likes','$desc')";
								
			}
			 
			@mysql_unbuffered_query( $sql, $this->Connection);
		 	
	}
	public function setNamesGB2312(){
		mysql_query('set names gb2312', $this->Connection); 
	}

}
?>
