<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProveedoresModel extends CI_Model{

    function obtenerProvedores(){
        $query = $this->db->query("select pro.idproveedor, pro.nombre, pro.ciudad, pro.estado, pro.telefono, pro.con_nombre, pro.con_email, pro.con_telefono, pro.con_extension, pro.active, pro.fecha_creacion, u1.nombre as 'nombre_usuario_peticion', tp.nombre as 'nombre_tipo', u2.nombre as 'nombre_usuario_autorizo'
        from proveedores pro 
        left join tipo_proveedor tp on tp.idtipo_proveedor = pro.fk_tipo
        left join usuarios u1 on u1.idusuario = pro.fk_usuario_prove
        left join usuarios u2 on u2.idusuario = pro.fk_usuario_aut");

        return $query->result();
    }

    function obtenerProveedoresBusqueda(){
        $query = $this->db->query("select pro.idproveedor, pro.nombre, pro.ciudad, pro.estado, pro.telefono, pro.con_nombre, pro.con_email,
        pro.con_telefono, pro.con_extension, tp.nombre as 'nombre_tipo'
        from proveedores pro 
        left join tipo_proveedor tp on tp.idtipo_proveedor = pro.fk_tipo
        left join usuarios u1 on u1.idusuario = pro.fk_usuario_prove
        left join usuarios u2 on u2.idusuario = pro.fk_usuario_aut
        where pro.active = 1");
        return $query->result();
    }

    function searchProveedor($cond){
        $query = $this->db->query("select pro.idproveedor, pro.nombre, pro.ciudad, pro.estado, pro.telefono, pro.con_nombre, pro.con_email,
        pro.con_telefono, pro.con_extension, tp.nombre as 'nombre_tipo'
        from proveedores pro 
        left join tipo_proveedor tp on tp.idtipo_proveedor = pro.fk_tipo
        left join usuarios u1 on u1.idusuario = pro.fk_usuario_prove
        left join usuarios u2 on u2.idusuario = pro.fk_usuario_aut
        where pro.nombre LIKE '%".$cond."%' && pro.active = 1;");

        return $query->result();
    }

    function getProveedores(){
        $this->db->select('idproveedor, nombre');
        $this->db->where('active', 1);
        
        return $this->db->get('proveedores')->result();
    }

    function agregarProveedor($data){

        return $this->db->insert('proveedores', $data);

    }

    function eliminarProveedor($id){
        $this->db->set('active', 0);
        $this->db->where('idproveedor', $id);
        $query = $this->db->update('proveedores');
        // $query = $this->db->delete('tipo_proveedor');
        return $query;
    }

    function actualizarProveedor($id, $data){
        $this->db->set('nombre', $data['nombre']);
        $this->db->set('ciudad', $data['ciudad']);
        $this->db->set('estado', $data['estado']);
        $this->db->set('telefono', $data['telefono']);
        $this->db->set('con_nombre', $data['con_nombre']);
        $this->db->set('con_email', $data['con_email']);
        $this->db->set('con_telefono', $data['con_telefono']);
        $this->db->set('con_extension', $data['con_extension']);
        $this->db->set('active', $data['active']);
        $this->db->set('fk_tipo', $data['tipo']);
        $this->db->set('fk_usuario_prove', $this->session->userdata('id'));
        $this->db->set('fk_usuario_aut', $this->session->userdata('id'));

        $this->db->where('idproveedor', $id);

        return $this->db->update('proveedores');
        // $this->db->where('idtipo_proveedor', $id);
        // return $this->db->update('tipo_proveedor', $data);
    }

}