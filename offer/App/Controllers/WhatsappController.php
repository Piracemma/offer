<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class WhatsappController extends Action {

    public function __get($atributo) {

        return $this->$atributo;

    }

    public function __set($atributo, $valor) {

        $this->$atributo = $valor;

        return $this;

    }

    public function webHook() {

        if(isset($_REQUEST['hub_challenge']) && isset($_REQUEST['hub_verify_token']) && isset($_REQUEST['hub_mode']) && $_REQUEST['hub_mode'] == 'subscribe') {

            $hubChallenge = $_REQUEST['hub_challenge'];

            $hunToken = $_REQUEST['hub_verify_token'];

            $token = $this->__get('token');

            if($hunToken == $token) {

                echo $hubChallenge;

            } else {

                echo 'Invalid Token';

            }


        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $postData = file_get_contents('php://input');
            
            $data = json_decode($postData, true);
        
            if ($data && isset($data['entry'][0]['changes'][0]['value']['contacts'][0]['profile']['name']) && isset($data['entry'][0]['changes'][0]['value']['messages'][0]['from']) && isset($data['entry'][0]['changes'][0]['value']['messages'][0]['text']['body']) && isset($data['entry'][0]['changes'][0]['value']['messages'][0]['timestamp'])) {

                $nome_contato = htmlspecialchars($data['entry'][0]['changes'][0]['value']['contacts'][0]['profile']['name'], ENT_QUOTES, 'UTF-8');

                $telefone = $data['entry'][0]['changes'][0]['value']['messages'][0]['from'];
    
                $mensagem = htmlspecialchars($data['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'], ENT_QUOTES, 'UTF-8');
    
                $date = new \DateTime();
                $timestamp = $data['entry'][0]['changes'][0]['value']['messages'][0]['timestamp'];
                $date->setTimestamp($timestamp);
                $data_hora =  $date->format('Y-m-d H:i:s');
    
                $enviar = Container::getModel('Whatsapp');
    
                $enviar->salvarMensagem($nome_contato, $telefone, $mensagem, $data_hora);

            }

        }

    }

    public function whatsappAdm() {

        session_start();

        if(!isset($_SESSION['id']) || $_SESSION['id'] != 1 || $_SESSION['nome'] != 'Matheus Rodrigues') {

            header("Location: /");
            die();

        }

        $mensagens = Container::getModel('Whatsapp');
        $mensagens_dia = $mensagens->buscarConversasDia();

        $organizar_mensagens = array();

        foreach($mensagens_dia as $mensagem) {

            if(!empty($organizar_mensagens)) {

                $telefone_existe = false;

                foreach($organizar_mensagens as $key => $contato) {

                    if($mensagem['telefone'] == $contato['telefone']) {

                        $telefone_existe = true;

                        $organizar_mensagens[$key]['mensagens'][] =  array(
                            'mensagem' => $mensagem['mensagem'],
                            'data_hora' => $mensagem['data_hora'],
                            'por_offer' => $mensagem['por_offer']
                        );

                    }

                }

                if(!$telefone_existe) {

                    $organizar_mensagens[] = array(
                        'nome_contato' => $mensagem['nome_contato'],
                        'telefone' => $mensagem['telefone'],
                        'mensagens' => array(
                            array(
                                'mensagem' => $mensagem['mensagem'],
                                'data_hora' => $mensagem['data_hora'],
                                'por_offer' => $mensagem['por_offer']
                            )
                        )
                    );

                }

            } else {

                $organizar_mensagens[] = array(
                    'nome_contato' => $mensagem['nome_contato'],
                    'telefone' => $mensagem['telefone'],
                    'mensagens' => array(
                        array(
                            'mensagem' => $mensagem['mensagem'],
                            'data_hora' => $mensagem['data_hora'],
                            'por_offer' => $mensagem['por_offer']
                        )
                    )
                );

            }

        }

        $this->view->mensagens = $organizar_mensagens;

        $this->render('whatsapp_adm');

    }

    public function enviarMensagem() {

        session_start();

        if(!isset($_SESSION['id']) || $_SESSION['id'] != 1 || $_SESSION['nome'] != 'Matheus Rodrigues') {

            header("Location: /");
            die();

        }

        if(isset($_GET['telefone'])) {

            if(isset($_POST['mensagem']) && !empty($_POST['mensagem'])) {

                $telefone = htmlspecialchars($_GET['telefone'], ENT_QUOTES, 'UTF-8');
                $mensagem = htmlspecialchars($_POST['mensagem'], ENT_QUOTES, 'UTF-8');
                
                $authorization = 'Authorization: Bearer '.TOKEN_USER_WPP;

                $ch = curl_init();
                $headers = array(
                    $authorization,
                    'Content-Type: application/json'
                );

                $data = array(
                    'messaging_product' => 'whatsapp',
                    'recipient_type' => 'individual',
                    'to' => $telefone,
                    'type' => 'text',
                    'text' => array(
                        'body' => $mensagem
                    )
                );

                curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v18.0/134922979711915/messages');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

                $response = curl_exec($ch);

                if (curl_errno($ch)) {
                    header("Location: /whatsapp_adm?mensagem=erro");
                    die();
                }

                curl_close($ch);

                $decode_response =  json_decode($response, true);

                if(!isset($decode_response['error'])) {
                    $data = date('Y-m-d H:i:s');
                    $nome_offer = $_GET['nome'];

                    $enviar = Container::getModel('Whatsapp');

                    $enviar_mensagem_bd = $enviar->salvarMensagemOffer($nome_offer, $telefone, $mensagem, $data);


                    header("Location: /whatsapp_adm?mensagem=enviada");
                    die();
                } else {
                    header("Location: /whatsapp_adm?mensagem=erro");
                    die();
                }

            }

        }

    }

    public static function enviarModelo($modelo, $id_venda) {

        $modelos = [
            'guia_entregador' => 'guia_entregador',
            'aviso_cliente_recusado' => 'aviso_cliente_recusado',
            'aviso_cliente_aceito' => 'aviso_cliente_aceito',
            'aviso_venda_vendedor' => 'aviso_venda_vendedor',
        ];

        $telefone = '';
        $parametros = array();

        $venda = Container::getModel('Whatsapp');

        if($modelos[$modelo] == 'aviso_cliente_aceito') {

            $dados = $venda->buscarTelefoneUsuario($id_venda);

            $telefone = '55'.$dados['telefone'];

            $parametros = array(
                array(
                    'type' => 'text',
                    'text' => $id_venda
                ),
            );

        } else if($modelos[$modelo] == 'aviso_cliente_recusado') {
            
            $dados = $venda->buscarTelefoneUsuario($id_venda);

            $telefone = '55'.$dados['telefone'];

            $parametros = array(
                array(
                    'type' => 'text',
                    'text' => $id_venda
                ),
                array(
                    'type' => 'text',
                    'text' => $dados['motivo_cancelamento']
                ),
            );

        } else if($modelos[$modelo] == 'aviso_venda_vendedor') {

            $number = $venda->buscarTelefoneVendedor($id_venda);
            $telefone = '55'. $number['telefone'];

            $parametros = array(
                array(
                    'type' => 'text',
                    'text' => $id_venda
                ),
            );

        } else if($modelos[$modelo] == 'guia_entregador') {

            $telefone = TEL_ENTREGADOR_CASSIA;

            $dados = $venda->guiaEntregador($id_venda);

            $endereco = $dados['endereco_usuario'];

            $endereco_referencia = $endereco;

            $bairro = $dados['bairro_usuario'];

            $pagamento = ucfirst($dados['finalizadora']);

            if(!empty($dados['endereco_alternativo'])) {

                $endereco_referencia = $dados['endereco_alternativo'];

                $bairro = 'N/C';

            } else if(!empty($dados['referencia'])) {

                $endereco_referencia = $endereco.' - '.$dados['referencia'];

            }

            if(!empty($dados['observacao'])) {

                $pagamento = $dados['finalizadora'].' - Observação: '.$dados['observacao'];

            }

            $valor_compra = $dados['total_compra'];
            $valor_compra_format = 'R$'.number_format($valor_compra, 2, ',', '');

            $parametros = array(
                array(
                    'type' => 'text',
                    'text' => $dados['id']
                ),
                array(
                    'type' => 'text',
                    'text' => $dados['nome_vendedor']
                ),
                array(
                    'type' => 'text',
                    'text' => $dados['endereco_vendedor']
                ),
                array(
                    'type' => 'text',
                    'text' => $dados['bairro_vendedor']
                ),
                array(
                    'type' => 'text',
                    'text' => $dados['telefone_vendedor']
                ),
                array(
                    'type' => 'text',
                    'text' => $dados['nome_usuario']
                ),
                array(
                    'type' => 'text',
                    'text' => $endereco_referencia
                ),
                array(
                    'type' => 'text',
                    'text' => $bairro
                ),
                array(
                    'type' => 'text',
                    'text' => (string) $dados['telefone_usuario']
                ),
                array(
                    'type' => 'text',
                    'text' => $valor_compra_format
                ),
                array(
                    'type' => 'text',
                    'text' => $pagamento
                ),
            );

        }
                
        $authorization = 'Authorization: Bearer '.TOKEN_USER_WPP;

        $ch = curl_init();
        $headers = array(
            $authorization,
            'Content-Type: application/json'
        );

        $data = array(
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $telefone,
            'type' => 'template',
            'template' => array(
                'name' => $modelos[$modelo],
                'language' => array(
                    'code' => 'pt_BR'
                ),
                'components' => array(
                    array(
                        'type' => 'body',
                        'parameters' => $parametros
                    )
                )
            )
        );

        curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v18.0/134922979711915/messages');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            //logica para salvar e verificar o erro
            die();
        }

        curl_close($ch);

        $decode_response =  json_decode($response, true);

        if(!isset($decode_response['error'])) {
           
            //talves fazer nada mas ver certinho

        } else {

            //logica para salvar e verificar o erro salvando o modelo que foi tentato enviar
            die();

        }


    }

}