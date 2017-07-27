<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends CI_Controller {
    
      function add(){
          $this->load->model('product_m');
          $query = $this->product_m->get($this->input->post('id'));
          print_r($query);
         // print_r($this->input->post('id'));
         $data = array(
            'id' => $this->input->post('id'),
              'name'     =>$query->pname,
              'qty'      => 1,
              'price'    =>$query->pprice
          );
          $this->cart->insert($data);
          redirect('order/add');
          
      }
      
      function show(){
          $cart = $this->cart->contents();
          echo '<pre>';
          print_r($cart);
      }
      
      function plus(){
 /*         if ($this->uri->segment(3) === FALSE)
{
    $product_id = 0;
}
else
{
    $product_id = $this->uri->segment(3);
}*/
          
          $qty = (int)$this->uri->segment(4)+1;
          $data = array(
              'rowid' => $this->uri->segment(3),
              'qty' => $qty
          );
          $this->cart->update($data);        
          redirect('order/add');
      }
      function mines(){
 /*         if ($this->uri->segment(3) === FALSE)
{
    $product_id = 0;
}
else
{
    $product_id = $this->uri->segment(3);
}*/
          
          $qty = (int)$this->uri->segment(4)-1;
          $data = array(
              'rowid' => $this->uri->segment(3),
              'qty' => $qty
          );
          $this->cart->update($data);        
          redirect('order/add');
      }
      
      function update(){
          $rowid = $this->input->post('v_rowid');
          $qty = $this->input->post('v_cartqty');
          $price = $this->input->post('v_cartprice');
          $data = array(
              'rowid' =>$rowid,
              'qty'   =>$qty,
              'price' =>$price,
              'name' =>'$qty*$price'
                  );          
                  //print_r($data);
          $this->cart->update($data);
          $data = $this->cart->contents();
          redirect('order/add');
      }
      
      function total(){
          $this->cart->total();          
      }
      
      function remove(){
          $data =array(
             'rowid' => $this->uri->segment(3),
              'qty' => 0
          );
          $this->cart->update($data);
           redirect('order/add');
          
      }
      
      function destroy(){
          $this->cart->destroy();
      }
    
}

