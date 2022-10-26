<?php
header("Content-type:text/json;charset='utf-8'");
$cz = $_GET['lx'];
$url = $_GET['url'];


//$rz=file_get_contents('http://tg.kaxoo.cn/sq?sq=cx');
//var_dump( $rz);
//if($rz != '1'){
 //   die;
//}

if ($cz=='login') {
    $name = $_GET['name'];
    $tx = $_GET['tx'];
    login($url,$name,$tx);
}
if ($cz=='jcyh') {
    jcyh($url);
}
if ($cz=='xly') {
    $mm=$_GET['mm'];
    $nr = $_GET['nr'];
    xly($url,$mm,$nr);
}
if ($cz=='xly2') {
    $mm=$_GET['mm'];
    $nr = $_GET['nr'];
    xly2($mm,$nr);
}
if ($cz=='cly') {
    $mm=$_GET['mm'];
    $p=$_GET['p'];
    cly($mm,$p);
}
if ($cz=='zan') {
    $id=$_GET['id'];
    zan($id);
}
if ($cz=='jzan') {
    $id=$_GET['id'];
    jzan($id);
}
if ($cz=='zan2') {
    $id=$_GET['id'];
    hfzan($id);
}
if ($cz=='jzan2') {
    $id=$_GET['id'];
    hfjzan($id);
}
if ($cz=='hf') {
    $openid=$_GET['id'];
    $hfnr = $_GET['hfnr'];
    $hfid = $_GET['hfid'];
    $hfdxname = $_GET['hfdxname'];
    $hfdxmm = $_GET['hfdxmm'];
    hf($openid,$hfnr,$hfid,$hfdxname,$hfdxmm);
}
if ($cz=='sc') {
    $id=$_GET['id'];
    sc($id);
}
if ($cz=='schf') {
    $id=$_GET['id'];
    schf($id);
}


//
function jcyh($code){
    $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=wxd4f3764a267fa45a&secret=f8bf9cd2f894fa69c69c5f38eb6b568f&js_code='.$code.'&grant_type=authorization_code';
    $jg = zhuan($url);
    $jg =$jg['openid'];
    $link = mysqli_connect('localhost','数据库名','数据库密码','数据库名');
    if(!$link){
        exit('连接失败！');
    }
    if($jg){
        
        $res = mysqli_query($link,"select * from yh where openid like '%$jg%'");
        $row = mysqli_fetch_array($res);
        if(!$row){
            
            echo 0;
        }else{
            echo $jg;//有用户
        }
        //echo $row;
    }
}

function login($code,$name,$tx){
    $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=wxd4f3764a267fa45a&secret=f8bf9cd2f894fa69c69c5f38eb6b568f&js_code='.$code.'&grant_type=authorization_code';
    $jg = zhuan($url);
    $jg =$jg['openid'];
    $link = mysqli_connect('localhost','数据库名','数据库密码','数据库名');
    if(!$link){
        exit('连接失败！');
    }
    if($jg){
        
        $res = mysqli_query($link,"select * from yh where openid like '%$jg%'");
        $row = mysqli_fetch_array($res);
        if(!$row){
            
            //mysqli_query($link,"insert yh (openid,cs) values ('$jg',10)");
            mysqli_query($link,"insert yh (openid,name,tx) values ('$jg','$name','$tx')");
            echo $jg;
        }else{
            echo $jg;//有用户
        }
        //echo $row;
    }
}

function xly($jg,$mm,$nr){
    $link = mysqli_connect('localhost','数据库名','数据库密码','数据库名');
    if(!$link){
        exit('连接失败！');
    }
    $res = mysqli_query($link,"select * from yh where openid like '%$jg%'");
    $row = mysqli_fetch_array($res);
    //var_dump($row[2]);
    if($row){
        if($mm==''||$nr==''){
            echo '口令或内容不能为空';
            exit;
        }
        $name = $row[1];
        $tx = $row[2];
        $openid = $row[3];
        date_default_timezone_set("Asia/Shanghai");
        $lytime=date("Y-m-d H:i");
        
        
        
        mysqli_query($link,"insert xly (openid,name,tx,nr,mm,time) values ('$openid','$name','$tx','$nr','$mm','$lytime')");
        
        echo '留言成功';
   
    }
    
}
function xly2($mm,$nr){
    $link = mysqli_connect('localhost','数据库名','数据库密码','数据库名');
    if(!$link){
        exit('连接失败！');
    }

    if($mm==''||$nr==''){
        echo '001';
        die;
    }
    $name = 'wy';
    $tx = 'wy';
    $openid = 'wy';
    date_default_timezone_set("Asia/Shanghai");
    $lytime=date("Y-m-d H:i");
    
    mysqli_query($link,"insert xly (openid,name,tx,nr,mm,time) values ('$openid','$name','$tx','$nr','$mm','$lytime')");
    
    echo '1';
   
   
    
}

function hf($openid,$hfnr,$hfid,$hfdxname,$hfdxmm){
    $link = mysqli_connect('localhost','数据库名','数据库密码','数据库名');
    if(!$link){
        exit('连接失败！');
    }
    $res = mysqli_query($link,"select * from yh where openid like '%$openid%'");
    $row = mysqli_fetch_array($res);
    //var_dump($row['name']);die;
    if($row){
        if($hfnr==''){
            echo '回复内容不能为空';
            exit;
        }
        $name = $row['name'];
        $tx = $row['tx'];
        date_default_timezone_set("Asia/Shanghai");
        $lytime=date("Y-m-d H:i");
        
        mysqli_query($link,"insert hf (openid,hfname,hftx,hfnr,hfdxid,hfdxname,hfdxmm,time) values ('$openid','$name','$tx','$hfnr','$hfid','$hfdxname','$hfdxmm','$lytime')");
        
        $czhf = mysqli_query($link,"select * from hf where hfnr like '$hfnr' and hfdxmm like '$hfdxmm' and hfdxid like '$hfid'");
        $czhfjg = mysqli_fetch_array($czhf);
        echo json_encode($czhfjg);
   
    }
    
}

function cly2($mm,$p){
    if($mm==''){
        echo '请输入查询口令';
        die;
    }
    $link = mysqli_connect('localhost','数据库名','数据库密码','数据库名');
    if(!$link){
        exit('连接失败！');
    }
    $res = mysqli_query($link,"select * from xly where mm like '$mm'");
    
    
    $fh=[];
    while ($row = mysqli_fetch_array($res)){
        
        array_unshift($fh, $row);
        
    }
    $sl=count($fh);
    
    if(!$fh){
        echo '0';
        die;
    }
    // $cmf_arr = array_column($fh, 'zan');
    // array_multisort($cmf_arr, SORT_DESC, $fh);
    
    $fh = sortArrByManyField($fh,'zan',SORT_DESC,'id',SORT_DESC);
    // print_r($arr);exit();
    
    //echo $sl;
    //echo(json_encode( $fh));
    if(!$p){
        $p = 1;
    }
    
    $start = ($p-1)*10;
    for ($i=$start;$i<$start+10;$i++){
			if (!empty($fh[$i])){
			    $fhid = $fh[$i]['id'];
			    $res = mysqli_query($link,"select * from hf where hfdxmm like '$mm' and hfdxid like '$fhid'");
                $hf=[];
                while ($row = mysqli_fetch_array($res)){
                    
                    array_unshift($hf, $row);
                    
                }
                $hf = sortArrByManyField($hf,'hfid',SORT_ASC);
                $fh[$i]['hf']=$hf;
                
			    $fh[$i]['sl']=$sl;
				$new_arr[$i] = $fh[$i];
			}
		}
	//var_dump($new_arr);	
	
	
	echo json_encode($new_arr);die;
}
function cly($mm,$p){
    if($mm==''){
        echo '请输入查询口令';
        die;
    }
    $link = mysqli_connect('localhost','数据库名','数据库密码','数据库名');
    if(!$link){
        exit('连接失败！');
    }
    $res = mysqli_query($link,"select * from xly where mm like '$mm'");
    
    
    $fh=[];
    while ($row = mysqli_fetch_array($res)){
        
        array_unshift($fh, $row);
        
    }
    $sl=count($fh);
    
    if(!$fh){
        echo '0';
        die;
    }
    // $cmf_arr = array_column($fh, 'zan');
    // array_multisort($cmf_arr, SORT_DESC, $fh);
    
    $fh = sortArrByManyField($fh,'id',SORT_DESC);

	
	echo json_encode($fh);die;
}
function zan($id){
    $link = mysqli_connect('localhost','数据库名','数据库密码','数据库名');
    if(!$link){
        exit('连接失败！');
    }
    $res = mysqli_query($link,"select * from xly where id like '$id'");
    if($res){
        $fh=[];
        while ($row = mysqli_fetch_array($res)){
            
            array_unshift($fh, $row);
            
        }
        $zans = $fh[0]['zan']+1;
        mysqli_query($link,"UPDATE xly set zan='$zans' where id=$id");
       
        echo '点赞成功';
        
    }else{
        echo '点赞失败';
    }
	
}
function jzan($id){
    $link = mysqli_connect('localhost','数据库名','数据库密码','数据库名');
    if(!$link){
        exit('连接失败！');
    }
    $res = mysqli_query($link,"select * from xly where id like '$id'");
    if($res){
        $fh=[];
        while ($row = mysqli_fetch_array($res)){
            
            array_unshift($fh, $row);
            
        }
        $zans = $fh[0]['zan']-1;
        mysqli_query($link,"UPDATE xly set zan='$zans' where id=$id");
       
        echo '点赞成功';
        
    }else{
        echo '点赞失败';
    }
	
}
function hfzan($id){
    $link = mysqli_connect('localhost','数据库名','数据库密码','数据库名');
    if(!$link){
        exit('连接失败！');
    }
    $res = mysqli_query($link,"select * from hf where hfid like '$id'");
    if($res){
        $fh=[];
        while ($row = mysqli_fetch_array($res)){
            
            array_unshift($fh, $row);
            
        }
        $zans = $fh[0]['zan']+1;
        mysqli_query($link,"UPDATE hf set zan='$zans' where hfid=$id");
       
        echo '点赞成功';
        
    }else{
        echo '点赞失败';
    }
	
}
function hfjzan($id){
    $link = mysqli_connect('localhost','数据库名','数据库密码','数据库名');
    if(!$link){
        exit('连接失败！');
    }
    $res = mysqli_query($link,"select * from hf where hfid like '$id'");
    if($res){
        $fh=[];
        while ($row = mysqli_fetch_array($res)){
            
            array_unshift($fh, $row);
            
        }
        $zans = $fh[0]['zan']-1;
        mysqli_query($link,"UPDATE hf set zan='$zans' where hfid=$id");
       
        echo '点赞成功';
        
    }else{
        echo '点赞失败';
    }
	
}
function schf($id){
    $link = mysqli_connect('localhost','数据库名','数据库密码','数据库名');
    if(!$link){
        exit('连接失败！');
    }
    $res = mysqli_query($link,"select * from hf where hfid like '$id'");
    if($res){
        
        mysqli_query($link,"delete from hf where hfid = $id");
       
        echo '删除成功';
        
    }else{
        echo '删除失败';
    }
}
function sc($id){
    $link = mysqli_connect('localhost','数据库名','数据库密码','数据库名');
    if(!$link){
        exit('连接失败！');
    }
    $res = mysqli_query($link,"select * from xly where id like '$id'");
    if($res){
        
        mysqli_query($link,"delete from xly where id = $id");
       
        echo '删除成功';
        
    }else{
        echo '删除失败';
    }
}


function sortArrByManyField(){
  $args = func_get_args(); // 获取函数的参数的数组
  if(empty($args)){
    return null;
  }
  $arr = array_shift($args);
  if(!is_array($arr)){
    throw new Exception("第一个参数不为数组");
  }
  foreach($args as $key => $field){
    if(is_string($field)){
      $temp = array();
      foreach($arr as $index=> $val){
        $temp[$index] = $val[$field];
      }
      $args[$key] = $temp;
    }
  }
  $args[] = &$arr;//引用值
  call_user_func_array('array_multisort',$args);
  return array_pop($args);
}
function zhuan($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        return $arr = json_decode($result,true);
    }