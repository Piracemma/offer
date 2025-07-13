<?php

namespace App\Models;

use MF\Model\Container;
use MF\Model\Model;

class whatsapp extends Model {

    public function salvarMensagem($nome_contato, $telefone, $mensagem, $data_hora) {

        $query = "INSERT INTO webhook_wpp(nome_contato, telefone, mensagem, data_hora, por_offer) VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $nome_contato);
        $stmt->bindValue(2, $telefone);
        $stmt->bindValue(3, $mensagem);
        $stmt->bindValue(4, $data_hora);
        $stmt->bindValue(5, false);
        $stmt-> execute();

    }

    public function buscarConversasDia() {

        $query = "SELECT * FROM webhook_wpp WHERE data_hora BETWEEN ? AND ? ORDER BY data_hora DESC";

        $data = date('Y-m-d');
        $data_inicio = '2023-10-25 00:00:00';
        $data_final = '2023-10-26 23:59:00';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $data_inicio);
        $stmt->bindValue(2,  $data_final);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function salvarMensagemOffer($nome_contato, $telefone, $mensagem, $data_hora) {

        $query = "INSERT INTO webhook_wpp(nome_contato, telefone, mensagem, data_hora, por_offer) VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $nome_contato);
        $stmt->bindValue(2, $telefone);
        $stmt->bindValue(3, $mensagem);
        $stmt->bindValue(4, $data_hora);
        $stmt->bindValue(5, true);
        $stmt-> execute();

    }

    public function buscarTelefoneUsuario($id_venda) {

        $query = 
        "SELECT u.telefone, v.motivo_cancelamento FROM vendas v
        INNER JOIN usuarios u ON v.id_usuario = u.id
        WHERE v.id = ?
        ";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(1, $id_venda);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);

    }

    public function buscarTelefoneVendedor($id_venda) {

        $query = 
        "SELECT u.telefone FROM vendas v
        INNER JOIN vendedores u ON v.id_vendedor = u.id
        WHERE v.id = ?
        ";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(1, $id_venda);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);

    }

    public function guiaEntregador($id_venda) {

        $query = "SELECT 
        v.id, v.total_compra, v.endereco as endereco_alternativo, v.observacao,
        ve.nome as nome_vendedor, ve.endereco as endereco_vendedor, ve.bairro as bairro_vendedor, ve.telefone as telefone_vendedor,
        u.nome as nome_usuario, u.endereco as endereco_usuario, u.referencia, u.bairro as bairro_usuario, u.telefone as telefone_usuario,
        f.finalizadora
        FROM vendas AS v
        INNER JOIN vendedores ve on v.id_vendedor = ve.id
        INNER JOIN finalizadoras f on v.id_finalizadora = f.id
        INNER JOIN usuarios u on v.id_usuario = u.id
		WHERE v.id = ? ";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(1, $id_venda);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);

    }

}