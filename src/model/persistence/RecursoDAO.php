<?php
namespace Fluxa\Persistence;

use Fluxa\Entity\Recurso;
use Fluxa\Entity\EnumRecursoStatus;
use \Slim\PDO\Database as PDO;
use library\UtilService;

class RecursoDAO {

	public function __construct() {

	}

	public function salvar(Recurso $recurso) {

		if (empty($recurso->getId())) {

			$strSQL = "INSERT INTO recurso(nome, detalhe, tipo_recurso, id_categoria, id_usuario, status, tipo_fluxo, id_endereco) ";
			$strSQL .= "VALUES (:nome, :detalhe, :tipo_recurso, :id_categoria, :id_usuario, :status, :tipo_fluxo, :id_endereco)";

			$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);

			$preSQL->bindValue(":nome", $recurso->getNome());
			$preSQL->bindValue(":detalhe", $recurso->getDetalhe());
			$preSQL->bindValue(":tipo_recurso", $recurso->getTipo());
			$preSQL->bindValue(":id_categoria", $recurso->getIdCategoria());
			$preSQL->bindValue(":id_usuario", $recurso->getIdUsuario());
			$preSQL->bindValue(":status", $recurso->getStatus());
			$preSQL->bindValue(":tipo_fluxo", $recurso->getTipoFluxo());
			$preSQL->bindValue(":id_endereco", $recurso->getIdEndereco());

			echo($recurso->getIdUsuario());

			$preSQL->execute();

			$recurso->setId(ConexaoPDO::getInstance()->lastInsertId());

		} else {

			$strSQL = "UPDATE recurso SET ";
			$strSQL .= "nome = :nome, ";
			$strSQL .= "detalhe = :detalhe, ";
			$strSQL .= "id_categoria = :id_categoria, ";
			$strSQL .= "status = :status, ";
			$strSQL .= "tipo_fluxo = :tipo_fluxo, ";
			$strSQL .= "id_endereco = :id_endereco ";
			$strSQL .= "WHERE id = :id";

			$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);

			$preSQL->bindValue(":nome", $recurso->getNome());
			$preSQL->bindValue(":detalhe", $recurso->getDetalhe());
			$preSQL->bindValue(":id_categoria", $recurso->getIdCategoria());
			$preSQL->bindValue(":id", $recurso->getId());
			$preSQL->bindValue(":status", $recurso->getStatus());
			$preSQL->bindValue(":tipo_fluxo", $recurso->getTipoFluxo());
			$preSQL->bindValue(":id_endereco", $recurso->getIdEndereco());

			$preSQL->execute();

		}

		return $recurso;

	}

	public function buscarPotencialidades($idUsuario = null, $qtdeMaxRegistros = null, $sohRecursoAtivo = false) {

		$strSQL = "SELECT * FROM recurso ";
		$strSQL .= "WHERE tipo_recurso = :tipo ";

		if(!empty($idUsuario)){
			$strSQL .= "AND id_usuario = :id_usuario ";
		}

		if(!empty($sohRecursoAtivo)){
			$strSQL .= "AND status != :status ";
		}

		$strSQL .= "ORDER BY nome ASC ";

		if(!empty($qtdeMaxRegistros)){
			$strSQL .= "LIMIT :qtde ";	
		}	

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
		
		if(!empty($idUsuario)){
			$preSQL->bindValue(":id_usuario", $idUsuario);
		}

		if(!empty($qtdeMaxRegistros)){
			$preSQL->bindValue(":qtde", $qtdeMaxRegistros);	
		}

		if(!empty($sohRecursoAtivo)){
			$preSQL->bindValue(":status", EnumRecursoStatus::INDISPO);	
		}

		$preSQL->bindValue(":tipo", Recurso::TIPO_POTENCIALIDADE);
		$preSQL->execute();

		return $preSQL->fetchAll(PDO::FETCH_CLASS, "Fluxa\Entity\Recurso");

	}

	public function buscarPossibilidades($idUsuario = null, $qtdeMaxRegistros = null, $sohRecursoAtivo = false) {

		$strSQL = "SELECT * FROM recurso ";
		$strSQL .= "WHERE tipo_recurso = :tipo ";
		
		if(!empty($idUsuario)){
			$strSQL .= "AND id_usuario = :id_usuario ";	
		}

		if(!empty($sohRecursoAtivo)){
			$strSQL .= "AND status != :status ";
		}

		$strSQL .= "ORDER BY nome ASC ";
		
		if(!empty($qtdeMaxRegistros)){
			$strSQL .= "LIMIT :qtde ";	
		}		

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
		
		if(!empty($idUsuario)){
			$preSQL->bindValue(":id_usuario", $idUsuario);
		}

		if(!empty($qtdeMaxRegistros)){
			$preSQL->bindValue(":qtde", $qtdeMaxRegistros);	
		}

		if(!empty($sohRecursoAtivo)){
			$preSQL->bindValue(":status", EnumRecursoStatus::INDISPO);	
		}

		$preSQL->bindValue(":tipo", Recurso::TIPO_POSSIBILIDADE);
		$preSQL->execute();

		return $preSQL->fetchAll(PDO::FETCH_CLASS, "Fluxa\Entity\Recurso");

	}

	public function buscarPorId($idRecurso, $idUsuario = null) {

		if (empty($idRecurso)) {
			return null;
		}

		$strSQL = "SELECT * FROM recurso ";
		$strSQL .= "WHERE id = :id ";

		if(!empty($idUsuario)){
			$strSQL .= "AND id_usuario = :id_usuario ";	
		}

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
		$preSQL->bindValue(":id", $idRecurso);
		
		if(!empty($idUsuario)){
			$preSQL->bindValue(":id_usuario", $idUsuario);
		}

		$preSQL->execute();

		$result = $preSQL->fetchAll(PDO::FETCH_CLASS, "Fluxa\Entity\Recurso");

		if (count($result) > 0) {
			return $result[0];
		}

		return null;

	}

	public function buscarPorNome($nome, $tipoRecurso = null, $sohRecursoAtivo = false) {

		if (empty($nome)) {
			return null;
		}

		$strSQL = "SELECT * FROM recurso where 1 = 1 ";

		if ( $nome != ""){

		            $strSQL .= "and nome LIKE :nome ";
		}

		if(!empty($tipoRecurso)){
			$strSQL .= "AND tipo_recurso = :tipo ";
		}

		if(!empty($sohRecursoAtivo)){
			$strSQL .= "AND status != :status ";
		}

		//die( $strSQL ." - ". $nome);

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);


		if ( $nome != ""){
		        $preSQL->bindValue(":nome", $nome."%");
		}

		if(!empty($tipoRecurso)){
			$preSQL->bindValue(":tipo", $tipoRecurso);
		}

		if(!empty($sohRecursoAtivo)){
			$preSQL->bindValue(":status", EnumRecursoStatus::INDISPO);	
		}

		$preSQL->execute();

		return $preSQL->fetchAll(PDO::FETCH_CLASS, "Fluxa\Entity\Recurso");

	}

	public function getQtdeTotalRecursos($tipoRecurso = null, $sohRecursoAtivo = false) {

		$strSQL = "SELECT COUNT(*) FROM recurso ";

		if(!empty($tipoRecurso)){
			$strSQL .= "WHERE tipo_recurso = :tipo ";
		}

		if(!empty($sohRecursoAtivo)){
			$strSQL .= "AND status != :status ";
		}

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);

		if(!empty($tipoRecurso)){
			$preSQL->bindValue(":tipo", $tipoRecurso);
		}

		if(!empty($sohRecursoAtivo)){
			$preSQL->bindValue(":status", EnumRecursoStatus::INDISPO);	
		}

		$preSQL->execute();

		return $preSQL->fetchColumn();

	}

	public function getQtdeTotalRecursosPorUsuario($idUsuario, $tipoRecurso = null, $sohRecursoAtivo = false) {

		$strSQL = "SELECT COUNT(*) FROM recurso ";
		$strSQL .= "WHERE id_usuario = :id_usuario ";

		if(!empty($tipoRecurso)){
			$strSQL .= "AND tipo_recurso = :tipo ";
		}

		if(!empty($sohRecursoAtivo)){
			$strSQL .= "AND status != :status ";
		}

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
		$preSQL->bindValue(":id_usuario", $idUsuario);

		if(!empty($tipoRecurso)){
			$preSQL->bindValue(":tipo", $tipoRecurso);
		}

		if(!empty($sohRecursoAtivo)){
			$preSQL->bindValue(":status", EnumRecursoStatus::INDISPO);	
		}

		$preSQL->execute();

		return $preSQL->fetchColumn(); ;

	}

	public function buscaNomesRecurso($query) {

		$strSQL = "SELECT DISTINCT nome FROM recurso ";
		$strSQL .= "WHERE UPPER(nome) LIKE UPPER(:query)";

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
		$preSQL->bindValue(":query", $query."%");
		$preSQL->execute();

		$resultado = $preSQL->fetchAll();
		
		return $resultado;

	}

	public function remover(Recurso $recurso) {

		$strSQL = "DELETE FROM recurso ";
		$strSQL .= "WHERE id = :id";

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
		$preSQL->bindValue(":id", $recurso->getId());
		return $preSQL->execute();

	}
        
        public function getByIdApi($oConn, $id ){
            
            $registro = \library\persist\connAccess::fastOne($oConn, "recurso", " id = ". $id);
            $registro_dados =  \library\persist\connAccess::fastOne($oConn, "recurso_dados", " id = ". $id);
            $registro["status_nome"] = EnumRecursoStatus::getValueView($registro["status"] );
            $registro["dados"] = $registro_dados;
            
            return $registro;
            
        }
        public function deleteApi ( $oConn, $id  ){
            \library\persist\connAccess::executeCommand($oConn, "delete from recurso where id = ". $id );
            \library\persist\connAccess::executeCommand($oConn, "delete from recurso_dados where id = ". $id );
        }
        
        public function getCurrentBDdate()
		{
				return date("Y-m-d H:i:s");	
		}
        public function saveApi($oConn, $request, &$reg, &$reg_dados){

                            $reg["nome"] = $request->getParsedBodyParam('nome');  
                            $reg["detalhe"] = $request->getParsedBodyParam('detalhe');  
                            $reg["tipo_recurso"] = $request->getParsedBodyParam('tipo_recurso');  
                            $reg["id_categoria"] = $request->getParsedBodyParam('id_categoria');  
                            $reg["status"] = $request->getParsedBodyParam('status');  
                            $reg["tipo_fluxo"] = $request->getParsedBodyParam('tipo_fluxo'); 
                            $reg["id_usuario"] = $GLOBALS["id_usuario_api"];
                            if ( @$reg["created_at"]  == ""){
                                      $reg["created_at"] = $this->getCurrentBDdate();
                            }
                            
                           
                            $reg["updated_at"] = $this->getCurrentBDdate();
                            
                            
                            $reg_dados["objetivo"] = $request->getParsedBodyParam('objetivo');  
                            $reg_dados["objetivo_ods"] = $request->getParsedBodyParam('objetivo_ods');  
                            $reg_dados["dimensao"] = $request->getParsedBodyParam('dimensao');  
                            $reg_dados["recursos"] = $request->getParsedBodyParam('recursos');  
                            $reg_dados["categoria"] = $request->getParsedBodyParam('categoria');  
                            
                            \library\persist\connAccess::nullBlankColumns($reg);
                            \library\persist\connAccess::nullBlankColumns($reg_dados);
                            
                            if ( ! @$reg["id"]){
                               $reg["id"] =  \library\persist\connAccess::Insert($oConn, $reg, "recurso", "id", true);
                               $reg_dados["id"] =  $reg["id"];
                               
                               \library\persist\connAccess::Insert($oConn, $reg_dados, "recurso_dados", "id", false);
                            }else{
                                \library\persist\connAccess::Update($oConn, $reg, "recurso", "id");
                                
                                $id_tmp = \library\persist\connAccess::executeScalar($oConn, "select id from recurso_dados where id = ". $reg["id"]);
                                
                                if ( !$id_tmp ){
                                       \library\persist\connAccess::Insert($oConn, $reg_dados, "recurso_dados", "id", false);
                                    
                                }else{
                                       \library\persist\connAccess::Update($oConn, $reg_dados, "recurso_dados", "id");
                                    
                                }
                                
                            }
	}

	public function adicionarFilho($oConn, $id_recurso_pai, $id_recurso_filho, $tipo ){
		$reg = array();
                
                $id_tmp = \library\persist\connAccess::executeScalar($oConn, "select id from recurso_associacao where id_recurso_pai = ".
                          $id_recurso_pai. " and id_recurso_filho = ". $id_recurso_filho);
                
                if ( $id_tmp != ""){
                    return $id_tmp;
                }
                
		                $reg["id_recurso_pai"] = $id_recurso_pai;
		                $reg["id_usuario_recurso_pai"] = \library\persist\connAccess::executeScalar($oConn, "select id_usuario from recurso where id =  ".
                        $id_recurso_pai);
		                $reg["id_recurso_filho"] = $id_recurso_filho;
		                $reg["id_usuario_recurso_filho"] = \library\persist\connAccess::executeScalar($oConn, "select id_usuario from recurso where id =  ".
                        $id_recurso_filho);
                $reg["date_insert"] = $this->getCurrentBDdate();
                $reg["tipo"] =$tipo;
                
                \library\persist\connAccess::nullBlankColumns($reg);
                
                $id_tmp = \library\persist\connAccess::Insert($oConn, $reg, "recurso_associacao", "id", true);
                
                return $id_tmp;


	}
        
        public function getListFilho($oConn, $id_recurso_pai, $tipo = "" ){
            
            $sql = "select r.id, re.nome as nome_recurso_pai, refilho.nome as nome_recurso_filho, upper( concat(refilho.tipo_recurso, ' - ', refilho.tipo_fluxo)) as tipo_filho "
                    . "  from recurso_associacao r "
                    . "  left join recurso re on re.id = r.id_recurso_pai "
                    . "  left join recurso refilho on refilho.id = r.id_recurso_filho where 1 = 1 ";
            
            if ( $id_recurso_pai != ""){
                $sql .= " and r.id_recurso_pai = ". $id_recurso_pai;
            }
            if ( $tipo != ""){
                $sql .= " and r.tipo = '". $tipo."' ";
            }
            
            $sql .= " order by refilho.nome ";
            
            $lista = \library\persist\connAccess::fetchData($oConn, $sql);
            
            return $lista;
            
        }

}

?>
