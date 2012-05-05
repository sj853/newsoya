<?php
/*
用户需要事先定义的常量：
_htmlPath_模板静态路径
_htmlEnable_自动静态机制是否开启，未定义或为空，表示关闭自动静态机制
_RehtmlTime_自动重新静态间隔时间，单位为秒，未定义或为空，表示关闭自动重新静态
*/
class html{
    var$htmlfile;
    var$htmlfilevar;
    function html(){
    //生成当前页的html组文件名$this->htmlfilevar及文件名$this->htmlfile
    //动态页的参数不同对应的html文件也不同，但是每一个动态页的所有html文件都有相同的文件名，只是扩展名不同
        $s=array(".","/");$r=array("_","");
        $this->htmlfilevar=str_replace($s,$r,$_SERVER["SCRIPT_NAME"])."_".$_GET[_ActionVar_];
        $this->htmlfile=$this->htmlfilevar.".".md5($_SERVER["REQUEST_URI"]).".html";
    }

    //删除当前页/模块的静态
    function delete(){
        //删除当前页的静态
        $d=dir(_htmlPath_);
        $strlen=strlen($this->htmlfilevar);
        //返回当前页的所有html文件组
        while(false!==($entry=$d->read())){
            if(substr($entry,0,$strlen)==$this->htmlfilevar){
            if(!unlink(_htmlPath_."/".$entry)){echo"html目录无法写入";exit;}
            }
        }
    }

    //判断是否已html过，以及是否需要html
    function check(){
        //如果设置了静态更新间隔时间_RehtmlTime_
        if(_RehtmlTime_+0>0){
            //返回当前页html的最后更新时间
            $var=@file(_htmlPath_."/".$this->htmlfilevar);$var=$var[0];
            //如果更新时间超出更新间隔时间则删除html文件
            if(time()-$var>_RehtmlTime_){
                $this->delete();$ischage=true;
            }
        }

        //返回当前页的html
        $file=_htmlPath_."/".$this->htmlfile;
        //判断当前页html是否存在且html功能是否开启
        return (file_exists($file) and _htmlEnable_ and !$ischange);

    }

    //读取html
    function read(){
        //返回当前页的html
        $file=_htmlPath_."/".$this->htmlfile;
        //读取html文件的内容
        if (_htmlEnable_) return readfile($file);
        elsereturnfalse;
    }

    //生成html
    function write($output){
        //返回当前页的html
        $file=_htmlPath_."/".$this->htmlfile;
        //如果html功能开启
        if(_htmlEnable_){
            //把输出的内容写入html文件
            $fp=@fopen($file,'w');
            if(!@fputs($fp,$output)){echo"template html can not be writed - thrfou :static_head";exit;}
            @fclose($fp);
            //如果设置了静态更新间隔时间_RehtmlTime_
            if(_RehtmlTime_+0>0){
                //更新当前页html的最后更新时间
                $file=_htmlPath_."/".$this->htmlfilevar;
                $fp=@fopen($file,'w');
                if(!@fwrite($fp,time())){echo"template html can not be writed - thrfou :static_head";exit;}
                @fclose($fp);
            }
        }
    }
}

?>