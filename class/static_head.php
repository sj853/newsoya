<?
/*
�û���Ҫ���ȶ���ĳ�����
_htmlPath_ģ�徲̬·��
_htmlEnable_�Զ���̬�����Ƿ�����δ�����Ϊ�գ���ʾ�ر��Զ���̬����
_RehtmlTime_�Զ����¾�̬���ʱ�䣬��λΪ�룬δ�����Ϊ�գ���ʾ�ر��Զ����¾�̬
*/
class html{
    var$htmlfile;
    var$htmlfilevar;
    function html(){
    //���ɵ�ǰҳ��html���ļ���$this->htmlfilevar���ļ���$this->htmlfile
    //��̬ҳ�Ĳ�����ͬ��Ӧ��html�ļ�Ҳ��ͬ������ÿһ����̬ҳ������html�ļ�������ͬ���ļ�����ֻ����չ����ͬ
        $s=array(".","/");$r=array("_","");
        $this->htmlfilevar=str_replace($s,$r,$_SERVER["SCRIPT_NAME"])."_".$_GET[_ActionVar_];
        $this->htmlfile=$this->htmlfilevar.".".md5($_SERVER["REQUEST_URI"]).".html";
    }

    //ɾ����ǰҳ/ģ��ľ�̬
    function delete(){
        //ɾ����ǰҳ�ľ�̬
        $d=dir(_htmlPath_);
        $strlen=strlen($this->htmlfilevar);
        //���ص�ǰҳ������html�ļ���
        while(false!==($entry=$d->read())){
            if(substr($entry,0,$strlen)==$this->htmlfilevar){
            if(!unlink(_htmlPath_."/".$entry)){echo"htmlĿ¼�޷�д��";exit;}
            }
        }
    }

    //�ж��Ƿ���html�����Լ��Ƿ���Ҫhtml
    function check(){
        //��������˾�̬���¼��ʱ��_RehtmlTime_
        if(_RehtmlTime_+0>0){
            //���ص�ǰҳhtml��������ʱ��
            $var=@file(_htmlPath_."/".$this->htmlfilevar);$var=$var[0];
            //�������ʱ�䳬�����¼��ʱ����ɾ��html�ļ�
            if(time()-$var>_RehtmlTime_){
                $this->delete();$ischage=true;
            }
        }

        //���ص�ǰҳ��html
        $file=_htmlPath_."/".$this->htmlfile;
        //�жϵ�ǰҳhtml�Ƿ������html�����Ƿ���
        return (file_exists($file) and _htmlEnable_ and !$ischange);

    }

    //��ȡhtml
    function read(){
        //���ص�ǰҳ��html
        $file=_htmlPath_."/".$this->htmlfile;
        //��ȡhtml�ļ�������
        if (_htmlEnable_) return readfile($file);
        elsereturnfalse;
    }

    //����html
    function write($output){
        //���ص�ǰҳ��html
        $file=_htmlPath_."/".$this->htmlfile;
        //���html���ܿ���
        if(_htmlEnable_){
            //�����������д��html�ļ�
            $fp=@fopen($file,'w');
            if(!@fputs($fp,$output)){echo"template html can not be writed - thrfou :static_head";exit;}
            @fclose($fp);
            //��������˾�̬���¼��ʱ��_RehtmlTime_
            if(_RehtmlTime_+0>0){
                //���µ�ǰҳhtml��������ʱ��
                $file=_htmlPath_."/".$this->htmlfilevar;
                $fp=@fopen($file,'w');
                if(!@fwrite($fp,time())){echo"template html can not be writed - thrfou :static_head";exit;}
                @fclose($fp);
            }
        }
    }
}

?>