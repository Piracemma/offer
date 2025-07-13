<?php

namespace App\Controllers;

//os recursos do miniframework

use App\Models\Usuario;
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

	public function index() {

		Action::ativarSessao();

		if(!isset($_SESSION['id']) || empty($_SESSION['id']) || !isset($_SESSION['nome']) || empty($_SESSION['nome'])) {

			$this->render('index','layout2');

		} else if($_SESSION['tipo_usuario'] == 1) {			

			$this->notificarVendas();

			$this->view->pagina = 'inicio';

			$produtos = Container::getModel('Produto');
			$this->view->novidades = $produtos->novidades();
			$this->view->destaques = $produtos->destaques();

			$this->render('app');

		} else if($_SESSION['tipo_usuario'] == 2) {

			header("Location: /vendedor");

		}
		
	}

	public function login() {

		$this->render('login','layout2');
		
	}

	public function cadastreSe() {

		$this->render('cadastre_se','layout2');

	}
	
	public function registrarVendedor() {

		if(isset($_POST) && isset($_POST['aceita-termos']) && $_POST['aceita-termos'] == 'sim') {
		
			$padrao = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#\/])[A-Za-z\d@$!%*?&#\/]{8,20}$/';
			$senha = htmlspecialchars($_POST['senha'], ENT_QUOTES, 'UTF-8');
			$validasenha = htmlspecialchars($_POST['validasenha'],ENT_QUOTES, 'UTF-8');

			if (preg_match($padrao, $senha) && $senha == $validasenha && strlen($senha) >= 8) {
				
				if(isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {

					$temporario = $_FILES['imagem']['tmp_name'];
					
					$nomeArquivoArray = explode('.',$_FILES['imagem']['name']);

					if(isset($nomeArquivoArray[1])){
						if(preg_match('/^(jpeg|png|jpg)$/', end($nomeArquivoArray))) {
							
							$valida_tipo = getimagesize($temporario);

							$width = (float) $valida_tipo[0];

							$height = (float) $valida_tipo[1];
							
							$proporcao = $width / $height;

							if($proporcao > 1.03 || $proporcao < 0.97) {
								header("Location: /cadastre_se?erro=erro_imagem");
								die();
							}
				
							if($valida_tipo != false && isset($valida_tipo['mime'])){
				
								if(preg_match('/^image\/(jpeg|png)$/', $valida_tipo['mime'])){


									$senhacod = password_hash($senha,PASSWORD_DEFAULT);

									//caso senha valida adiciona os registros
									$nome = htmlspecialchars($_POST['nome'], ENT_QUOTES, 'UTF-8');
									$emailfiltro = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
									$email = filter_var($emailfiltro, FILTER_VALIDATE_EMAIL);
									$documento = htmlspecialchars($_POST['documento'], ENT_QUOTES, 'UTF-8');
									$cidade = htmlspecialchars($_POST['cidade'], ENT_QUOTES, 'UTF-8');
									$endereco = htmlspecialchars($_POST['endereco'], ENT_QUOTES, 'UTF-8');
									$bairro = htmlspecialchars($_POST['bairro'], ENT_QUOTES, 'UTF-8');
									$telefone = htmlspecialchars($_POST['telefone'], ENT_QUOTES, 'UTF-8');
									$segmento = htmlspecialchars($_POST['segmento'], ENT_QUOTES, 'UTF-8');
									$sobrenos = htmlspecialchars($_POST['sobrenos'], ENT_QUOTES, 'UTF-8');


									//Horarios de Funcionamento
									$segunda_nao = isset($_POST['segunda-nao']) && $_POST['segunda-nao'] == 'segunda-nao' ? true : false; 
									$segunda_de = null;
									$segunda_ate = null;
									if($segunda_nao) {
										$segunda_de = null;
										$segunda_ate = null;
									} else {
										$segunda_de = htmlspecialchars($_POST['segunda-de'], ENT_QUOTES, 'UTF-8');
										$segunda_ate = htmlspecialchars($_POST['segunda-ate'], ENT_QUOTES, 'UTF-8');
									}

									$terca_nao = isset($_POST['terca-nao']) && $_POST['terca-nao'] == 'terca-nao' ? true : false; 
									$terca_de = null;
									$terca_ate = null;
									if($terca_nao) {
										$terca_de = null;
										$terca_ate = null;
									} else {
										$terca_de = htmlspecialchars($_POST['terca-de'], ENT_QUOTES, 'UTF-8');
										$terca_ate = htmlspecialchars($_POST['terca-ate'], ENT_QUOTES, 'UTF-8');
									}

									$quarta_nao = isset($_POST['quarta-nao']) && $_POST['quarta-nao'] == 'quarta-nao' ? true : false; 
									$quarta_de = null;
									$quarta_ate = null;
									if($quarta_nao) {
										$quarta_de = null;
										$quarta_ate = null;
									} else {
										$quarta_de = htmlspecialchars($_POST['quarta-de'], ENT_QUOTES, 'UTF-8');
										$quarta_ate = htmlspecialchars($_POST['quarta-ate'], ENT_QUOTES, 'UTF-8');
									}

									$quinta_nao = isset($_POST['quinta-nao']) && $_POST['quinta-nao'] == 'quinta-nao' ? true : false; 
									$quinta_de = null;
									$quinta_ate = null;
									if($quinta_nao) {
										$quinta_de = null;
										$quinta_ate = null;
									} else {
										$quinta_de = htmlspecialchars($_POST['quinta-de'], ENT_QUOTES, 'UTF-8');
										$quinta_ate = htmlspecialchars($_POST['quinta-ate'], ENT_QUOTES, 'UTF-8');
									}

									$sexta_nao = isset($_POST['sexta-nao']) && $_POST['sexta-nao'] == 'sexta-nao' ? true : false; 
									$sexta_de = null;
									$sexta_ate = null;
									if($sexta_nao) {
										$sexta_de = null;
										$sexta_ate = null;
									} else {
										$sexta_de = htmlspecialchars($_POST['sexta-de'], ENT_QUOTES, 'UTF-8');
										$sexta_ate = htmlspecialchars($_POST['sexta-ate'], ENT_QUOTES, 'UTF-8');
									}

									$sabado_nao = isset($_POST['sabado-nao']) && $_POST['sabado-nao'] == 'sabado-nao' ? true : false; 
									$sabado_de = null;
									$sabado_ate = null;
									if($sabado_nao) {
										$sabado_de = null;
										$sabado_ate = null;
									} else {
										$sabado_de = htmlspecialchars($_POST['sabado-de'], ENT_QUOTES, 'UTF-8');
										$sabado_ate = htmlspecialchars($_POST['sabado-ate'], ENT_QUOTES, 'UTF-8');
									}

									$domingo_nao = isset($_POST['domingo-nao']) && $_POST['domingo-nao'] == 'domingo-nao' ? true : false; 
									$domingo_de = null;
									$domingo_ate = null;
									if($domingo_nao) {
										$domingo_de = null;
										$domingo_ate = null;
									} else {
										$domingo_de = htmlspecialchars($_POST['domingo-de'], ENT_QUOTES, 'UTF-8');
										$domingo_ate = htmlspecialchars($_POST['domingo-ate'], ENT_QUOTES, 'UTF-8');
									}
									
									$dias_funcionamento = array(
										'segunda' => array(
											'de' => $segunda_de,
											'ate' => $segunda_ate
										),
										'terca' => array(
											'de' => $terca_de,
											'ate' => $terca_ate
										),
										'quarta' => array(
											'de' => $quarta_de,
											'ate' => $quarta_ate
										),
										'quinta' => array(
											'de' => $quinta_de,
											'ate' => $quinta_ate
										),
										'sexta' => array(
											'de' => $sexta_de,
											'ate' => $sexta_ate
										),
										'sabado' => array(
											'de' => $sabado_de,
											'ate' => $sabado_ate
										),
										'domingo' => array(
											'de' => $domingo_de,
											'ate' => $domingo_ate
										),
									);
									//Horarios de Funcionamento


									if($_POST['entrega_propria'] == 's') {

										$possui_entrega = true;

										$limpavalorentrega = htmlspecialchars($_POST['valor_entrega'], ENT_QUOTES, 'UTF-8');
										$corrigePonto = explode(',',$limpavalorentrega);
										$valor_entrega = implode('.', $corrigePonto);

									} else if ($_POST['entrega_propria'] == 'n') {

										$possui_entrega = false;
										$valor_entrega = '0.00';

									} else {
							
										$this->render('cadastre_se','layout2');
										die();

									}

									//imagem
									$foto_perfil = time().'-'.rand(111111111, 999999999).'.'.end($nomeArquivoArray);
									$foto_caminho = 'img/vendedor/';
									$local = $foto_caminho . $foto_perfil;
									//fim imagem
										
									$vendedor = Container::getModel('Vendedor');
									
									$vendedor->__set('nome', $nome)->__set('email', $email)->__set('senha', $senhacod)->__set('validasenha', $validasenha)->__set('documento', $documento)->__set('cidade', $cidade)->__set('endereco', $endereco)->__set('bairro', $bairro)->__set('telefone', $telefone)->__set('segmento', $segmento)->__set('sobrenos', $sobrenos)->__set('foto_caminho', $foto_caminho)->__set('foto_perfil', $foto_perfil)->__set('possui_entrega', $possui_entrega)->__set('valor_entrega', $valor_entrega);

									if($vendedor->validarCadastro() && $vendedor->getPorEmail() == false) {

										if($vendedor->validarCidade()) {
							
											if(move_uploaded_file($temporario,$local)) {

												$codigo_verificacao = rand(111111,999999);

												$codigo_hash = password_hash($codigo_verificacao, PASSWORD_DEFAULT);

												$enviado = $this->enviarEmail('validar_email', $email, $codigo_verificacao);

												if($enviado) {
													
													session_start();
													
													$_SESSION['nome'] = $nome;
													$_SESSION['email'] = $email;
													$_SESSION['senha'] = $senhacod;
													$_SESSION['validasenha'] = $validasenha;
													$_SESSION['documento'] = $documento;
													$_SESSION['cidade'] = $cidade;
													$_SESSION['endereco'] = $endereco;
													$_SESSION['bairro'] = $bairro;
													$_SESSION['telefone'] = $telefone;
													$_SESSION['segmento'] = $segmento;
													$_SESSION['sobrenos'] = $sobrenos;
													$_SESSION['foto_caminho'] = $foto_caminho;
													$_SESSION['foto_perfil'] = $foto_perfil;
													$_SESSION['possui_entrega'] = $possui_entrega;
													$_SESSION['valor_entrega'] = $valor_entrega;
													$_SESSION['valida_tipo_usuario'] = 2;
													$_SESSION['horario_funcionamento'] = $dias_funcionamento;

													setcookie('validar_email', $codigo_hash, COOKIE_OPTIONS_TEMP);

													header("Location: /codigo_verificador");
													die();

												}

											} else {

												$this->view->vendedor = array(
													'nome' => htmlspecialchars($_POST['nome'], ENT_QUOTES, 'UTF-8'),
													'email' => filter_var($_POST['email'], FILTER_VALIDATE_EMAIL),
													'documento' => htmlspecialchars($_POST['documento'], ENT_QUOTES, 'UTF-8'),
													'endereco' => htmlspecialchars($_POST['endereco'], ENT_QUOTES, 'UTF-8'),
													'bairro' => htmlspecialchars($_POST['bairro'], ENT_QUOTES, 'UTF-8'),
													'telefone' => htmlspecialchars($_POST['telefone'], ENT_QUOTES, 'UTF-8'),
													'cidade' => htmlspecialchars($_POST['cidade'], ENT_QUOTES, 'UTF-8'),
													'entrega_propria' => htmlspecialchars($_POST['entrega_propria'], ENT_QUOTES, 'UTF-8'),
													'valor_entrega' => htmlspecialchars($_POST['valor_entrega'], ENT_QUOTES, 'UTF-8'),
													'segmento' => htmlspecialchars($_POST['segmento'], ENT_QUOTES, 'UTF-8'),
													'sobrenos' => htmlspecialchars($_POST['sobrenos'], ENT_QUOTES, 'UTF-8'),
													'erro' => 'imagem1',
												);
									
												$this->render('cadastre_se','layout2');
												die();

											}                                    

										} else {

											$this->view->vendedor = array(
												'nome' => htmlspecialchars($_POST['nome'], ENT_QUOTES, 'UTF-8'),
												'email' => filter_var($_POST['email'], FILTER_VALIDATE_EMAIL),
												'documento' => htmlspecialchars($_POST['documento'], ENT_QUOTES, 'UTF-8'),
												'endereco' => htmlspecialchars($_POST['endereco'], ENT_QUOTES, 'UTF-8'),
												'bairro' => htmlspecialchars($_POST['bairro'], ENT_QUOTES, 'UTF-8'),
												'telefone' => htmlspecialchars($_POST['telefone'], ENT_QUOTES, 'UTF-8'),
												'cidade' => htmlspecialchars($_POST['cidade'], ENT_QUOTES, 'UTF-8'),
												'entrega_propria' => htmlspecialchars($_POST['entrega_propria'], ENT_QUOTES, 'UTF-8'),
												'valor_entrega' => htmlspecialchars($_POST['valor_entrega'], ENT_QUOTES, 'UTF-8'),
												'segmento' => htmlspecialchars($_POST['segmento'], ENT_QUOTES, 'UTF-8'),
												'sobrenos' => htmlspecialchars($_POST['sobrenos'], ENT_QUOTES, 'UTF-8'),
												'erro' => 'erro',
											);
								
											$this->render('cadastre_se','layout2');
											die();

										}			

									} else {

										$this->view->vendedor = array(
											'nome' => htmlspecialchars($_POST['nome'], ENT_QUOTES, 'UTF-8'),
											'email' => filter_var($_POST['email'], FILTER_VALIDATE_EMAIL),
											'documento' => htmlspecialchars($_POST['documento'], ENT_QUOTES, 'UTF-8'),
											'endereco' => htmlspecialchars($_POST['endereco'], ENT_QUOTES, 'UTF-8'),
											'bairro' => htmlspecialchars($_POST['bairro'], ENT_QUOTES, 'UTF-8'),
											'telefone' => htmlspecialchars($_POST['telefone'], ENT_QUOTES, 'UTF-8'),
											'cidade' => htmlspecialchars($_POST['cidade'], ENT_QUOTES, 'UTF-8'),
											'entrega_propria' => htmlspecialchars($_POST['entrega_propria'], ENT_QUOTES, 'UTF-8'),
											'valor_entrega' => htmlspecialchars($_POST['valor_entrega'], ENT_QUOTES, 'UTF-8'),
											'segmento' => htmlspecialchars($_POST['segmento'], ENT_QUOTES, 'UTF-8'),
											'sobrenos' => htmlspecialchars($_POST['sobrenos'], ENT_QUOTES, 'UTF-8'),
											'erro' => 'usuarioexistente'
										);
							
										$this->render('cadastre_se','layout2');
										die();

									}                            
				
								} else {
				
									$this->view->vendedor = array(
										'nome' => htmlspecialchars($_POST['nome'], ENT_QUOTES, 'UTF-8'),
										'email' => filter_var($_POST['email'], FILTER_VALIDATE_EMAIL),
										'documento' => htmlspecialchars($_POST['documento'], ENT_QUOTES, 'UTF-8'),
										'endereco' => htmlspecialchars($_POST['endereco'], ENT_QUOTES, 'UTF-8'),
										'bairro' => htmlspecialchars($_POST['bairro'], ENT_QUOTES, 'UTF-8'),
										'telefone' => htmlspecialchars($_POST['telefone'], ENT_QUOTES, 'UTF-8'),
										'cidade' => htmlspecialchars($_POST['cidade'], ENT_QUOTES, 'UTF-8'),
										'entrega_propria' => htmlspecialchars($_POST['entrega_propria'], ENT_QUOTES, 'UTF-8'),
										'valor_entrega' => htmlspecialchars($_POST['valor_entrega'], ENT_QUOTES, 'UTF-8'),
										'segmento' => htmlspecialchars($_POST['segmento'], ENT_QUOTES, 'UTF-8'),
										'sobrenos' => htmlspecialchars($_POST['sobrenos'], ENT_QUOTES, 'UTF-8'),
										'erro' => 'imagem2'
									);
						
									$this->render('cadastre_se','layout2');
									die();
				
								}
				
							} else {

								$this->view->vendedor = array(
									'nome' => htmlspecialchars($_POST['nome'], ENT_QUOTES, 'UTF-8'),
									'email' => filter_var($_POST['email'], FILTER_VALIDATE_EMAIL),
									'documento' => htmlspecialchars($_POST['documento'], ENT_QUOTES, 'UTF-8'),
									'endereco' => htmlspecialchars($_POST['endereco'], ENT_QUOTES, 'UTF-8'),
									'bairro' => htmlspecialchars($_POST['bairro'], ENT_QUOTES, 'UTF-8'),
									'telefone' => htmlspecialchars($_POST['telefone'], ENT_QUOTES, 'UTF-8'),
									'cidade' => htmlspecialchars($_POST['cidade'], ENT_QUOTES, 'UTF-8'),
									'entrega_propria' => htmlspecialchars($_POST['entrega_propria'], ENT_QUOTES, 'UTF-8'),
									'valor_entrega' => htmlspecialchars($_POST['valor_entrega'], ENT_QUOTES, 'UTF-8'),
									'segmento' => htmlspecialchars($_POST['segmento'], ENT_QUOTES, 'UTF-8'),
									'sobrenos' => htmlspecialchars($_POST['sobrenos'], ENT_QUOTES, 'UTF-8'),
									'erro' => 'imagem4'
								);
					
								$this->render('cadastre_se','layout2');
								die();
		
							}

						} else {

							$this->view->vendedor = array(
								'nome' => htmlspecialchars($_POST['nome'], ENT_QUOTES, 'UTF-8'),
								'email' => filter_var($_POST['email'], FILTER_VALIDATE_EMAIL),
								'documento' => htmlspecialchars($_POST['documento'], ENT_QUOTES, 'UTF-8'),
								'endereco' => htmlspecialchars($_POST['endereco'], ENT_QUOTES, 'UTF-8'),
								'bairro' => htmlspecialchars($_POST['bairro'], ENT_QUOTES, 'UTF-8'),
								'telefone' => htmlspecialchars($_POST['telefone'], ENT_QUOTES, 'UTF-8'),
								'cidade' => htmlspecialchars($_POST['cidade'], ENT_QUOTES, 'UTF-8'),
								'entrega_propria' => htmlspecialchars($_POST['entrega_propria'], ENT_QUOTES, 'UTF-8'),
								'valor_entrega' => htmlspecialchars($_POST['valor_entrega'], ENT_QUOTES, 'UTF-8'),
								'segmento' => htmlspecialchars($_POST['segmento'], ENT_QUOTES, 'UTF-8'),
								'sobrenos' => htmlspecialchars($_POST['sobrenos'], ENT_QUOTES, 'UTF-8'),
								'erro' => 'imagem5'
							);
				
							$this->render('cadastre_se','layout2');
							die();

						}

					}
					
				} else {

					$this->view->vendedor = array(
						'nome' => htmlspecialchars($_POST['nome'], ENT_QUOTES, 'UTF-8'),
						'email' => filter_var($_POST['email'], FILTER_VALIDATE_EMAIL),
						'documento' => htmlspecialchars($_POST['documento'], ENT_QUOTES, 'UTF-8'),
						'endereco' => htmlspecialchars($_POST['endereco'], ENT_QUOTES, 'UTF-8'),
						'bairro' => htmlspecialchars($_POST['bairro'], ENT_QUOTES, 'UTF-8'),
						'telefone' => htmlspecialchars($_POST['telefone'], ENT_QUOTES, 'UTF-8'),
						'cidade' => htmlspecialchars($_POST['cidade'], ENT_QUOTES, 'UTF-8'),
						'entrega_propria' => htmlspecialchars($_POST['entrega_propria'], ENT_QUOTES, 'UTF-8'),
						'valor_entrega' => htmlspecialchars($_POST['valor_entrega'], ENT_QUOTES, 'UTF-8'),
						'segmento' => htmlspecialchars($_POST['segmento'], ENT_QUOTES, 'UTF-8'),
						'sobrenos' => htmlspecialchars($_POST['sobrenos'], ENT_QUOTES, 'UTF-8'),
						'erro' => 'imagem'
					);
		
					$this->render('cadastre_se','layout2');
					die();

				}
			
			} else {

				$this->view->vendedor = array(
					'nome' => htmlspecialchars($_POST['nome'], ENT_QUOTES, 'UTF-8'),
					'email' => filter_var($_POST['email'], FILTER_VALIDATE_EMAIL),
					'documento' => htmlspecialchars($_POST['documento'], ENT_QUOTES, 'UTF-8'),
					'endereco' => htmlspecialchars($_POST['endereco'], ENT_QUOTES, 'UTF-8'),
					'bairro' => htmlspecialchars($_POST['bairro'], ENT_QUOTES, 'UTF-8'),
					'telefone' => htmlspecialchars($_POST['telefone'], ENT_QUOTES, 'UTF-8'),
					'cidade' => htmlspecialchars($_POST['cidade'], ENT_QUOTES, 'UTF-8'),
					'entrega_propria' => htmlspecialchars($_POST['entrega_propria'], ENT_QUOTES, 'UTF-8'),
					'valor_entrega' => htmlspecialchars($_POST['valor_entrega'], ENT_QUOTES, 'UTF-8'),
					'segmento' => htmlspecialchars($_POST['segmento'], ENT_QUOTES, 'UTF-8'),
					'sobrenos' => htmlspecialchars($_POST['sobrenos'], ENT_QUOTES, 'UTF-8'),
					'erro' => 'erro',
				);

				$this->render('cadastre_se','layout2');
				die();
			
			}

		} else {
			header("Location: /");
			die();
		}		
		
	}

	public function registrarUsuario() {
		
		if(isset($_POST) && isset($_POST['aceita-termos']) && $_POST['aceita-termos'] == 'sim') {
		
			//validar senha
			$padrao = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#\/])[A-Za-z\d@$!%*?&#\/]{8,20}$/';
			$senha = htmlspecialchars($_POST['senha'], ENT_QUOTES, 'UTF-8');
			$validasenha = htmlspecialchars($_POST['validasenha'],ENT_QUOTES, 'UTF-8');

			if (preg_match($padrao, $senha) && $senha == $validasenha && strlen($senha) >= 8) {
				
				$senhacod = password_hash($senha,PASSWORD_DEFAULT);

				//caso senha valida adiciona os registros
				$nome = htmlspecialchars($_POST['nome'], ENT_QUOTES, 'UTF-8');
				$emailfiltro = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
				$email = filter_var($emailfiltro, FILTER_VALIDATE_EMAIL);
				$documento = htmlspecialchars($_POST['documento'], ENT_QUOTES, 'UTF-8');
				$cidade = htmlspecialchars($_POST['cidade'], ENT_QUOTES, 'UTF-8');
				$endereco = htmlspecialchars($_POST['endereco'], ENT_QUOTES, 'UTF-8');
				$bairro = htmlspecialchars($_POST['bairro'], ENT_QUOTES, 'UTF-8');
				$end_referencia = htmlspecialchars($_POST['end_referencia'], ENT_QUOTES, 'UTF-8');
				$telefone = htmlspecialchars($_POST['telefone'], ENT_QUOTES, 'UTF-8');
					
				$usuario = Container::getModel('Usuario');
				
				$usuario->__set('nome', $nome)->__set('email', $email)->__set('senha', $senhacod)->__set('validasenha', $validasenha)->__set('documento', $documento)->__set('cidade', $cidade)->__set('endereco', $endereco)->__set('bairro', $bairro)->__set('end_referencia', $end_referencia)->__set('telefone', $telefone);

				if($usuario->validarCadastro() && $usuario->getPorEmail() == false) {

					if($usuario->validarCidade()) {

						$codigo_verificacao = rand(111111,999999);

						$codigo_hash = password_hash($codigo_verificacao, PASSWORD_DEFAULT);

						$enviado = $this->enviarEmail('validar_email', $email, $codigo_verificacao);

						if($enviado) {
							
							session_start();
							$_SESSION['nome'] = $nome;
							$_SESSION['email'] = $email;
							$_SESSION['senha'] = $senhacod;
							$_SESSION['validasenha'] = $validasenha;
							$_SESSION['documento'] = $documento;
							$_SESSION['cidade'] = $cidade;
							$_SESSION['endereco'] = $endereco;
							$_SESSION['bairro'] = $bairro;
							$_SESSION['end_referencia'] = $end_referencia;
							$_SESSION['telefone'] = $telefone;
							$_SESSION['valida_tipo_usuario'] = 1;

							setcookie('validar_email', $codigo_hash, COOKIE_OPTIONS_TEMP);

							header("Location: /codigo_verificador");
							die();

						} else {

							$this->view->usuario = array(
								'nome' => htmlspecialchars($_POST['nome'], ENT_QUOTES, 'UTF-8'),
								'email' => filter_var($_POST['email'], FILTER_VALIDATE_EMAIL),
								'documento' => htmlspecialchars($_POST['documento'], ENT_QUOTES, 'UTF-8'),
								'endereco' => htmlspecialchars($_POST['endereco'], ENT_QUOTES, 'UTF-8'),
								'bairro' => htmlspecialchars($_POST['bairro'], ENT_QUOTES, 'UTF-8'),
								'end_referencia' => htmlspecialchars($_POST['end_referencia'], ENT_QUOTES, 'UTF-8'),
								'telefone' => htmlspecialchars($_POST['telefone'], ENT_QUOTES, 'UTF-8'),
								'cidade' => htmlspecialchars($_POST['cidade'], ENT_QUOTES, 'UTF-8'),
								'erro' => 'erro',
							);
			
							$this->render('cadastre_se','layout2');
							die();

						}	
		
					} else {

						$this->view->usuario = array(
							'nome' => htmlspecialchars($_POST['nome'], ENT_QUOTES, 'UTF-8'),
							'email' => filter_var($_POST['email'], FILTER_VALIDATE_EMAIL),
							'documento' => htmlspecialchars($_POST['documento'], ENT_QUOTES, 'UTF-8'),
							'endereco' => htmlspecialchars($_POST['endereco'], ENT_QUOTES, 'UTF-8'),
							'bairro' => htmlspecialchars($_POST['bairro'], ENT_QUOTES, 'UTF-8'),
							'end_referencia' => htmlspecialchars($_POST['end_referencia'], ENT_QUOTES, 'UTF-8'),
							'telefone' => htmlspecialchars($_POST['telefone'], ENT_QUOTES, 'UTF-8'),
							'cidade' => htmlspecialchars($_POST['cidade'], ENT_QUOTES, 'UTF-8'),
							'erro' => 'erro',
						);
		
						$this->render('cadastre_se','layout2');
						die();
		
					}			
		
				} else {
		
					$this->view->usuario = array(
						'nome' => htmlspecialchars($_POST['nome'], ENT_QUOTES, 'UTF-8'),
						'email' => filter_var($_POST['email'], FILTER_VALIDATE_EMAIL),
						'documento' => htmlspecialchars($_POST['documento'], ENT_QUOTES, 'UTF-8'),
						'endereco' => htmlspecialchars($_POST['endereco'], ENT_QUOTES, 'UTF-8'),
						'bairro' => htmlspecialchars($_POST['bairro'], ENT_QUOTES, 'UTF-8'),
						'end_referencia' => htmlspecialchars($_POST['end_referencia'], ENT_QUOTES, 'UTF-8'),
						'telefone' => htmlspecialchars($_POST['telefone'], ENT_QUOTES, 'UTF-8'),
						'cidade' => htmlspecialchars($_POST['cidade'], ENT_QUOTES, 'UTF-8'),
						'erro' => 'usuarioexistente'
					);
		
					$this->render('cadastre_se','layout2');
					die();
		
				}

			} else {

				$this->view->usuario = array(
					'nome' => htmlspecialchars($_POST['nome'], ENT_QUOTES, 'UTF-8'),
					'email' => filter_var($_POST['email'], FILTER_VALIDATE_EMAIL),
					'documento' => htmlspecialchars($_POST['documento'], ENT_QUOTES, 'UTF-8'),
					'endereco' => htmlspecialchars($_POST['endereco'], ENT_QUOTES, 'UTF-8'),
					'bairro' => htmlspecialchars($_POST['bairro'], ENT_QUOTES, 'UTF-8'),
					'end_referencia' => htmlspecialchars($_POST['end_referencia'], ENT_QUOTES, 'UTF-8'),
					'telefone' => htmlspecialchars($_POST['telefone'], ENT_QUOTES, 'UTF-8'),
					'cidade' => htmlspecialchars($_POST['cidade'], ENT_QUOTES, 'UTF-8'),
					'erro' => 'erro',
				);

				$this->render('cadastre_se','layout2');
				die();

			}

		} else {
			header("Location: /");
			die();
		}

	}

	public function esqueciSenha() {

		$this->render('esqueci_senha','layout2');

	}

	public function recuperarSenha() {

		if(isset($_POST['email']) && !empty($_POST['email'])) {

			$email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');

			$encontrar_usuario = Container::getModel('Usuario');

			$existe = $encontrar_usuario->recuperarPorEmail($email);

			if($existe == false) {

				header("Location: /esqueci_senha?act=nao_encontrado");
				die();

			} else {            

				$codigo_verificacao = rand(111111,999999);

				$enviado = $this->enviarEmail('recuperar_senha', $email, $codigo_verificacao);

				if(!$enviado) {                    

					header("Location: /esqueci_senha?act=erro_enviar_email");
					die();

				} else {

					$id_usuario = $existe['id'];
					$tipo_usuario = $existe['tipo_usuario'];

					$cookie_codigo_verificador = password_hash($codigo_verificacao, PASSWORD_DEFAULT);

					setcookie('codigo_verificador', $cookie_codigo_verificador, COOKIE_OPTIONS_TEMP);

					setcookie('id_usuario', $id_usuario, COOKIE_OPTIONS_TEMP);

					setcookie('tipo_usuario', $tipo_usuario, COOKIE_OPTIONS_TEMP);

					header("Location: /codigo_verificador");

				}

			}

		}

	}

	public function codigoVerificador() {

		if(isset($_COOKIE['validar_email'])) {

			if(isset($_POST['codigo_verificador']) && !empty($_POST['codigo_verificador'])) {

				$validar_email = htmlspecialchars($_POST['codigo_verificador'], ENT_QUOTES, 'UTF-8');

				$codigo_hash = $_COOKIE['validar_email'];

				$valida_verificador = password_verify($validar_email, $codigo_hash);

				if($valida_verificador) {

					session_start();

					if(isset($_SESSION['valida_tipo_usuario'])) {

						if($_SESSION['valida_tipo_usuario'] == 1) {

							$usuario = Container::getModel('Usuario');

							$usuario->__set('nome', $_SESSION['nome'])->__set('email', $_SESSION['email'])->__set('senha', $_SESSION['senha'])->__set('validasenha', $_SESSION['validasenha'])->__set('documento', $_SESSION['documento'])->__set('cidade', $_SESSION['cidade'])->__set('endereco', $_SESSION['endereco'])->__set('bairro', $_SESSION['bairro'])->__set('end_referencia', $_SESSION['end_referencia'])->__set('telefone', $_SESSION['telefone']);
						
						}

						if($_SESSION['valida_tipo_usuario'] == 2) {

							$usuario = Container::getModel('Vendedor');
								
							$usuario->__set('nome', $_SESSION['nome'])->__set('email', $_SESSION['email'])->__set('senha', $_SESSION['senha'])->__set('validasenha', $_SESSION['validasenha'])->__set('documento', $_SESSION['documento'])->__set('cidade', $_SESSION['cidade'])->__set('endereco', $_SESSION['endereco'])->__set('bairro', $_SESSION['bairro'])->__set('telefone', $_SESSION['telefone'])->__set('segmento', $_SESSION['segmento'])->__set('sobrenos', $_SESSION['sobrenos'])->__set('foto_caminho', $_SESSION['foto_caminho'])->__set('foto_perfil', $_SESSION['foto_perfil'])->__set('possui_entrega', $_SESSION['possui_entrega'])->__set('valor_entrega', $_SESSION['valor_entrega']);

						}

					} else {

						$local_imagem = $_SESSION['foto_caminho'].$_SESSION['foto_perfil'];

						if(file_exists($local_imagem)) {

							unlink($local_imagem);
	
						}

						header("Location: /cadastre_se");
						die();

					}

					if($usuario->validarCadastro() && $usuario->getPorEmail() == false) {

						if($usuario->validarCidade()) {

							if($_SESSION['valida_tipo_usuario'] == 1) {

								if($usuario->salvar()) {

									session_destroy();
									setcookie('validar_email', '');

									header("Location: /login?act=sucesso");
									die();
			
								}

							}

							if($_SESSION['valida_tipo_usuario'] == 2) {

								$retorno = $usuario->salvar();

								if($retorno['fetch']) {

									$id_vendedor = $retorno['id_vendedor'];

									$usuario->horariosFuncionamento($id_vendedor, $_SESSION['horario_funcionamento']['segunda']['de'], $_SESSION['horario_funcionamento']['segunda']['ate'], $_SESSION['horario_funcionamento']['terca']['de'], $_SESSION['horario_funcionamento']['terca']['ate'], $_SESSION['horario_funcionamento']['quarta']['de'], $_SESSION['horario_funcionamento']['quarta']['ate'], $_SESSION['horario_funcionamento']['quinta']['de'], $_SESSION['horario_funcionamento']['quinta']['ate'], $_SESSION['horario_funcionamento']['sexta']['de'], $_SESSION['horario_funcionamento']['sexta']['ate'], $_SESSION['horario_funcionamento']['sabado']['de'], $_SESSION['horario_funcionamento']['sabado']['ate'], $_SESSION['horario_funcionamento']['domingo']['de'], $_SESSION['horario_funcionamento']['domingo']['ate']);

									session_destroy();
									setcookie('validar_email', '');

									header("Location: /login?act=sucesso");
									die();
			
								}

							}

						}

					} else {

						header("Location: /cadastre_se");
						die();

					}

				} else {

					$this->view->erro = 'codigo_invalido';
					$this->render('codigo_verificador','layout2');

				}

			}

		}

		if(isset($_COOKIE['codigo_verificador'])) {

			if(isset($_POST['codigo_verificador']) && !empty($_POST['codigo_verificador'])) {	

				$codigo_verificador = htmlspecialchars($_POST['codigo_verificador'], ENT_QUOTES, 'UTF-8');

				$codigo_hash = isset($_COOKIE['codigo_verificador']) ? $_COOKIE['codigo_verificador'] : '';

				$valida_verificador = password_verify($codigo_verificador, $codigo_hash);

				if($valida_verificador) {

					setcookie('autenticador_verificado', 'verificado', COOKIE_OPTIONS_TEMP);

					header("Location: /nova_senha");
					die();

				} else {

					$this->view->erro = 'codigo_invalido';
					$this->render('codigo_verificador','layout2');

				}

			}

		}

		$this->render('codigo_verificador','layout2');

	}

	public function novaSenha() {

		if(isset($_COOKIE['autenticador_verificado']) && $_COOKIE['autenticador_verificado'] == 'verificado') {

			if(isset($_POST['senha']) && isset($_POST['valida_senha'])) {

				//validar senha
				$padrao = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#\/])[A-Za-z\d@$!%*?&#\/]{8,20}$/';
				$senha = htmlspecialchars($_POST['senha'], ENT_QUOTES, 'UTF-8');
				$validasenha = htmlspecialchars($_POST['valida_senha'],ENT_QUOTES, 'UTF-8');

				if (preg_match($padrao, $senha) && $senha == $validasenha && strlen($senha) >= 8) {

					$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

					$id_usuario = $_COOKIE['id_usuario'];

					$tipo_usuario = $_COOKIE['tipo_usuario'];

					$tabela = '';

					if($tipo_usuario == '1') {

						$tabela = 'usuarios';

					}

					if($tipo_usuario == '2') {

						$tabela = 'vendedores';

					}

					$atualizar = Container::getModel('Usuario');

					$atualizado = $atualizar->atualizarSenha($tabela, $senha_hash, $id_usuario, $tipo_usuario);

					if($atualizado) {

						setcookie('codigo_verificador', '');

						setcookie('id_usuario', '');

						setcookie('tipo_usuario', '');

						setcookie('autenticador_verificado', '');

						header("Location: /login?act=senha_atualizada");
						die();

					} else {

						header("Location: /nova_senha?act=erro_inesperado");
						die();

					}

				} else {

					header("Location: /nova_senha?act=erro_padrao_senha");
					die();

				}

			}

		} else {

			header("Location: /codigo_verificador");
			die();

		}

		$this->render('nova_senha', 'layout2');

	}

	public function politicaPrivacidade() {

		$this->render('politica_de_privacidade', 'sem_layout');

	}

	public function termosCondicoes() {

		$this->render('termos_e_condicoes', 'sem_layout');

	}

}


?>