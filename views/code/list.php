<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>列表</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" rev="stylesheet" href="<?php echo base_url() ?>css/global.css" type="text/css"
        media="all" />

 <script type="text/javascript" src="<?php echo base_url()?>scripts/jquery.js"></script>

    <script type="text/javascript" src="../scripts/global.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#btnmdl").click(function(){
                var tablename = $("#table").val();
                //alert(tablename);
                var request = $.ajax({
                url: "<?php echo base_url()?>code/getmodel",
                //url: "<?php echo base_url()?>ajax/getproductbydescription",
                type: "POST",
                data: { tablename : tablename},
                cache: false,
                dataType: "html"
                });
                
                request.done(function(msg){                   
                     var obj = eval ("(" + msg+ ")");
                      var output = "";
                        output += "&lt;?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); <br>";
                        output += "class "+ tablename.substring(0,1).toUpperCase()+tablename.substring(1)+"_m extends CI_Model{ <br><br>";
                        output += "    function __construct() { <br>        parent::__construct(); <br>        $this->load->database(); <br>    } <br><br>";
                        output += "    function insert($arr){ <br>        $this->db->insert('"+tablename+"',$arr); <br>        }<br>  <br>  ";
                        output += "    function update($id,$arr){ <br>        $this->db->where('id',$id); <br>         $this->db->update('"+tablename+"',$arr); <br>    }<br><br>";
                        output += "    function delete($id){  <br>       $this->db->where('id',$id);    <br>     $this->db->delete('"+tablename+"'); <br>    }<br><br>";
                        output +="    function get($id){ <br>        $this->db->where('id',$id);<br>        $this->db->select('*');<br>        $query = $this->db->get('"+tablename+"');<br>        $query1 = $query->result();<br>        return $query1[0];<br>    }<br><br>";
                        output += "   function getall(){<br>        $this->db->select('*');<br>        $this->db->order_by('id','asc'); <br>        $query = $this->db->get('"+tablename+"'); <br>        return $query->result(); <br>    }<br><br>" ;
        
        
                        output += " function AssembleData(){<br>"; 

                       
                    if(obj.length>0){
                       
                        var temp = "$arr = array(<br>";
                        var j = 0;
                        for(i=0 ; i<obj.length;i++){                                
                            if(obj[i].primary_key == 0){
                                 if(j==0)
                                 {
                                     j =1 ;
                                 }
                                 else{
                                     temp +=",<br>";
                                 }
                                 temp += "'"+obj[i].name+"' => $" +obj[i].name+"";
                                 output= output + "$"+obj[i].name+ " = $_POST['v_"+obj[i].name+"'];<br>";
                            }else{
                                
                                
                            }
                           
                           //output= output + "$"+obj[i].name+ " = $_POST['v_"+obj[i].name+"'];<br>"; //$("#palproduct").append("<a href='#' class='productitem'>"+obj[i].name+"</a> &nbsp; &nbsp; &nbsp; &nbsp;");
                            //temp += "'"+obj[i].name+"' => $" +obj[i].name+"";
                        }
                        temp += ");<br> return $arr; <br>} <br><br>";
                        
                    }
                     output = output + temp+ "}";
                      $('#aa1').append(output);
                });
                
                request.fail(function( jqXHR, textStatus ) {
                alert( "Request failed: " + textStatus );
                });
            });
        });
        
    </script>

</head>
<body>
    <h3 id="aa1">管理</h3>
   <?php 
   echo form_dropdown('table',$options,'','id="table"' );   
   ?>
   <?php echo form_button('btn', '生成 model','id="btnmdl"') ?>
    
    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</body>
</html>
